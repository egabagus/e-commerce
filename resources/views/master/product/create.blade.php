<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="formAddProduct">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Tambah Data Barang</h5>
                    <button type="button" class="btn-sm btn-light" data-dismiss="modal"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3 row">
                        <label for="" class="col-md-3">Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control col-md-9" readonly
                            value="Otomatis" />
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-md-3">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control col-md-9" />
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-md-3">Harga</label>
                        <input type="number" name="harga" class="form-control col-md-9" />
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-md-3">Kategori</label>
                        <select name="kategori" class="form-control" id="kategoriSelect" style="width:75%">
                        </select>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-md-3">Satuan</label>
                        <input type="text" name="satuan" class="form-control col-md-9" />
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-md-3">Deksripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control col-md-9" name="deskripsi"></textarea>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-md-3">Status</label>
                        <select name="status" class="form-control" id="status" style="width:75%">
                            <option value="1">Aktif</option>
                            <option value="0">Non Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function addBarang() {
        initCategory()
        $('#addBarangModal').modal('show')
    }

    function save() {
        var form = document.getElementById('formAddProduct')
        var formData = new FormData(form)

        $.ajax({
            url: `{{ url('master/barang/data') }}`,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                showLoading();
            },
            success: (data) => {
                Swal.fire({
                    title: "Berhasil!",
                    type: "success",
                    icon: "success",
                }).then(function() {
                    productTable.ajax.reload()
                    $('#addProductModal').modal('hide')
                })
            },
            error: function(error) {
                hideLoading();
                handleErrorAjax(error)
            },
            complete: function() {
                hideLoading();
            },
        })
    }
</script>
