<?php

namespace App\Http\Controllers;

use App\Models\DataChildren;
use App\Models\HeightBoy;
use App\Models\WeightBoy;
use App\Models\HeightGirl;
use App\Models\WeightGirl;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GraphController extends Controller
{
    public function dataProcess($data)
    {
        $month = [];
        $negative_3sd = [];
        $negative_2sd = [];
        $negative_1sd = [];
        $median = [];
        $positive_3sd = [];
        $positive_2sd = [];
        $positive_1sd = [];

        for ($i=0; $i < 61; $i++) { 
            array_push($month,$data[$i]['months']);
            array_push($negative_3sd,$data[$i]['negative_3sd']);
            array_push($negative_2sd,$data[$i]['negative_2sd']);
            array_push($negative_1sd,$data[$i]['negative_1sd']);
            array_push($median,$data[$i]['median']);
            array_push($positive_3sd,$data[$i]['positive_3sd']);
            array_push($positive_2sd,$data[$i]['positive_2sd']);
            array_push($positive_1sd,$data[$i]['positive_1sd']);
        }

        $graph_data = [
            'months' => $month,
            'negative_3sd' => $negative_3sd,
            'negative_2sd' => $negative_2sd,
            'negative_1sd' => $negative_1sd,
            'median' => $median,
            'positive_3sd' => $positive_3sd,
            'positive_2sd' => $positive_2sd,
            'positive_1sd' => $positive_1sd,
        ];

        return $graph_data;
    }

    public function getBoyWeight()
    {
        $response = WeightBoy::all();
        $weight_boy = $this->dataProcess($response);
        return response()->json($weight_boy);
    }

    public function getBoyHeight()
    {
        $response = HeightBoy::all();
        $height_boy = $this->dataProcess($response);
        return response()->json($height_boy);
    }

    public function getGirlWeight()
    {
        $response = WeightGirl::all();
        $weight_girl = $this->dataProcess($response);
        return response()->json($weight_girl);
    }

    public function getGirlHeight()
    {
        $response = HeightGirl::all();
        $height_girl = $this->dataProcess($response);
        return response()->json($height_girl);
    }

    public function getWithDataChildren($jk,$type,$children_id)
    {
        if ($type == 'weight') {
            $type = 'berat_badan';
            if ($jk == 'boy') {
                $data = $this->dataProcess(WeightBoy::all());
            } else {
                $data = $this->dataProcess(WeightGirl::all());
            }
        } else {
            $type = 'panjang_badan';
            if ($jk == 'boy') {
                $data = $this->dataProcess(HeightBoy::all());
            } else {
                $data = $this->dataProcess(HeightGirl::all());
            }
        }
        $data_children = DataChildren::where('children_id',$children_id)->orderBy('bulan_ke')->get($type);
        $data_children_clean = [];
        foreach ($data_children as $key => $value) {
            array_push($data_children_clean,$value[$type]);
        }
        $data['data_children'] = $data_children_clean;

        return response()->json($data);
    }
}
