<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Budaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudayaController extends Controller
{
    public function index()
    {
        $budayaList = Budaya::orderBy('urutan')->orderBy('budaya_id')->paginate(5)->withQueryString();
        return view('admin.budaya.index', compact('budayaList'));
    }

    public function create()
    {
        return view('admin.budaya.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => ['required', 'string', 'max:50'],
            'title'    => ['required', 'string', 'max:100'],
            'excerpt'  => ['required', 'string', 'max:255'],
            'desc'     => ['required', 'string'],
            'img'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'urutan'   => ['nullable', 'integer', 'min:0'],
        ]);

        $imgPath = null;
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = 'budaya_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/budaya'), $filename);
            $imgPath = '/uploads/budaya/' . $filename;
        }

        Budaya::create([
            'created_by' => Auth::id(),
            'kategori'   => $request->kategori,
            'title'      => $request->title,
            'excerpt'    => $request->excerpt,
            'desc'       => $request->desc,
            'img'        => $imgPath,
            'urutan'     => $request->urutan ?? 0,
        ]);

        return redirect()->route('admin.budaya.index')->with('success', 'Budaya baru berhasil ditambahkan!');
    }

    public function edit(Budaya $budaya)
    {
        return view('admin.budaya.edit', compact('budaya'));
    }

    public function update(Request $request, Budaya $budaya)
    {
        $request->validate([
            'kategori' => ['required', 'string', 'max:50'],
            'title'    => ['required', 'string', 'max:100'],
            'excerpt'  => ['required', 'string', 'max:255'],
            'desc'     => ['required', 'string'],
            'img'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'urutan'   => ['nullable', 'integer', 'min:0'],
        ]);

        $imgPath = $budaya->img;
        if ($request->hasFile('img')) {
            if ($imgPath && file_exists(public_path($imgPath))) {
                @unlink(public_path($imgPath));
            }
            $file = $request->file('img');
            $filename = 'budaya_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/budaya'), $filename);
            $imgPath = '/uploads/budaya/' . $filename;
        }

        $budaya->update([
            'kategori' => $request->kategori,
            'title'    => $request->title,
            'excerpt'  => $request->excerpt,
            'desc'     => $request->desc,
            'img'      => $imgPath,
            'urutan'   => $request->urutan ?? 0,
        ]);

        return redirect()->route('admin.budaya.index')->with('success', 'Data budaya berhasil diperbarui!');
    }

    public function destroy(Budaya $budaya)
    {
        if ($budaya->img && file_exists(public_path($budaya->img))) {
            @unlink(public_path($budaya->img));
        }
        $budaya->delete();

        return redirect()->route('admin.budaya.index')->with('success', 'Budaya berhasil dihapus!');
    }
}
