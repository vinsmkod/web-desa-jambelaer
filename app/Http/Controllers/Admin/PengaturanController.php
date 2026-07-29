<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $settings = Pengaturan::where('group', '!=', 'tentang')
            ->orderBy('group')
            ->orderBy('id')
            ->get()
            ->groupBy('group');

        return view('admin.pengaturan.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token', '_method', 'kades_foto_file']);

        if ($request->hasFile('kades_foto_file')) {
            $file = $request->file('kades_foto_file');
            $filename = 'kades_' . time() . '_' . \Illuminate\Support\Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/kades'), $filename);
            $inputs['kades_foto'] = '/uploads/kades/' . $filename;
        }

        foreach ($inputs as $key => $value) {
            Pengaturan::set($key, $value);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}
