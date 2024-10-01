<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-2xl font-semibold leading-tight">
                {{ __('Master Produk') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="d-flex flex-row-reverse">
            <button type="button" class="btn bg-sky-800 text-white hover:bg-sky-900" onclick="addProduct()">Tambah
                data</button>
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-bordered" id="productTable">
                <thead>
                    <tr class="table-primary text-center text-uppercase">
                        <th width="5%">No.</th>
                        <th>Kode</th>
                        <th>Item</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</x-app-layout>
@include('master.product.create')
@include('master.product.edit')
@include('master.product.image')
<script>
    $(function() {
        loadData();
    })

    var productTable;

    loadData = function() {
        if (undefined !== productTable) {
            productTable.destroy()
            productTable.clear.draw()
        }

        productTable = $('#productTable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{{ url('master/product/data') }}",
                beforeSend: function() {
                    showLoading();
                },
                complete: function() {
                    hideLoading();
                },
                error: function() {
                    hideLoading();
                }
            },
            order: [
                [1, 'asc']
            ],
            drawCallback: function(settings) {
                $('table#productTable tr').on('click', '#btnEditUser', function(e) {
                    e.preventDefault();

                    let data = productTable.row($(this).parents('tr')).data()

                    editProduct(data)
                });
                $('table#productTable tr').on('click', '#btnDeleteUser', function(e) {
                    e.preventDefault();

                    let data = productTable.row($(this).parents('tr')).data()

                    deleteBarang(data.id)
                });
                $('table#productTable tr').on('click', '#btnUploadImage', function(e) {
                    e.preventDefault();

                    let data = productTable.row($(this).parents('tr')).data()

                    uploadImage(data)
                });
            },
            columns: [{
                    orderable: false,
                    searchable: false,
                    width: '5%',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: 'kode_barang',
                    name: 'kode_barang'
                },
                {
                    data: 'nama_barang',
                    name: 'nama_barang'
                },
                {
                    data: 'harga',
                    name: 'harga',
                    render: function(data) {
                        return formatRupiah(data, 'Rp. ')
                    }
                },
                {
                    data: 'stok',
                    name: 'stok'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data) {
                        if (data == 1) {
                            return `<div class="badge bg-success text-white">Aktif</div>`
                        } else {
                            return `<div class="badge bg-danger text-white">NonAktif</div>`
                        }
                    }
                },
                {
                    data: 'id',
                    name: 'id',
                    render: function(data) {
                        return `<div class="d-flex justify-content-center" style="gap: 5px;">
                            <button class="btn btn-sm btn-info" id="btnUploadImage"><i class="fas fa-image text-white"></i></button>
                            <button class="btn btn-sm btn-warning" id="btnEditUser"><i class="fas fa-pen text-white"></i></button>
                            <button class="btn btn-sm btn-danger" id="btnDeleteUser"><i class="fas fa-trash"></i></button>
                            </div>`
                    }
                },
            ],
        });
    }

    function deleteBarang(id) {
        Swal.fire({
            title: "Yakin untuk menghapus data barang?",
            showCancelButton: true,
            confirmButtonText: "Yes",
            icon: "question"
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('master/product/data/delete') }}/${id}`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
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
        });
    }
</script>
