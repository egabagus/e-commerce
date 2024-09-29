<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="formeditProduct">
                @csrf
                <div class="modal-header">
                    <h3 class="text-xl" id="editProductModalLabel">Edit Data Barang</h3>
                    <button type="button" class="btn-sm btn-light" data-bs-dismiss="modal"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3 row">
                        <label for="" class="col-3 form-label">Kode Barang</label>
                        <div class="col-9">
                            <input type="hidden" id="idBarang">
                            <x-form.input type="text" id="kode_barang" class="block w-full" autofocus
                                autocomplete="name" disabled placeholder="Otomatis" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Nama Barang</label>
                        <div class="col-9">
                            <x-form.input id="nama_barang" name="nama_barang" type="text" class="block w-full"
                                autofocus autocomplete="name" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Harga</label>
                        <div class="col-9">
                            <x-form.input id="harga" name="harga" type="number" class="block w-full" autofocus
                                autocomplete="name" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Stok</label>
                        <div class="col-9">
                            <x-form.input id="stok" name="stok" type="number" class="block w-full" autofocus
                                autocomplete="name" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Deksripsi</label>
                        <div class="col-9">
                            <x-form.textarea id="deskripsiEdit" name="deskripsi" type="number" class="block w-full"
                                autofocus autocomplete="name" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Status</label>
                        <div class="col-9">
                            <x-form.select name="status" id="status" :disabled="false" :withicon="true"
                                :options="['1' => 'Aktif', '0' => 'Nonaktif']"></x-form.select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn bg-sky-800 text-white hover:bg-sky-900" onclick="update()">Save
                        changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editProduct(data) {
        $('#editProductModal').modal('show')
        console.log(data)

        $('#kode_barang').val(data.kode_barang)
        $('#nama_barang').val(data.nama_barang)
        $('#harga').val(data.harga)
        $('#stok').val(data.stok)
        $('#deskripsiEdit').val(data.deskripsi)
        $('#idBarang').val(data.id)
        $('#status').val(data.status)
    }

    function update() {
        var form = document.getElementById('formeditProduct')
        var formData = new FormData(form)
        var id = $('#idBarang').val();
        console.log(formData)
        Swal.fire({
            title: "Yakin untuk mengubah data produk?",
            showCancelButton: true,
            confirmButtonText: "Yes",
            icon: "question"
        }).then(function() {
            $.ajax({
                url: `{{ url('master/product/data') }}/${id}`,
                data: formData,
                method: 'POST',
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
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
                        $('#editProductModal').modal('hide')
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
        });
    }
</script>
