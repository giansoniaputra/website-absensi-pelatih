<?php

namespace App\Http\Controllers;

use App\Models\Ranting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RantingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Ranting',
            'title_page' => 'Data Ranting',
        ];
        return view('ranting.index', $data);
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
            'kode_ranting' => 'required|unique:rantings',
            'nama_ranting' => 'required',
            'jenjang' => 'required',
        ];
        $pesan = [
            'kode_ranting.required' => "Kode ranting tidak boleh kosong",
            'kode_ranting.unique' => "Kode ranting sudah terdaftar",
            'nama_ranting.required' => "Nama ranting tidak boleh kosong",
            'jenjang.required' => "Jenjang tidak boleh kosong",
        ];
        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $data = [
                'unique' => Str::orderedUuid(),
                'kode_ranting' => $request->kode_ranting,
                'nama_ranting' => $request->nama_ranting,
                'jenjang' => $request->jenjang,
            ];
            Ranting::create($data);
            return response()->json(['success' => 'Data Ranting Berhasil Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ranting $ranting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ranting $ranting)
    {
        return response()->json(['data' => $ranting]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ranting $ranting)
    {
        $cek = Ranting::where('kode_ranting', $request->kode_ranting)->first();
        $rules = [
            'kode_ranting' => 'required|unique:rantings',
            'nama_ranting' => 'required',
            'jenjang' => 'required',
        ];
        $pesan = [
            'kode_ranting.required' => "Kode ranting tidak boleh kosong",
            'kode_ranting.unique' => "Kode ranting sudah terdaftar",
            'nama_ranting.required' => "Nama ranting tidak boleh kosong",
            'jenjang.required' => "Jenjang tidak boleh kosong",
        ];
        if ($cek && $ranting->kode_ranting != $request->kode_ranting) {
            $rules['kode_ranting'] = 'required|unique:rantings';
            $pesan['kode_ranting.required'] = 'Kode ranting tidak boleh kosong';
            $pesan['kode_ranting.unique'] = 'Kode ranting sudah terdaftar';
        } else {
            $rules['kode_ranting'] = 'required';
            $pesan['kode_ranting.required'] = 'Kode ranting tidak boleh kosong';
        }
        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $data = [
                'kode_ranting' => $request->kode_ranting,
                'nama_ranting' => $request->nama_ranting,
                'jenjang' => $request->jenjang,
            ];
            Ranting::where('unique', $ranting->unique)->update($data);
            return response()->json(['success' => 'Data Ranting Berhasil Diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ranting $ranting)
    {
        Ranting::where('unique', $ranting->unique)->delete();
        return response()->json(['success' => "Data Ranting Berhasil Dihapus"]);
    }

    public function dataTabless(Request $request)
    {
        $query = Ranting::all();
        return DataTables::of($query)->addColumn('action', function ($row) {
            $actionBtn =
                '
                <button class="btn btn-rounded btn-sm btn-warning text-dark edit-button" title="Edit Data" data-unique="' . $row->unique . '"><i class="fas fa-edit"></i></button>
                <button class="btn btn-rounded btn-sm btn-danger text-white delete-button" title="Hapus Data" data-unique="' . $row->unique . '" data-token="' . csrf_token() . '"><i class="fas fa-trash-alt"></i></button>';
            return $actionBtn;
        })->make(true);
    }
}
