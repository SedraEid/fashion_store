<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_name',
        'user_id',
        'subscription_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
}
