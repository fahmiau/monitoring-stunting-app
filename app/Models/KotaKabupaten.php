<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KotaKabupaten extends Model
{
    use HasFactory;

    protected $fillable = ['id','provinsi_id','kota_kabupaten'];
    
    public $timestamps = false;


    public function kecamatans()
    {
        return $this->hasMany(Kecamatan::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
}
