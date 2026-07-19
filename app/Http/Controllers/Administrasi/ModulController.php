<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Alert;

class ModulController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Modul::with('parent');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_modul', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('link_modul', 'like', "%{$search}%");
            });
        }

        $modul = $query->orderBy('par')->orderBy('id_modul')->paginate(20)->withQueryString();

        $totalAll = Modul::count();
        $totalAktif = Modul::where('aktif', 'Y')->count();
        $totalNonaktif = Modul::where('aktif', 'T')->count();

        $title = 'Hapus Data!';
        $text = "Data akan dihapus, Anda Yakin?";
        $page = 'Administrasi';
        $judul = 'Manajemen Modul';
        $subjudul = 'Kelola Modul / Menu Admin Panel';
        $Hjudul = $subjudul;

        return view('admin.modul.index', compact(
            'modul',
            'search',
            'totalAll',
            'totalAktif',
            'totalNonaktif',
            'title',
            'text',
            'page',
            'judul',
            'subjudul',
            'Hjudul'
        ));
    }

    public function create()
    {
        $parentList = Modul::where('par', 0)
            ->where('link_modul', '#')
            ->orderBy('nama_modul')
            ->get();

        $title = 'Tambah Modul';
        $page = 'Administrasi';
        $subjudul = 'Tambah Modul Baru';

        return view('admin.modul.create', compact(
            'parentList',
            'title',
            'page',
            'subjudul'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_modul' => 'required|string|max:50',
            'link_modul' => 'required|string|max:50',
            'icon' => 'required|string|max:50',
            'par' => 'nullable|integer',
            'role' => 'required|in:Administrator,Pangan,Pertanian,Peternakan,User',
            'publish' => 'required|in:Y,T',
            'aktif' => 'required|in:Y,T',
            'slug' => 'nullable|string|max:100',
            'folder' => 'nullable|string|max:100',
        ]);

        $modul = new Modul();
        $modul->nama_modul = $request->nama_modul;
        $modul->link_modul = $request->link_modul;
        $modul->icon = $request->icon;
        $modul->par = $request->par ?? 0;
        $modul->role = $request->role;
        $modul->role_id = $request->role_id ?? 0;
        $modul->publish = $request->publish;
        $modul->aktif = $request->aktif;
        $modul->slug = $request->slug ?: Str::slug($request->nama_modul);
        $modul->folder = $request->folder;
        $modul->save();

        Alert::success('Berhasil', 'Data modul berhasil disimpan.');

        return redirect()->route('admin.modul.index');
    }

    public function edit($id)
    {
        $modul = Modul::findOrFail($id);

        $parentList = Modul::where('par', 0)
            ->where('link_modul', '#')
            ->where('id_modul', '!=', $id)
            ->orderBy('nama_modul')
            ->get();

        $title = 'Edit Modul';
        $page = 'Administrasi';
        $subjudul = 'Edit Modul';

        return view('admin.modul.edit', compact(
            'modul',
            'parentList',
            'title',
            'page',
            'subjudul'
        ));
    }

    public function update(Request $request, $id)
    {
        $modul = Modul::findOrFail($id);

        $request->validate([
            'nama_modul' => 'required|string|max:50',
            'link_modul' => 'required|string|max:50',
            'icon' => 'required|string|max:50',
            'par' => 'nullable|integer',
            'role' => 'required|in:Administrator,Pangan,Pertanian,Peternakan,User',
            'publish' => 'required|in:Y,T',
            'aktif' => 'required|in:Y,T',
            'slug' => 'nullable|string|max:100',
            'folder' => 'nullable|string|max:100',
        ]);

        $modul->nama_modul = $request->nama_modul;
        $modul->link_modul = $request->link_modul;
        $modul->icon = $request->icon;
        $modul->par = $request->par ?? 0;
        $modul->role = $request->role;
        $modul->role_id = $request->role_id ?? 0;
        $modul->publish = $request->publish;
        $modul->aktif = $request->aktif;
        $modul->slug = $request->slug ?: Str::slug($request->nama_modul);
        $modul->folder = $request->folder;
        $modul->save();

        Alert::success('Berhasil', 'Data modul berhasil diperbarui.');

        return redirect()->route('admin.modul.index');
    }

    public function destroy($id)
    {
        $modul = Modul::findOrFail($id);

        Modul::where('par', $id)->update(['par' => 0]);

        $modul->delete();

        Alert::success('Berhasil', 'Data modul berhasil dihapus.');

        return redirect()->route('admin.modul.index');
    }

    public function toggleAktif($id)
    {
        $modul = Modul::findOrFail($id);
        $modul->aktif = $modul->aktif === 'Y' ? 'T' : 'Y';
        $modul->save();

        return redirect()->back()->with('success', 'Status aktif modul berhasil diperbarui.');
    }

    public function togglePublish($id)
    {
        $modul = Modul::findOrFail($id);
        $modul->publish = $modul->publish === 'Y' ? 'T' : 'Y';
        $modul->save();

        return redirect()->back()->with('success', 'Status publish modul berhasil diperbarui.');
    }
}
