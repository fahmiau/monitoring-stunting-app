<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeightBoy;

class WeightBoyController extends Controller
{
    public function all(){
        $response = WeightBoy::all();
        $weight_boy_temp = json_decode($response,true);
        $month = [];
        $m3sd = [];
        $m2sd = [];
        $m1sd = [];
        $median = [];
        $p3sd = [];
        $p2sd = [];
        $p1sd = [];
        for ($i=0; $i < 61; $i++) { 
            array_push($month,$weight_boy_temp[$i]['months']);
            array_push($m3sd,$weight_boy_temp[$i]['-3sd']);
            array_push($m2sd,$weight_boy_temp[$i]['-2sd']);
            array_push($m1sd,$weight_boy_temp[$i]['-1sd']);
            array_push($median,$weight_boy_temp[$i]['median']);
            array_push($p3sd,$weight_boy_temp[$i]['3sd']);
            array_push($p2sd,$weight_boy_temp[$i]['2sd']);
            array_push($p1sd,$weight_boy_temp[$i]['1sd']);
        }
        $weight_boy = [
            'months' => $month,
            'm3sd' => $m3sd,
            'm2sd' => $m2sd,
            'm1sd' => $m1sd,
            'median' => $median,
            'p3sd' => $p3sd,
            'p2sd' => $p2sd,
            'p1sd' => $p1sd,
            
        ];
        return response()->json($weight_boy);
    }
}
