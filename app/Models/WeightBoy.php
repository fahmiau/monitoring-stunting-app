<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeightBoy extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'months',
        'negative_3sd',
        'negative_2sd',
        'negative_1sd',
        'median',
        'positive_1sd',
        'positive_2sd',
        'positive_3sd',
    ];
}
