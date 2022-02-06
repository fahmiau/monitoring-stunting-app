<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function dataChildrens()
    {
        return $this->hasMany(DataChildren::class);
    }

    public function statusChildren()
    {
        return $this->hasOne(StatusChildren::class);
    }

    public function mother()
    {
        return $this->belongsTo(Mother::class);
    }
}
