<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CafeController extends Controller
{
    // Metode untuk memperbarui status cafe
    public function updateStatus(Request $request)
    {
        // Validasi input
        $request->validate(['status' => 'required|string']);

        // Simpan status ke session atau database
        session(['cafeStatus' => $request->status]);

        // Kembalikan respons JSON
        return response()->json(['message' => 'Status cafe updated successfully.']);
    }
}
