@extends('layouts.main')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="btn-add-data" data-toggle="modal" data-target="#modal-ranting">Tambah Data Ranting</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table-ranting" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Ranting</th>
                            <th>Nama Ranting</th>
                            <th>Jenjang</th>
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
@include('ranting.modal-tambah')
<script src="/js/ranting.js"></script>
@endsection
