<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Master Produk') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="d-flex flex-row-reverse">
            <button type="button" class="btn bg-sky-800 text-white hover:bg-sky-900">Tambah data</button>
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-bordered" id="productTable">
                <thead>
                    <tr class="table-primary text-center text-uppercase">
                        <th width="5%">No.</th>
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

                        editBarang(data)
                    });
                    $('table#productTable tr').on('click', '#btnDeleteUser', function(e) {
                        e.preventDefault();

                        let data = productTable.row($(this).parents('tr')).data()

                        deleteBarang(data.id)
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
                            <button class="btn btn-sm btn-warning" id="btnEditUser"><i class="fas fa-pen"></i></button>
                            <button class="btn btn-sm btn-danger" id="btnDeleteUser"><i class="fas fa-trash"></i></button>
                            </div>`
                        }
                    },
                ],
            });
        }
    </script>
</x-app-layout>
@include('master.product.create')
