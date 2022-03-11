<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\DataChildren;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DataChildrenController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'children_id' => 'required|exists:App\Models\Children,id',
            'tanggal' => 'required|date',
            'bulan_ke' => 'required|numeric|min:1',
            'tempat' => 'required|max:20',
            'berat_badan' => 'required|numeric',
            'panjang_badan' => 'required|numeric',
        ]);

        $data_children = DataChildren::create($validated);
        $response = [
            'data_children' => $data_children,
            'message' => 'success'
        ];

        return response($response);
    }

    public function getByChild($children_id)
    {
        $data_children = Children::find($children_id)->first()->with('dataChildrens')->get();
        if ($data_children == null) {
            return response(['message' => 'Data Bulanan Belum Ada']);
        }

        return response([
            'data' => $data_children,
            'message' => 'success'
        ]);
    }
}
