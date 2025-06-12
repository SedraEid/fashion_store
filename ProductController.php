<?php

namespace App\Http\Controllers;



use App\Models\Category;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Seller;
use App\Models\SkinToneColor;
use App\Models\ProductImage;
use App\Models\ProductSkinTone;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $user = auth('sanctum')->user();

        if (!$user || $user->user_type != 1) {
            return response()->json([
                'message' => 'غير مصرح لك بإضافة منتج'
            ], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'sizes' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'images' => 'required|array',
            'images.*.image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*.image_color' => 'required|string',

        ]);

        $product = Product::create([
            'seller_id' => $user->seller->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sizes' => $request->sizes,
            'discount_percentage' => $request->discount_percentage,
        ]);

        // حفظ الصور وربطها بلون البشرة المناسب
        foreach ($request->images as $img) {
            $path = $img['image_file']->store('products', 'public');

            $image = ProductImage::create([
                'product_id' => $product->id,
                'image_url' => '/storage/' . $path,  
                'image_color' => $img['image_color'],
            ]);

            $skinTone = $this->getSkinToneByColor($img['image_color']);
            if ($skinTone) {
                ProductSkinTone::create([
                    'product_id' => $product->id,
                    'product_image_id' => $image->id,
                    'skin_tone_id' => $skinTone->id,
                ]);
            }
        }

       // إرسال إشعارات لكل المستخدمين عند إضافة منتج جديد بخصم
$discount = $product->discount_percentage;

$firebase = new FirebaseService();

if ($discount > 0) {
    $users = \App\Models\User::where('user_type', 1)->get();

    foreach ($users as $targetUser) {
        if ($targetUser->seller) {
            \App\Models\Notification::create([
                'user_id' => $targetUser->id,
                'type' => 'offer',
                'title' => 'عرض جديد!',
                'message' => "تم إضافة منتج جديد '{$product->name}' بخصم {$discount}٪! لا تفوّت الفرصة.",
            ]);
        }
    }
}


  // إرسال إشعار 
    if ($targetUser->device_token) {
        $firebase->sendNotificationToToken(
            $targetUser->device_token,
            'عرض جديد!',
            "تم إضافة منتج جديد '{$product->name}' بخصم {$discount}٪! لا تفوّت الفرصة."
        );
    }

return response()->json([
    'message' => 'تمت إضافة المنتج والصور وربط ألوان البشرة بنجاح',
    'product' => $product->load('productImages'),
], 201);

}


    private function getSkinToneByColor($colorName)
    {
        $skinToneColor = SkinToneColor::where('color_name', $colorName)->first();
        return $skinToneColor ? $skinToneColor->skinTone : null;
    }

    // لعرض المنتجات للبائع
 public function sellerProducts()
{
    $user = auth('sanctum')->user();

    // تأكيد إنو المستخدم هو بائع
    if (!$user || $user->user_type != 1) {
        return response()->json([
            'message' => 'غير مصرح لك بعرض المنتجات'
        ], 403);
    }

   
    $seller = $user->seller; 

    if (!$seller) {
        return response()->json([
            'message' => 'لم يتم العثور على معلومات البائع'
        ], 404);
    }

    $products = Product::with([
        'productImages',
        'skinTones.skinTone',
    ])->where('seller_id', $seller->id)->latest()->get();

    return response()->json([
        'products' => $products
    ]);
}




    public function allProducts()
    {
        $products = Product::select([
                'id', 
                'seller_id', 
                'category_id', 
                'name', 
                'description', 
                'price', 
                'quantity', 
                'sizes', 
                'discount_percentage', 
                'created_at', 
                'updated_at'
            ])
            ->orderBy('id', 'asc') 
            ->get();
    
        return response()->json([
            'products' => $products
        ]);
    }



public function getProductCount(Request $request)
{
    $seller = Auth::user(); 

    if (!$seller) {
        return response()->json(['message' => 'لم يتم العثور على البائع'], 404);
    }

    $productCount = $seller->Products()->count(); 

    return response()->json(['product_count' => $productCount]);
}






