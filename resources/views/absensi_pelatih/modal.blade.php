{{-- MODAL ABSENSI PELATIH --}}
<div class="modal fade" id="modal-absensi-pelatih" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-modal"></h5>
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:;">
                    {{-- HIDDEN INPUT --}}
                    <input type="hidden" name="unique" id="unique">
                    <input type="hidden" name="_method" id="method">
                    @csrf
                    {{-- ./HIDDEN INPUT --}}
                    <div class="row pl-3 pr-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="kode_absensi">Kode Absensi</label>
                                <input type="text" class="form-control" id="kode_absensi" name="kode_absensi">
                            </div>
                        </div>
                    </div>
                    <div class="row pl-3 pr-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="tanggal_absensi">Tanggal Absensi</label>
                                <input type="date" class="form-control" id="tanggal_absensi" name="tanggal_absensi" value="{{ date('Y-m-d', time()) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row pl-3 pr-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="pelatih_unique">Nama Pelatih</label>
                                <select class="form-control" name="pelatih_unique" id="pelatih_unique">
                                    <option selected disabled value="">Pilih Pelatih...</option>
                                    @foreach ($pelatih as $row)
                                    <option value="{{ $row->unique }}">{{ $row->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row pl-3 pr-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="kegiatan">Kegiatan</label>
                                <textarea name="kegiatan" id="kegiatan" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row pl-3 pr-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <input type="text" class="form-control" id="status" name="status">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" id="btn-action"></div>
        </div>
    </div>
</div>

{{-- MODAL LIHAT KEGIATAN --}}

<div class="modal fade" id="modal-kegiatan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Kegiatan</h5>
                <button type="button" class="close btn-close-kegiatan" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col d-flex justify-content-center">
                        <p class="tetx-center" id="isi-kegiatan"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
