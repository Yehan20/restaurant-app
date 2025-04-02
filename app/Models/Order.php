<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use SoftDeletes,HasFactory;

    protected $fillable = [
        'user_id',
        'send_to_kitchen_time',
        'status',
    ];

    public function concessions()
    {
        return $this->belongsToMany(Concession::class, 'concession_order');
    }
}