public function allProducts_show()
{
    $products = Product::with([
            'seller:id,store_name',
             'productImages.skinToneMapping.skinTone'
        ])
        ->select([
            'id',
            'category_id',
            'seller_id',
            'name',
            'description',
            'price',
            'quantity',
            'sizes',
            'discount_percentage',
            'created_at',
            'updated_at'
        ])
        ->orderBy('id', 'asc')
        ->get()
        ->map(function ($product) {
            return [
                'id' => $product->id,
                'category_id' => $product->category_id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'sizes' => $product->sizes,
                'discount_percentage' => $product->discount_percentage,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'store_name' => optional($product->seller)->store_name,
               'images' => $product->productImages->map(function ($image) {
    return [
        'image_url' => $image->image_url,
        'image_color' => $image->image_color,
        'skin_tone' => optional(optional($image->skinToneMapping)->skinTone)->name,
    ];
}),

            ];
        });

    return response()->json([
        'products' => $products
    ]);
}







public function showProductDetails($id)
{
    $product = Product::with([
            'seller:id,store_name',
            'productImages.skinToneMapping.skinTone'
        ])
        ->select([
            'id',
            'category_id',
            'seller_id',
            'name',
            'description',
            'price',
            'quantity',
            'sizes',
            'discount_percentage',
            'created_at',
            'updated_at'
        ])
        ->findOrFail($id);

    $formattedProduct = [
        'id' => $product->id,
        'category_id' => $product->category_id,
        'name' => $product->name,
        'description' => $product->description,
        'price' => $product->price,
        'quantity' => $product->quantity,
        'sizes' => $product->sizes,
        'discount_percentage' => $product->discount_percentage,
        'created_at' => $product->created_at,
        'updated_at' => $product->updated_at,
        'store_name' => optional($product->seller)->store_name,
        'images' => $product->productImages->map(function ($image) {
            return [
                'image_url' => $image->image_url,
                'image_color' => $image->image_color,
                'skin_tone' => optional(optional($image->skinToneMapping)->skinTone)->name,
            ];
        }),
    ];

    return response()->json($formattedProduct);
}





















public function productsByCategory()
{
    $categories = Category::with([
        'products.seller:id,store_name',
        'products.productImages.skinToneMapping.skinTone'
    ])->get();

    $categories = $categories->map(function ($category) {
        return [
            'id' => $category->id,
            'name' => $category->category_name,
            'products' => $category->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'sizes' => $product->sizes,
                    'discount_percentage' => $product->discount_percentage,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                    'store_name' => optional($product->seller)->store_name,
                    'images' => $product->productImages->map(function ($image) {
                        return [
                            'image_url' => $image->image_url,
                            'image_color' => $image->image_color,
                            'skin_tone' => optional(optional($image->skinToneMapping)->skinTone)->name,
                        ];
                    }),
                ];
            }),
        ];
    });

    return response()->json($categories);
}












////////////////////////////////////////////////////////////////


//////////////////////البحث العادي
public function search(Request $request)
{
    $request->validate([
        'query' => 'required|string|min:2',
    ]);

    $searchTerm = $request->query('query');

    $products = Product::with(['productImages', 'category'])
        ->where('name', 'LIKE', '%' . $searchTerm . '%')
        ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'count' => $products->count(),
        'results' => $products
    ]);
}


///////////////////////////////////////////////  فلترة حسب اللون او السعر او الفئات


