<?php

namespace App\Http\Controllers;

use App\Models\Pelatih;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PelatihController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Pelatih',
            'title_page' => 'Data Pelatih',
        ];
        return view('pelatih.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nra' => 'required|unique:pelatihs',
            'nama' => 'required',
            'tingkatan' => 'required',
            'jabatan' => 'required',
        ];
        $pesan = [
            'nra.required' => 'NRA tidak boleh kosong',
            'nra.unique' => 'NRA sudah terdaftar',
            'nama.required' => 'Nama tidak boleh kosong',
            'tingkatan.required' => 'Tingkatan tidak boleh kosong',
            'jabatan.required' => 'Jabatan tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $data = [
                'unique' => Str::orderedUuid(),
                'nra' => $request->nra,
                'nama' => $request->nama,
                'tingkatan' => $request->tingkatan,
                'jabatan' => $request->jabatan,
            ];
            Pelatih::create($data);
            return response()->json(['success' => 'Data Berhasil Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelatih $pelatih)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelatih $pelatih)
    {
        return response()->json(['data' => $pelatih]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelatih $pelatih)
    {
        $cek = Pelatih::where('nra', $request->nra)->first();
        $rules = [
            'nama' => 'required',
            'tingkatan' => 'required',
            'jabatan' => 'required',
        ];
        $pesan = [
            'nama.required' => 'Nama tidak boleh kosong',
            'tingkatan.required' => 'Tingkatan tidak boleh kosong',
            'jabatan.required' => 'Jabatan tidak boleh kosong',
        ];
        if ($cek && $request->nra != $pelatih->nra) {
            $rules['nra'] = 'required|unique:pelatihs';
            $pesan['nra.required'] = 'NRA tidak boleh kosong';
            $pesan['nra.unique'] = 'NRA sudah terdaftar';
        } else {
            $rules['nra'] = 'required';
            $pesan['nra.required'] = 'NRA tidak boleh kosong';
        }
        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $data = [
                'nra' => $request->nra,
                'nama' => $request->nama,
                'tingkatan' => $request->tingkatan,
                'jabatan' => $request->jabatan,
            ];
            Pelatih::where('unique', $pelatih->unique)->update($data);
            return response()->json(['success' => 'Data Berhasil Diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelatih $pelatih)
    {
        Pelatih::where('unique', $pelatih->unique)->delete();
        return response()->json(['success' => 'Data Berhasil Dihapus']);
    }

    public function dataTabless(Request $request)
    {
        $query = Pelatih::all();
        return DataTables::of($query)->addColumn('action', function ($row) {
            $actionBtn =
                '
                <button class="btn btn-rounded btn-sm btn-warning text-dark edit-button" title="Edit Data" data-unique="' . $row->unique . '"><i class="fas fa-edit"></i></button>
                <button class="btn btn-rounded btn-sm btn-danger text-white delete-button" title="Hapus Data" data-unique="' . $row->unique . '" data-token="' . csrf_token() . '"><i class="fas fa-trash-alt"></i></button>';
            return $actionBtn;
        })->make(true);
    }
}
