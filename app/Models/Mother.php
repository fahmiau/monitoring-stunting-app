<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mother extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function childrens()
    {
        return $this->hasMany(Children::class);
    }

    public function provinsi()
    {
        return $this->hasOne(Provinsi::class);
    }

    public function kota_kabupaten()
    {
        return $this->hasOne(KotaKabupaten::class);
    }

    public function kecamatan()
    {
        return $this->hasOne(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->hasOne(Kelurahan::class);
    }

}
