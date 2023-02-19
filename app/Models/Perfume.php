<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfume extends Model
{
    use HasFactory;
    protected $fillable = [
        'perfume_name',
        'perfume_flavor',
        'perfume_country',
        'perfume_price',
        'perfume_image'
    ];
}
