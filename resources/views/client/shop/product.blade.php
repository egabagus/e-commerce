<x-client-layout>
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-md">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active text-uppercase" aria-current="page" id="linkActive"></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row g-5">
        <div class="col-6">
            <img width="100%" id="imageProduct">
        </div>
        <div class="col-6">
            <h1 class="text-2xl text-uppercase fw-bold" id="productName"></h1>
            <h2 class="text-xl fw-bold mt-2 mb-3" id="productPrice"></h2>

            <hr>
            <p class="text-md mt-3 fw-bold">DETAILS</p>
            <p class="text-md mt-2" id="productDesc"></p>

            <div class="d-grid mt-4">
                <button type="button" class="mt-4 btn btn-lg bg-sky-800 text-white hover:bg-sky-900">CHECKOUT</button>
            </div>
        </div>
    </div>
</x-client-layout>
<script>
    $(function() {
        var path = window.location.pathname;

        // Pecah URL berdasarkan '/'
        var segments = path.split('/');

        // Ambil elemen terakhir dari array (contohnya: '001')
        var kodebarang = segments.pop() || segments.pop();

        detailProduct(kodebarang);
    })

    function detailProduct(kodebarang) {
        $.ajax({
            url: `{{ url('client/master/product/data') }}/${kodebarang}`,
            processData: false,
            contentType: false,
            beforeSend: function() {
                showLoading();
            },
            success: (data) => {
                var val = data.data
                $('#linkActive').text(val.nama_barang)
                $('#imageProduct').attr('src',
                    `{{ env('APP_URL') }}/storage/master/product-photo/${val.kode_barang}/${val.foto}`)
                $('#productName').text(val.nama_barang)
                $('#productPrice').text(formatRupiah(val.harga, 'Rp. '))
                $('#productDesc').text(val.deskripsi)
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