public function advancedSearch(Request $request)
{
    $request->validate([
        'query' => 'nullable|string|min:2',
        'color' => 'nullable|string',
        'min_price' => 'nullable|numeric|min:0',
        'max_price' => 'nullable|numeric|min:0',
        'category_name' => 'nullable|string',
    ]);

    $products = Product::with(['productImages', 'category'])
        ->when($request->filled('query'), function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->query('query') . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->query('query') . '%');
            });
        })
        ->when($request->filled('min_price'), function ($query) use ($request) {
            $query->where('price', '>=', $request->min_price);
        })
        ->when($request->filled('max_price'), function ($query) use ($request) {
            $query->where('price', '<=', $request->max_price);
        })
        ->when($request->filled('color'), function ($query) use ($request) {
            $query->whereHas('productImages', function ($q) use ($request) {
                $q->where('image_color', $request->color);
            });
        })
        ->when($request->filled('category_name'), function ($query) use ($request) {
            $category = Category::where('category_name', 'LIKE', '%' . $request->category_name . '%')->first();
            if ($category) {
                $query->where('category_id', $category->id);
            } else {
                $query->whereRaw('0=1');
            }
        })
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'count' => $products->count(),
        'results' => $products,
    ]);
}











































//توصيات على الوان المنتجات حسب لون بشرة المستخدم 
public function recommendedProducts()
{
    $user = auth('sanctum')->user();

    if (!$user || $user->user_type != 0) {
        return response()->json(['message' => 'غير مصرح'], 403);
    }

    $customer = \App\Models\Customer::where('user_id', $user->id)->first();
    if (!$customer) {
        return response()->json(['message' => 'الزبون غير موجود'], 404);
    }

    $latestAnalysis = \App\Models\ImageAnaly::where('customer_id', $customer->id)
        ->latest()
        ->first();

    if (!$latestAnalysis) {
        return response()->json(['message' => 'لا يوجد تحليل لون بشرة'], 404);
    }

    $skinTone = \App\Models\SkinTone::where('name', $latestAnalysis->skin_tone_result)->first();

    if (!$skinTone) {
        return response()->json(['message' => 'نوع البشرة غير معروف'], 404);
    }

    $productIds = \App\Models\ProductSkinTone::where('skin_tone_id', $skinTone->id)
        ->pluck('product_id');

    $products = \App\Models\Product::with(['seller', 'productImages.skinToneMapping.skinTone'])
        ->whereIn('id', $productIds)
        ->get();

    $formattedProducts = $products->map(function ($product) {
        return [
            'id' => $product->id,
            'category_id' => $product->category_id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'quantity' => $product->quantity,
            'sizes' => $product->sizes,
            'discount_percentage' => $product->discount_percentage,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
            'store_name' => optional($product->seller)->store_name,
            'images' => $product->productImages->map(function ($image) {
                return [
                    'image_url' => $image->image_url,
                    'image_color' => $image->image_color,
                    'skin_tone' => optional(optional($image->skinToneMapping)->skinTone)->name,
                ];
            }),
        ];
    });

    return response()->json([
        'skin_tone' => $skinTone->name,
        'products' => $formattedProducts
    ]);
}

//عرض اخر المنتجات التي تمت اضافتها 


public function latestProducts()
{
    $products = \App\Models\Product::with(['productImages', 'seller'])
        ->orderBy('created_at', 'desc')
        ->take(10) // رجع آخر 10 منتجات
        ->get();

    $formattedProducts = $products->map(function ($product) {
        return [
            'id' => $product->id,
            'category_id' => $product->category_id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'quantity' => $product->quantity,
            'sizes' => $product->sizes,
            'discount_percentage' => $product->discount_percentage,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
            'store_name' => optional($product->seller)->store_name,
            'images' => $product->productImages->map(function ($image) {
                return [
                    'image_url' => $image->image_url,
                    'image_color' => $image->image_color,
                    'skin_tone' => optional(optional($image->skinToneMapping)->skinTone)->name,
                ];
            }),
        ];
    });

    return response()->json([
        'latest_products' => $formattedProducts
    ]);
}



//تعديل معلومات المنتج 

