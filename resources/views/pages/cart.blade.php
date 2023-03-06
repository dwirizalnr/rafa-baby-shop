@extends('layouts.app')

@section('title')
    Store Cart Page
@endsection

@section('content')
    <!-- Page Content-->
    <div class="page-content page-details">
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Cart
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section class="store-cart">
            <div class="container">
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-12 table-responsive">
                        <table class="table table-borderless table-cart">
                            <thead>
                                <tr>
                                    <td>Image</td>
                                    <td>Name Product</td>
                                    <td>Price</td>
                                    <td>Quantity</td>
                                    <td>Size</td>
                                    <td>Menu</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $grandTotal = 0;
                                @endphp
                                @foreach ($carts as $cart)
                                    <tr class="align-items-center">
                                        <td style="width: 20%;">
                                            <a href="{{ route('detail', $cart->product->slug) }}"
                                                class="component-products d-block">
                                                @if ($cart->product->galleries)
                                                    <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}"
                                                        alt="" class="cart-image" />
                                                @endif
                                        </td>
                                        <td style="width: 35%;">
                                            <a href="{{ route('detail', $cart->product->slug) }}"
                                                class="component-products d-block">
                                                <div class="product-title">{{ Str::limit($cart->product->name, 40) }}</div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="product-title">Rp {{ number_format($cart->product->price) }}</div>
                                        </td>
                                        <td style="width: 35%;  vertical-align: middle;">
                                            <form action="{{ route('cart.update', $cart->id) }}" <meta name="csrf-token"
                                                content="{{ csrf_token() }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <button class="add btn btn-primary">+</button>
                                                    </div>
                                                    <input type="text" name="quantity"
                                                        class="quantity form-control text-center"
                                                        value="{{ $cart->quantity }}" id="quantity"
                                                        style="min-width: 50px; max-width: 100px;">
                                                    <div class="input-group-append">
                                                        <button class="minus btn btn-danger">-</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="subtotal" data-price="{{ $cart->product->price }}" hidden>
                                            {{ $subtotal = $cart->quantity * $cart->product->price }}
                                            @php
                                                $grandTotal += $subtotal;
                                            @endphp
                                        </td>
                                        <td>
                                            @if ($cart->product->product_stocks->count() > 0)
                                                <div class="form-group mt-2">

                                                    <select name="size" id="size" class="form-select form-select-lg"
                                                        required>
                                                        <option value="" selected disabled>Please Select Size</option>
                                                        @foreach ($cart->product->product_stocks as $stock)
                                                            <option value="{{ $stock->size }}"
                                                                {{ $stock->size == old('size', $cart->size) ? 'selected' : '' }}>
                                                                {{ $stock->size }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            @endif
                                        </td>
                                        <td style="width: 20%;">
                                            <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-remove-cart">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- @php
                   $totalPrice += $cart->product->price * $cart->quantity
                 @endphp --}}
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <div class="total" id="grandTotal">Total Price : Rp {{number_format($grandTotal, 0, ',', '.')}}</div> --}}
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-12">
                        <hr />
                    </div>
                </div>
                <input type="hidden" name="total_price" value="{{ $grandTotal }}">
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-12">
                        <h2 class="mb-1">Payment Informations</h2>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-4 col-md-2">
                        <div class="product-title text-success" name="total_price" id="grandTotal">Rp
                            {{ number_format($grandTotal, 0, ',', '.') }}</div>
                        <div class="product-subtitle">Total</div>
                    </div>
                    <div class="col-8 col-md-3 ml-auto">
                        <form action="{{ route('index-checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success mt-4 px-4 btn-block">
                                Checkout Now
                            </button>
                        </form>
                    </div>
                </div>
                </form>
            </div>
        </section>
    </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script>
        var locations = new Vue({
            el: "#locations",
            mounted() {
                this.getProvincesData();
            },
            data: {
                provinces: null,
                regencies: null,
                provinces_id: null,
                regencies_id: null,
            },
            methods: {
                getProvincesData() {
                    var self = this;
                    axios.get('{{ route('api-provinces') }}')
                        .then(function(response) {
                            self.provinces = response.data;
                        })
                },
                getRegenciesData() {
                    var self = this;
                    axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
                        .then(function(response) {
                            self.regencies = response.data;
                        })
                },
            },
            watch: {
                provinces_id: function(val, oldVal) {
                    this.regencies_id = null;
                    this.getRegenciesData();
                },
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".add").click(function() {
                let quantity = $(this).closest("tr").find(".quantity");
                quantity.val(parseInt(quantity.val()) + 1);

                let subtotal = $(this).closest("tr").find(".subtotal");
                subtotal.text(parseInt(quantity.val()) * parseInt(subtotal.data("price")));

                updateGrandTotal();
                updateCart($(this).closest("tr").data("id"), quantity.val());
            });

            $(".minus").click(function() {
                let quantity = $(this).closest("tr").find(".quantity");
                if (quantity.val() > 0) {
                    quantity.val(parseInt(quantity.val()) - 1);
                    let subtotal = $(this).closest("tr").find(".subtotal");
                    subtotal.text(parseInt(quantity.val()) * parseInt(subtotal.data("price")));

                    updateGrandTotal();
                    updateCart($(this).closest("tr").data("id"), quantity.val());
                }
            });

            function updateGrandTotal() {
                let grandTotal = 0;
                $(".subtotal").each(function() {
                    grandTotal += parseInt($(this).text());
                });

                $("#grandTotal").text("Total Price: " + grandTotal.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }));
            }

            function updateCart(id, quantity) {
                $.ajax({
                    url: "/cart/" + id,
                    type: "PUT",
                    data: {
                        quantity: quantity,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log("Cart updated successfully");
                    }
                });
            }
        });
    </script>
@endpush
