<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="formimage">
                @csrf
                <div class="modal-header">
                    <h3 class="text-xl" id="imageModalLabel">Product Picture</h3>
                    <button type="button" class="btn-sm btn-light" data-bs-dismiss="modal"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3 row">
                        <label for="" class="col-3 form-label">Upload Image</label>
                        <div class="col-9">
                            <input type="hidden" id="idBarangImage">
                            <x-form.file-input id="foto" name="foto" :disabled="false" :withicon="false" />
                        </div>
                    </div>
                    <div class="mb-3 row hidden" id="imageContainer">
                        <div class="col-3"></div>
                        <div class="col-9">
                            <img id="imageProduct">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn bg-sky-800 text-white hover:bg-sky-900" onclick="upload()">Save
                        changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function uploadImage(data) {
        $('#imageModal').modal('show')
        if (data.foto) {
            $('#imageContainer').removeClass('hidden')
            $('#imageProduct').attr('src',
                `{{ env('APP_URL') }}/storage/master/product-photo/${data.kode_barang}/${data.foto}`)
        }
        $('#idBarangImage').val(data.id)
    }

    function upload() {
        var form = document.getElementById('formimage')
        var formData = new FormData(form)
        var id = $('#idBarang').val();
        console.log(formData)
        Swal.fire({
            title: "Yakin untuk mengubah upload foto produk?",
            showCancelButton: true,
            confirmButtonText: "Yes",
            icon: "question"
        }).then(function() {
            $.ajax({
                url: `{{ url('master/product/data/image') }}/${id}`,
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
                        $('#imageModal').modal('hide')
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