public function updateProduct(Request $request, $id)
{
    $user = auth('sanctum')->user();

    if (!$user || $user->user_type != 1) {
        return response()->json(['message' => 'غير مصرح'], 403);
    }

    $seller = $user->seller;
    $product = Product::findOrFail($id);

    if ($product->seller_id !== $seller->id) {
        return response()->json(['message' => 'غير مصرح لك بتعديل هذا المنتج'], 403);
    }

    $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'sometimes|required|numeric',
        'quantity' => 'sometimes|required|integer',
        'sizes' => 'nullable|string',
        'category_id' => 'sometimes|required|exists:categories,id',
        'discount_percentage' => 'nullable|integer|min:0|max:100',
    ]);

    // تحديث القيم إذا كانت موجودة
    foreach (['name', 'description', 'price', 'quantity', 'sizes', 'category_id', 'discount_percentage'] as $field) {
        if ($request->filled($field)) {
            $product->$field = $request->$field;
        }
    }

    $product->save();

    // تحميل العلاقات
    $product->load(['seller', 'productImages.skinToneMapping.skinTone']);

    // تنسيق البيانات
    $formattedProduct = [
        'id' => $product->id,
        'category_id' => $product->category_id,
        'name' => $product->name,
        'description' => $product->description,
        'price' => $product->price,
        'quantity' => $product->quantity,
        'sizes' => $product->sizes,
        'discount_percentage' => $product->discount_percentage,
        'created_at' => $product->created_at,
        'updated_at' => $product->updated_at,
        'store_name' => optional($product->seller)->store_name,
        'images' => $product->productImages->map(function ($image) {
            return [
                 'image_url' => $image->image_url,
                'image_color' => $image->image_color,
                'skin_tone' => optional(optional($image->skinToneMapping)->skinTone)->name,
            ];
        }),
    ];

    return response()->json([
        'message' => 'تم التعديل بنجاح',
        'product' => $formattedProduct,
    ]);
}




public function updateProductImages(Request $request, $productId)
{
    $user = auth('sanctum')->user();

    if (!$user || $user->user_type != 1) {
        return response()->json(['message' => 'غير مصرح'], 403);
    }

    $seller = $user->seller;

    $product = Product::findOrFail($productId);

    if ($product->seller_id !== $seller->id) {
        return response()->json(['message' => 'غير مصرح لك بتعديل صور هذا المنتج'], 403);
    }

    $request->validate([
        'images' => 'required|array',
        'images.*.image_color' => 'required|string',
        'images.*.image_file' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    foreach ($request->images as $imgData) {
        if (isset($imgData['image_file']) && $imgData['image_file'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $imgData['image_file']->store('images', 'public');

            $image = $product->productImages()->create([
                'image_url' => asset('storage/' . $path),
                'image_color' => $imgData['image_color'],
            ]);

            $skinTone = $this->getSkinToneByColor($imgData['image_color']);
            if ($skinTone) {
                \App\Models\ProductSkinTone::create([
                    'product_id' => $product->id,
                    'product_image_id' => $image->id,
                    'skin_tone_id' => $skinTone->id,
                ]);
            }
        }
    }

    return response()->json(['message' => 'تمت إضافة الصور وربطها بلون البشرة بنجاح']);
}






  //حذف المنتج
public function deleteProduct($id)
{
    $product = Product::findOrFail($id);

    if ($product->seller_id !== auth('sanctum')->id()) {
        return response()->json(['message' => 'غير مصرح بحذف هذا المنتج'], 403);
    }

    foreach ($product->productImages as $image) {
        \Storage::disk('public')->delete($image->image_url);
        $image->delete();
    }

    $product->delete();

    return response()->json(['message' => 'تم حذف المنتج بنجاح']);
}


//عدد المنتجات الخاص بالمتجر 

public function countProducts()
{
    $count = \App\Models\Product::count();

    return response()->json([
        'products_count' => $count
    ]);
}





//عرض المنتجات بكل المتجر مع اسم المتجر و اسم البائع 
public function allProductsWithStoreName()
{
    $products = \App\Models\Product::with(['productImages', 'category', 'seller.user'])
        ->latest()
        ->get()
        ->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'category' => $product->category?->category_name,
                'store_name' => $product->seller?->store_name,
                'seller_name' => $product->seller?->user?->name,
                'images' => $product->productImages->map(function ($img) {
                    return asset($img->image_url);
                }),
            ];
        });

    return response()->json([
        'count' => $products->count(),
        'products' => $products
    ]);
}
















}
