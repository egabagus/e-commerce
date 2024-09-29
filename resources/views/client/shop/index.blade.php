<x-client-layout>
    <p class="text-center text-2xl font-black">SHOP</p>
    <p class="text-center text-xs mt-2">Home / Shop</p>

    <div class="row mt-5" id="productList">

    </div>
</x-client-layout>
<script>
    $(function() {
        showProduct();
    })

    function showProduct() {
        $.ajax({
            url: `{{ url('client/master/product/data') }}`,
            processData: false,
            contentType: false,
            beforeSend: function() {
                showLoading();
            },
            success: (data) => {
                $.each(data.data, function(index, product) {
                    let productCard = `
                    <div class="col-3">
                        <div class="card">
                            <img src="{{ env('APP_URL') }}/storage/master/product-photo/${product.kode_barang}/${product.foto}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="text-lg fw-bolder text-uppercase">${product.nama_barang}</h5>
                                <p class="card-text mt-1">${formatRupiah(product.harga, 'Rp.')}</p>
                                <a href="{{ env('APP_URL') }}/client/shop/product/${product.kode_barang}" class="mt-4 btn bg-sky-800 text-white hover:bg-sky-900">Detail</a>
                            </div>
                        </div>
                    </div>`;
                    $('#productList').append(productCard);
                });
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
