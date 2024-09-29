<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="formAddProduct">
                @csrf
                <div class="modal-header">
                    <h3 class="text-xl" id="addProductModalLabel">Tambah Data Barang</h3>
                    <button type="button" class="btn-sm btn-light" data-bs-dismiss="modal"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3 row">
                        <label for="" class="col-3 form-label">Kode Barang</label>
                        <div class="col-9">
                            <x-form.input type="text" class="block w-full" autofocus autocomplete="name" disabled
                                placeholder="Otomatis" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Nama Barang</label>
                        <div class="col-9">
                            <x-form.input name="nama_barang" type="text" class="block w-full" autofocus
                                autocomplete="name" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Harga</label>
                        <div class="col-9">
                            <x-form.input name="harga" type="number" class="block w-full" autofocus
                                autocomplete="name" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Stok</label>
                        <div class="col-9">
                            <x-form.input name="stok" type="number" class="block w-full" autofocus
                                autocomplete="name" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Deksripsi</label>
                        <div class="col-9">
                            <x-form.textarea name="deskripsi" type="number" class="block w-full" autofocus
                                autocomplete="name" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Status</label>
                        <div class="col-9">
                            <x-form.select name="status" :disabled="false" :withicon="true"
                                :options="['1' => 'Aktif', '0' => 'Nonaktif']"></x-form.select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn bg-sky-800 text-white hover:bg-sky-900" onclick="save()">Save
                        changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function addProduct() {
        $('#addProductModal').modal('show')
    }

    function save() {
        var form = document.getElementById('formAddProduct')
        var formData = new FormData(form)

        $.ajax({
            url: `{{ url('master/product/data') }}`,
            data: formData,
            method: 'POST',
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
