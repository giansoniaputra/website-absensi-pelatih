@extends('layouts.main')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="btn-add-data" data-toggle="modal" data-target="#modal-pelatih">Tambah Data Pelatih</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table-pelatih" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NRA</th>
                            <th>Nama</th>
                            <th>Tingkatan</th>
                            <th>Jabatan</th>
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
@include('pelatih.modal-tambah')
<script src="/js/pelatih.js"></script>
@endsection
