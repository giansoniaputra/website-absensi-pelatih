@extends('layouts.main')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="btn-add-data" data-toggle="modal" data-target="#modal-absensi-pelatih">Tambah Data Pelatih</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table-absensi-pelatih" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Absensi</th>
                            <th>Tanggal Absensi</th>
                            <th>Nama Pelatih</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
@include('absensi_pelatih.modal-tambah')
<script src="/js/absensi_pelatih.js"></script>
@endsection
