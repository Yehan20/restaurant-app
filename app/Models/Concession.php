<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concession extends Model
{
    //
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'concession_order');
    }
}
