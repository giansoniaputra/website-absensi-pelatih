<?php

namespace App\Http\Controllers;

use App\Models\Pelatih;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AbsensiPelatih;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AbsensiPelatihController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Absensi Pelatih',
            'title_page' => 'Data Absensi Pelatih',
            'pelatih' => Pelatih::all(),
        ];
        return view('absensi_pelatih.index', $data);
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
            'kode_absensi' => 'required',
            'tanggal_absensi' => 'required',
            'pelatih_unique' => 'required',
            'kegiatan' => 'required',
            'status' => 'required',
        ];
        $pesan = [
            'kode_absensi.required' => 'Kode absensi tidak boleh kosong',
            'tanggal_absensi.required' => 'Tanggal absensi tidak boleh kosong',
            'pelatih_unique.required' => 'Pilih pelatih',
            'kegiatan.required' => 'Kegiatan tidak boleh kosong',
            'status.required' => 'Status tidak boleh kosong',
        ];
        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $data = [
                'unique' => Str::orderedUuid(),
                'pelatih_unique' => $request->pelatih_unique,
                'kode_absensi' => $request->kode_absensi,
                'tanggal_absensi' => $request->tanggal_absensi,
                'kegiatan' => $request->kegiatan,
                'status' => $request->status,
            ];
            AbsensiPelatih::create($data);
            return response()->json(['success' => 'Data Absensi Berhasil Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AbsensiPelatih $absensiPelatih)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AbsensiPelatih $absensiPelatih)
    {
        return response()->json(['data' => $absensiPelatih]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AbsensiPelatih $absensiPelatih)
    {
        $cek = AbsensiPelatih::where('kode_absensi', $request->kode_absensi)
            ->where('kode_absensi', $absensiPelatih->kode_absensi)
            ->get();
        $rules = [
            'kode_absensi' => 'required',
            'tanggal_absensi' => 'required',
            'pelatih_unique' => 'required',
            'kegiatan' => 'required',
            'status' => 'required',
        ];
        $pesan = [
            'kode_absensi.required' => 'Kode absensi tidak boleh kosong',
            'tanggal_absensi.required' => 'Tanggal absensi tidak boleh kosong',
            'pelatih_unique.required' => 'Pilih pelatih',
            'kegiatan.required' => 'Kegiatan tidak boleh kosong',
            'status.required' => 'Status tidak boleh kosong',
        ];
        if ($cek) {
            $rules['kode_absensi'] = 'required';
            $pesan['kode_absensi.required'] = 'Kode absensi tidak boleh kosong';
        } else {
            $rules['kode_absensi'] = 'required|unique:absensi_pelatihs';
            $pesan['kode_absensi.required'] = 'Kode absensi tidak boleh kosong';
            $pesan['kode_absensi.unique'] = 'Kode absensi sudah terdaftar';
        }
        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $data = [
                'pelatih_unique' => $request->pelatih_unique,
                'kode_absensi' => $request->kode_absensi,
                'tanggal_absensi' => $request->tanggal_absensi,
                'kegiatan' => $request->kegiatan,
                'status' => $request->status,
            ];
            AbsensiPelatih::where('unique', $absensiPelatih->unique)->update($data);
            return response()->json(['success' => 'Data Absensi Berhasil Diupadte']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AbsensiPelatih $absensiPelatih)
    {
        AbsensiPelatih::where('unique', $absensiPelatih->unique)->delete();
        return response()->json(['success' => 'Data Berhasil Dihapus']);
    }
    public function dataTabless(Request $request)
    {
        $query = DB::table('absensi_pelatihs as a')
            ->join('pelatihs as b', 'a.pelatih_unique', '=', 'b.unique')
            ->select('a.*', 'b.nama')
            ->get();
        foreach ($query as $row) {
            $row->tanggal_absensi = tanggal_hari($row->tanggal_absensi);
        }
        return DataTables::of($query)->addColumn('action', function ($row) {
            $actionBtn =
                '
                <button class="btn btn-rounded btn-sm btn-info text-white view-button" title="Lihat Kegiatan" data-kegitan="' . $row->kegiatan . '"><i class="fas fa-eye"></i></button>
                <button class="btn btn-rounded btn-sm btn-warning text-white edit-button" title="Edit Data" data-unique="' . $row->unique . '"><i class="fas fa-edit"></i></button>
                <button class="btn btn-rounded btn-sm btn-danger text-white delete-button" title="Hapus Data" data-unique="' . $row->unique . '" data-token="' . csrf_token() . '"><i class="fas fa-trash-alt"></i></button>';
            return $actionBtn;
        })->make(true);
    }
}
