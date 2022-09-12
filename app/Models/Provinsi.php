<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $fillable = ['id','provinsi'];
    
    public $timestamps = false;

    public function kotaKabupatens()
    {
        return $this->hasMany(KotaKabupaten::class);
    }
}
