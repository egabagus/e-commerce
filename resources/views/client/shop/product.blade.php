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

            <p class="mt-3"><b>STOK: </b><span id="stockProduct"></span></p>
            <div class="col-2 mt-3">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus"
                            data-field="">
                            <i class="fa fa-minus"></i>
                        </button>
                    </span>
                    <input type="text" id="quantity" name="quantity" class="form-control input-number"
                        value="1" min="1" max="100">
                    {{-- <x-form.input name="quantity" id="quantity" type="text" class="form-control input-number"
                        value="1" min="1" max="100" /> --}}
                    <span class="input-group-btn">
                        <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus"
                            data-field="">
                            <i class="fa fa-plus"></i>
                        </button>
                    </span>
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="button" class="mt-4 btn btn-lg bg-sky-800 text-white hover:bg-sky-900"
                    id="btnCheckout">CHECKOUT</button>
            </div>

        </div>
    </div>
</x-client-layout>
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="formCheckout">
                @csrf
                <div class="modal-header">
                    <h3 class="text-xl" id="checkoutLabel">Checkout</h3>
                    <button type="button" class="btn-sm btn-light" data-bs-dismiss="modal"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3 row">
                        <label for="" class="col-3 form-label">Kode Barang</label>
                        <div class="col-9">
                            <x-form.input type="text" id="kodebarang" name="kode_barang" class="block w-full"
                                autocomplete="name" readonly placeholder="Otomatis" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Nama Barang</label>
                        <div class="col-9">
                            <x-form.input name="nama_barang" id="nama_barang" type="text" class="block w-full"
                                readonly autocomplete="name" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Harga</label>
                        <div class="col-9">
                            <x-form.input name="harga_unit" id="harga" type="number" class="block w-full" readonly
                                autocomplete="name" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Stok</label>
                        <div class="col-9">
                            <x-form.input name="stok" id="stok" type="number" class="block w-full" readonly
                                autocomplete="name" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Quantitiy</label>
                        <div class="col-9">
                            <x-form.input name="amount" id="qty" name="qty" type="number"
                                class="block w-full" autocomplete="name" onkeyup="calculateTotal()" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3">Total Harga</label>
                        <div class="col-9">
                            <x-form.input name="harga" id="total_harga" type="number" class="block w-full"
                                readonly autocomplete="name" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn bg-sky-800 text-white hover:bg-sky-900"
                        onclick="pay()">Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var id_user = `{{ Illuminate\Support\Facades\Auth::id() }}`
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
                $('#stockProduct').text(val.stok)

                $('#btnCheckout').click(function() {
                    checkout(val);
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

    var quantitiy = 0;
    $('.quantity-right-plus').click(function(e) {

        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());

        // If is not undefined

        $('#quantity').val(quantity + 1);


        // Increment

    });

    $('.quantity-left-minus').click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());

        // If is not undefined

        // Increment
        if (quantity > 0) {
            $('#quantity').val(quantity - 1);
        }
    });

    function checkout(data) {
        if (!id_user) {
            window.location.href = `{{ env('APP_URL') }}/login`;
        } else {
            $('#checkoutModal').modal('show')
            $('#kodebarang').val(data.kode_barang)
            $('#nama_barang').val(data.nama_barang)
            $('#harga').val(data.harga)
            $('#stok').val(data.stok)
        }
    }

    function calculateTotal() {
        const qty = parseFloat($('#qty').val()) || 0; // Ambil nilai qty
        const price = parseFloat($('#harga').val()) || 0; // Ambil nilai harga
        const total = qty * price; // Hitung total
        $('#total_harga').val(total.toFixed(2)); // Tampilkan total di input total
    }

    function pay() {
        var form = document.getElementById('formCheckout')
        var formData = new FormData(form)

        $.ajax({
            url: "{{ url('client/shop/pay') }}",
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function(data) {
                Swal.fire({
                    title: "Berhasil!",
                    type: "success",
                    icon: "success",
                }).then(function() {
                    window.location.href = `{{ route('transaction-list') }}`;
                })
            },
            error: function(error) {
                hideLoading();
                handleErrorAjax(error)
            },
            complete: function() {
                hideLoading();
            },
        });

    }
</script>
