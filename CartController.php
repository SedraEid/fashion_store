<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
   
   public function index()
{
    $user = auth('sanctum')->user();

    if (!$user) {
        return response()->json([
            'message' => 'المستخدم غير مسجل الدخول',
        ], 401);
    }

    if ($user->user_type != 0) {
        return response()->json([
            'message' => 'غير مصرح لك بالدخول إلى السلة',
        ], 403);
    }

    $customer = \App\Models\Customer::where('user_id', $user->id)->first();

    if (!$customer) {
        return response()->json([
            'message' => 'لم يتم العثور على حساب الزبون'
        ], 404);
    }

    $cart = Cart::with(['items.product.productImages.skinToneMapping.skinTone'])
                ->where('customer_id', $customer->id)
                ->first();

    if (!$cart || $cart->items->isEmpty()) {
        return response()->json([
            'message' => 'السلة فارغة',
            'items' => [],
            'total_quantity' => 0,
            'total_price' => 0
        ]);
    }

    $items = $cart->items->map(function ($item) {
        $product = $item->product;

        return [
            'product_id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'discount_percentage' => $product->discount_percentage,
            'final_price' => $product->price * (1 - ($product->discount_percentage / 100)),
            'quantity' => $item->quantity,
            'size' => $item->size,
            'color' => $item->color,
            'images' => $product->productImages->map(function ($image) {
                return [
                    'image_url' => $image->image_url,
                    'image_color' => $image->image_color,
                    'skin_tone' => optional(optional($image->skinToneMapping)->skinTone)->name,
                ];
            }),
        ];
    });

    $totalQuantity = $cart->items->sum('quantity');
    $totalPrice = $items->sum(function ($item) {
        return $item['final_price'] * $item['quantity'];
    });

    return response()->json([
        'items' => $items,
        'total_quantity' => $totalQuantity,
        'total_price' => round($totalPrice, 2),
    ]);
}








public function addToCart(Request $request)
{
    $user = auth('sanctum')->user();

    if (!$user) {
        return response()->json(['message' => 'المستخدم غير مسجل الدخول'], 401);
    }

    if ($user->user_type != 0) {
        return response()->json(['message' => 'غير مصرح لك بالتعامل مع السلة'], 403);
    }

    // جلب العميل المرتبط بالمستخدم
    $customer = \App\Models\Customer::where('user_id', $user->id)->first();

    if (!$customer) {
        return response()->json(['message' => 'لا يوجد حساب زبون مرتبط بهذا المستخدم'], 404);
    }

    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'size' => 'nullable|string',
        'color' => 'nullable|string',
    ]);

    $cart = $customer->cart;

    if (!$cart) {
        return response()->json(['message' => 'السلة غير موجودة لهذا العميل'], 404);
    }

    $cartItem = $cart->items()
        ->where('product_id', $request->product_id)
        ->where('size', $request->size)
        ->where('color', $request->color)
        ->first();

    if ($cartItem) {
        $cartItem->quantity += $request->quantity;
        $cartItem->save();
    } else {
        $cart->items()->create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'size' => $request->size,
            'color' => $request->color,
        ]);
    }

    $cart->quantity = $cart->items()->sum('quantity');
    $cart->save();

    return response()->json(['message' => 'تمت إضافة المنتج إلى السلة بنجاح']);
}






public function updateCartItem(Request $request, $itemId)
{
    $user = auth('sanctum')->user();

    if (!$user) {
        return response()->json(['message' => 'غير مسجل الدخول'], 401);
    }

    if ($user->user_type != 0) {
        return response()->json(['message' => 'غير مصرح لك بالوصول'], 403);
    }

       $customerId = $user->customer->id;  

    $cart = Cart::where('customer_id', $customerId)->first();

    if (!$cart) {
        return response()->json(['message' => 'السلة غير موجودة للعميل'], 404);
    }

    $item = $cart->items()->where('id', $itemId)->first();

    if (!$item) {
        return response()->json(['message' => 'العنصر غير موجود في السلة'], 404);
    }

    $request->validate([
        'quantity' => 'required|integer|min:1',
        'size' => 'nullable|string',
        'color' => 'nullable|string',
    ]);

    $item->quantity = $request->quantity;
    if ($request->has('size')) {
        $item->size = $request->size;
    }
    if ($request->has('color')) {
        $item->color = $request->color;
    }
    $item->save();

    $cart->quantity = $cart->items()->sum('quantity');
    $cart->save();

    return response()->json(['message' => 'تم تحديث العنصر بنجاح']);
}










public function removeItem($itemId)
{
    $user = auth('sanctum')->user();

    if (!$user || $user->user_type != 0) {
        return response()->json(['message' => 'غير مصرح'], 403);
    }

    $customer = $user->customer;

    if (!$customer) {
        return response()->json(['message' => 'الزبون غير موجود'], 404);
    }

    $item = CartItem::find($itemId);

    if (!$item) {
        return response()->json(['message' => 'العنصر غير موجود'], 404);
    }

    if ($item->cart->customer_id != $customer->id) {
        return response()->json(['message' => 'لا تملك هذا العنصر'], 403);
    }

    $item->delete();

    $cart = $item->cart;
    $cart->quantity = $cart->items()->sum('quantity');
    $cart->save();

    return response()->json(['message' => 'تم حذف المنتج من السلة وتحديث الكمية']);
}








    
}
