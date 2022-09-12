<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    
    protected $fillable = ['id','kota_kabupaten_id','kecamatan'];
    
    public $timestamps = false;

    public function kelurahans()
    {
        return $this->hasMany(Kelurahan::class);
    }

    public function kotaKabupaten()
    {
        return $this->belongsTo(KotaKabupaten::class);
    }
}
