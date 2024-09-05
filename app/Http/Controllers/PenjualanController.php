<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenjualanRequest;
use App\Models\Item;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualans = Penjualan::with('item')->latest()->paginate(5);

        return view('penjualan.index', compact('penjualans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penjualan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenjualanRequest $request)
    {
        try {
            $penjualan = new Penjualan();
            $penjualan->item_id = $request->item_id;
            $penjualan->kuantiti = $request->kuantiti;
            $penjualan->total_harga = $request->total_harga;
            $penjualan->waktu_penjualan = date('Y-m-d', strtotime($request->waktu_penjualan));

            $item = Item::findOrFail($request->item_id);
            $item->update([
                'stok' => $item->stok - $request->kuantiti,
            ]);

            return redirect()->route('penjualan.index')->with('success','Penjualan Berhasil Dibuat!');

        } catch (\Throwable $e) {
            return redirect()->back()->with('danger','Terdapat kesalahan: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        return view('penjualan.edit', compact('penjualan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenjualanRequest $request, $id)
    {
        try {
            $penjualan = Penjualan::findOrFail($id);
            $item = Item::findOrFail($penjualan->item_id);

            $item->update([
                'stok' => $item->stok + $penjualan->kuantiti,
            ]);

            $penjualan->item_id = $request->item_id;
            $penjualan->kuantiti = $request->kuantiti;
            $penjualan->total_harga = $request->total_harga;
            $penjualan->waktu_penjualan = date('Y-m-d', strtotime($request->waktu_penjualan));

            $item = Item::findOrFail($request->item_id);
            $item->update([
                'stok' => $item->stok - $request->kuantiti,
            ]);

            return redirect()->route('penjualan.index')->with('success','Penjualan Berhasil Dibuat!');

        } catch (\Throwable $e) {
            return redirect()->back()->with('danger','Terdapat kesalahan: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $penjualan = Penjualan::findOrFail($id);
            $item = Item::findOrFail($penjualan->item_id);

            $item->update([
                'stok' => $item->stok + $penjualan->kuantiti,
            ]);

            $penjualan->delete();

            return redirect()->back()->with('success','Penjualan Berhasil Dihapus!');

        } catch (\Throwable $e) {
            return redirect()->back()->with('danger','Terdapat kesalahan: '.$e->getMessage());
        }
    }
}
