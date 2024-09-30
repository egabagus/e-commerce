<x-client-layout>
    <p class="text-center text-2xl font-black">YOUR ORDER</p>
    <p class="text-center text-xs mt-2">Home / Transaction</p>

    <div class="row mt-5">
        <div class="col-1"></div>
        <div class="col-10">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 ">
                    <tr class="text-lg">
                        <th class="px-6 py-3">Order ID</th>
                        <th class="px-6 py-3">Kode Barang</th>
                        <th class="px-6 py-3">Harga</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody id="orderList">

                </tbody>
            </table>
        </div>
        <div class="col-1"></div>
    </div>
</x-client-layout>
<script>
    $(function() {
        showOrder();
    })

    function showOrder() {
        $.ajax({
            url: `{{ url('user/transaction/data') }}`,
            processData: false,
            contentType: false,
            beforeSend: function() {
                showLoading();
            },
            success: (data) => {
                if (data.status === 'success') {
                    // Bersihkan daftar sebelumnya
                    $('#orderList').empty();
                    data.data.forEach(item => {
                        $('#orderList').append(`
                            <tr class="text-lg">
                                <td class="px-6 py-3">${item.no_order}</td>
                                <td class="px-6 py-3">${item.kode_barang}</td>
                                <td class="px-6 py-3">${item.amount}</td>
                                <td class="px-6 py-3">
                                    ${item.status === 'pending' ? '<span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-lg font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">PENDING</span>'
                                     : '<span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-lg font-medium text-green-700 ring-1 ring-inset ring-green-600/20">SUCCESS</span>'}
                                </td>
                                <td class="px-6 py-3">
                                    ${item.status === 'pending' ? `<button class="btn bg-sky-800 text-white hover:bg-sky-900" onclick="proccess('${item.snap_token}', ${item.id})">Bayar</button>` : ''}
                                </td>
                            </tr>
                        `)
                    })
                } else {
                    alert('Data tidak berhasil dimuat.');
                }
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

    function proccess(token, id) {
        snap.pay(`${token}`, {
            // Optional
            onSuccess: function(result) {
                paymentSuccess(id)
            },
            // Optional
            onPending: function(result) {
                /* You may add your own js here, this is just example */
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onError: function(result) {
                /* You may add your own js here, this is just example */
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            }
        });
    }

    function paymentSuccess(id) {
        $.ajax({
            url: `{{ url('user/transaction/success') }}/${id}`,
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
                hideLoading();
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
