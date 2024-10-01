<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-2xl font-semibold leading-tight">
                {{ __('Transaction') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="table-responsive">
            <table class="table table-bordered" id="productTable">
                <thead>
                    <tr class="table-primary text-center text-uppercase">
                        <th width="5%">No.</th>
                        <th>No. Order</th>
                        <th>Tanggal</th>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Total Harga</th>
                        <th>Pembeli</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</x-app-layout>
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
                url: "{{ url('shop/order/data') }}",
                type: 'GET',
                dataSrc: function(json) {
                    // Jika Anda ingin memodifikasi data sebelum ditampilkan, Anda bisa lakukan di sini
                    return json.data;
                },
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
            columns: [{
                    orderable: false,
                    searchable: false,
                    width: '5%',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: 'no_order',
                    name: 'no_order'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row, meta) {
                        return moment(data).format("dddd, D-M-Y");
                    },
                },
                {
                    data: 'product',
                    name: 'product',
                    render: function(data, type, row, meta) {
                        if (data) {
                            return `${data.kode_barang} - ${data.nama_barang}`;
                        } else {
                            return ''
                        }
                    },
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'amount',
                    name: 'amount',
                    render: function(data) {
                        return formatRupiah(data, 'Rp. ')
                    }
                },
                {
                    data: 'user',
                    name: 'user',
                    render: function(data, type, row, meta) {
                        return `${data.name} - ${data.email}`;
                    },
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data) {
                        if (data == 'pending') {
                            return `<div class="badge bg-warning text-white">PENDING</div>`
                        } else if (data == 'success') {
                            return `<div class="badge bg-success text-white">SUCCESS</div>`
                        }
                    }
                },
            ],
        });
    }
</script>
