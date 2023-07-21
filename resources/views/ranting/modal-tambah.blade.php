<div class="modal fade" id="modal-ranting" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                <label for="kode_ranting">Kode Ranting</label>
                                <input type="text" class="form-control" id="kode_ranting" name="kode_ranting">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="nama_ranting">Nama Ranting</label>
                                <input type="text" class="form-control" id="nama_ranting" name="nama_ranting">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="jenjang">Jenjang</label>
                                <input type="text" class="form-control" id="jenjang" name="jenjang">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" id="btn-action"></div>
        </div>
    </div>
</div>
