<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemKategoriRequest;
use App\Models\ItemKategori;
use Illuminate\Http\Request;

class ItemKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = ItemKategori::latest()->paginate(5);

        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemKategoriRequest $request)
    {
        try {
            $kategori = new ItemKategori();
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->save();

            return redirect()->route('kategori.index')->with('success','Item Kategori Berhasil Dibuat!');

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
        $kategori = ItemKategori::findOrFail($id);

        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemKategoriRequest $request, $id)
    {
        try {
            $kategori = ItemKategori::findOrFail($id);
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->save();

            return redirect()->route('kategori.index')->with('success','Item Kategori Berhasil Diedit!');

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
            $kategori = ItemKategori::findOrFail($id);
            $kategori->delete();

            return redirect()->back()->with('success','Item Kategori Berhasil Dihapus!');

        } catch (\Throwable $e) {
            return redirect()->back()->with('danger','Terdapat kesalahan: '.$e->getMessage());
        }
    }
}
