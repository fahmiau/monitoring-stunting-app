<?php

namespace App\Http\Controllers;

use App\Models\DataChildren;
use Illuminate\Http\Request;

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
            'message' => 'Data Bulanan Anak Telah Tersimpan'
        ];

        return response($response);
    }
}
