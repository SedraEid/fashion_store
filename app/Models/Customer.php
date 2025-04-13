<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'user_id', 'results_id', 'image_analysis_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
public function profile()
{
    return $this->hasOneThrough(Profile::class, User::class);
}

public function imageAnalysis()
{
    return $this->hasOne(ImageAnaly::class);
}

}
