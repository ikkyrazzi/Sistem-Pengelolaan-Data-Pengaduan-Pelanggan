<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'subject',
        'description',
        'category',
        'priority',
        'status',
        'assigned_technician_id',
        'schedule'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($complaint) {
            $complaint->id = Str::uuid();
        });
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function assignedTechnician()
    {
        return $this->belongsTo(User::class, 'assigned_technician_id');
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function cus()
    {
        return $this->belongsTo(Customer::class);
    }
}
