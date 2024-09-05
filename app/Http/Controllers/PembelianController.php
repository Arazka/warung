<?php

namespace App\Http\Controllers;

use App\Http\Requests\PembelianRequest;
use App\Models\Item;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelians = Pembelian::with('item')->latest()->paginate(5);

        return view('pembelian.index', compact('pembelians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pembelian.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PembelianRequest $request)
    {
        try {
            $pembelian = new Pembelian();
            $pembelian->item_id = $request->item_id;
            $pembelian->kuantiti = $request->kuantiti;
            $pembelian->total_harga = $request->total_harga;
            $pembelian->waktu_pembelian = date('Y-m-d', strtotime($request->waktu_pembelian));

            $item = Item::findOrFail($request->item_id);
            $item->update([
                'stok' => $item->stok + $request->kuantiti,
            ]);

            return redirect()->route('pembelian.index')->with('success','Pembelian Berhasil Dibuat!');

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
        $pembelian = Pembelian::findOrFail($id);

        return view('pembelian.edit', compact('pembelian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PembelianRequest $request, $id)
    {
        try {
            $pembelian = Pembelian::findOrFail($id);
            $item = Item::findOrFail($pembelian->item_id);

            $item->update([
                'stok' => $item->stok - $pembelian->kuantiti,
            ]);

            $pembelian->item_id = $request->item_id;
            $pembelian->kuantiti = $request->kuantiti;
            $pembelian->total_harga = $request->total_harga;
            $pembelian->waktu_pembelian = date('Y-m-d', strtotime($request->waktu_pembelian));

            $item = Item::findOrFail($request->item_id);
            $item->update([
                'stok' => $item->stok + $request->kuantiti,
            ]);

            return redirect()->route('pembelian.index')->with('success','Pembelian Berhasil Dibuat!');

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
            $pembelian = Pembelian::findOrFail($id);
            $item = Item::findOrFail($pembelian->item_id);

            $item->update([
                'stok' => $item->stok - $pembelian->kuantiti,
            ]);

            $pembelian->delete();

            return redirect()->back()->with('success','Pembelian Berhasil Dihapus!');

        } catch (\Throwable $e) {
            return redirect()->back()->with('danger','Terdapat kesalahan: '.$e->getMessage());
        }
    }
}
