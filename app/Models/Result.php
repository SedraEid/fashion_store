<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\customer;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'result_value',
    ];

 
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
