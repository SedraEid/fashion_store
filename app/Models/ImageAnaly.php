<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageAnaly extends Model
{

    protected $table = 'image_analysis';  

    protected $fillable = ['image_url', 'skin_tone_result', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
