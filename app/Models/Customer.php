<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'no_customer', 'address', 'phone'];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($customer) {
            $customer->id = Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
