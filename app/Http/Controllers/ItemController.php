<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with('kategori')->latest()->paginate(5);

        return view('item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        try {
            $item = new Item();
            $item->nama_item = $request->nama_item;
            $item->kategori_id = $request->kategori_id;
            $item->stok = $request->stok;
            $item->harga = $request->harga;
            $item->save();

            return redirect()->route('item.index')->with('success','Item Berhasil Dibuat!');

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
        $item = Item::findOrFail($id);

        return view('item.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request, $id)
    {
        try {
            $item = Item::findOrFail($id);
            $item->nama_item = $request->nama_item;
            $item->kategori_id = $request->kategori_id;
            $item->stok = $request->stok;
            $item->harga = $request->harga;
            $item->save();

            return redirect()->route('item.index')->with('success','Item Berhasil Diedit!');

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
            $item = Item::findOrFail($id);
            $item->delete();

            return redirect()->back()->with('success','Item Berhasil Dihapus!');

        } catch (\Throwable $e) {
            return redirect()->back()->with('danger','Terdapat kesalahan: '.$e->getMessage());
        }
    }
}
