@extends('layouts.app')

@section('title')
    Store Checkout Page
@endsection
@php
    $grandTotal = 0;
    foreach ($cartItems as $cart) {
        $grandTotal += $cart->product->price * $cart->quantity;
    }
@endphp
@section('content')
    <section id="checkout-container">
        <div class="page-content page-details">
            <div class="container">
                <form action="{{ route('checkout') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="total_price" value="{{ $grandTotal }}"> --}}
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <header class="card-header bg-secondary text-white">
                                    <h4 class="card-title mt-2">Billing Details</h4>
                                </header>
                                <article class="card-body">
                                    <div class="form-row">
                                        <div class="form-group">
                                            {{-- <label>Provinsi asal</label> --}}
                                            <input type="hidden" value="11" class="form-control"
                                                name="province_origin">
                                        </div>
                                        <div class="form-group ">
                                            {{-- <label>Kota Asal</label> --}}
                                            <input type="hidden" value="255" class="form-control" id="city_origin"
                                                name="city_origin">
                                        </div>
                                        <div class="col form-group">
                                            <label for="name">Your Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name }}" />
                                        </div>
                                        <div class="col form-group">
                                            <label for="email">Your Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $user->email }}" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_one">Address 1</label>
                                        <input type="text" class="form-control" id="address_one" name="address_one"
                                            value="{{ $user->address_one }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="address_one">Address 2</label>
                                        <input type="text" class="form-control" id="address_one" name="address_one"
                                            value="{{ $user->address_two }}" />
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="provinsi">Provinsi Tujuan</label>
                                            <select name="province_id" id="province_id" class="form-control">
                                                <option value="">Provinsi Tujuan</option>
                                                @foreach ($provinsi as $row)
                                                    {{-- <option value="{{ $row['province_id'] }}"
                                                        namaprovinsi="{{ $row['province'] }}">{{ $row['province'] }}
                                                    </option> --}}
                                                    <option value="{{ $row['province_id'] }}"
                                                        data-namaprovinsi="{{ $row['province'] }}">{{ $row['province'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="nama_provinsi"
                                                    name="nama_provinsi"
                                                    value="{{ old('nama_provinsi', $user->province ? $user->province->name : '') }}"
                                                    placeholder="ini untuk menangkap nama provinsi ">

                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Kota Tujuan<span>*</span></label>
                                            <select name="city_id" id="city_id" class="form-control">
                                                <option value="">Pilih Kota</option>
                                            </select>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="nama_kota" name="nama_kota"
                                                    value="{{ $user->city ? $user->city->name : '' }}"
                                                    placeholder="ini untuk menangkap nama kota">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group  col-md-6">
                                            <label for="zip_code">Kode Pos</label>
                                            <input type="text" class="form-control" id="kode_pos" name="kode_pos"
                                                value="{{ $user->kode_pos }}" />
                                        </div>
                                        <div class="form-group  col-md-6">
                                            <label>Phone Number</label>
                                            <input type="text" class="form-control" name="phone_number"
                                                value="{{ $user->phone_number }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="catatan_tambahan">Catatan Tambahan (Opsional)</label>
                                        <textarea class="form-control" id="catatan_tambahan" name="catatan_tambahan"></textarea>
                                    </div>
                                </article>
                            </div>
                            <div class="card">
                                <header class="card-header bg-secondary text-white">
                                    <h4 class="card-title mt-2">Shipping</h4>
                                </header>
                                <article class="card-body">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="nama_kota" name="nama_kota"
                                                placeholder="ini untuk menangkap nama kota">
                                        </div>
                                        <div class="form-group ">
                                            <label>Pilih Ekspedisi<span>*</span>
                                            </label>
                                            <select name="kurir" id="kurir" class="form-control">
                                                <option value="">Pilih kurir</option>
                                                <option value="jne">JNE</option>
                                                <option value="tiki">TIKI</option>
                                                <option value="pos">POS INDONESIA</option>
                                            </select>
                                        </div>
                                        <div class="col form-group">
                                            <label>Pilih Layanan<span>*</span>
                                            </label>
                                            <select name="layanan" id="layanan" class="form-control">
                                                <option value="">Pilih layanan</option>
                                            </select>
                                        </div>
                                        <div class="col form-group">
                                            <label>Total Belanja<span>*</span>
                                            </label>
                                            <input type="text" name="totalbelanja" class="form-control"
                                                value="{{ $grandTotal }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>total berat (gram) </label>
                                        <input class="form-control" type="text" value="200" id="weight"
                                            name="weight">
                                    </div>
                                    <div class="form-group">
                                        <label>Total Ongkos Kirim</label>
                                        <input class="form-control" type="text" id="shipping_price"
                                            name="shipping_price">
                                    </div>
                                    <div class="form-group">
                                        <label>Total Keseluruhan</label>
                                        <input class="form-control" type="text" id="total_price" name="total_price">
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <header class="card-header bg-secondary text-white">
                                            <h4 class="card-title mt-2">Your Order</h4>
                                        </header>
                                        <article class="card-body">
                                            <div class="row">
                                                @php
                                                    $totalBelanja = 0;
                                                @endphp
                                                @foreach ($cartItems as $cart)
                                                    <div class="col-md-12">
                                                        <div class="media">
                                                            <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}"
                                                                alt="" class="align-self-center mr-3 cart-image"
                                                                style="max-width: 100px; max-height: 100px;" />
                                                            <div class="media-body">
                                                                <h5 class="mt-0">{{ $cart->product->name }}</h5>
                                                                <p class="mb-1">Quantity: {{ $cart->quantity }}</p>
                                                                @if ($cart->product->product_stocks->count() > 0 && $cart->product->has_size)
                                                                    <p class="mb-1">Size: {{ $cart->size }}</p>
                                                                @endif
                                                                <p>Total: Rp
                                                                    {{ $subtotal = $cart->quantity * $cart->product->price }}
                                                                </p>
                                                                @php
                                                                    $totalBelanja += $subtotal;
                                                                @endphp
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="col-md-12">
                                                    <hr>
                                                    <h5>Total: Rp {{ number_format($grandTotal) }}</h5>
                                                    <a href="{{ route('cart') }}" class="btn btn-primary mt-3">Edit
                                                        Cart</a>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <button type="submit" class="subscribe btn btn-success btn-lg btn-block">Click
                                        Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> --}}

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            //ini ketika provinsi tujuan di klik maka akan eksekusi perintah yg kita mau
            //name select nama nya "provinve_id" kalian bisa sesuaikan dengan form select kalian
            $('select[name="province_id"]').on('change', function() {
                // membuat variable namaprovinsiku untyk mendapatkan atribut nama provinsi
                var namaprovinsiku = $("#province_id option:selected").attr("namaprovinsi");
                // menampilkan hasil nama provinsi ke input id nama_provinsi
                $("#nama_provinsi").val(namaprovinsiku);
                //memberikan action ketika select name kota_id di select
                //memberikan action ketika select name kota_id di select
                $('select[name="city_id"]').on('change', function() {
                    // membuat variable namakotaku untyk mendapatkan atribut nama kota
                    var namakotaku = $("#city_id option:selected").attr("namakota");
                    // menampilkan hasil nama provinsi ke input id nama_provinsi
                    $("#nama_kota").val(namakotaku);
                    var kodepos = $("#city_id option:selected").attr("kodepos");
                    $("#kode_pos").val(kodepos);
                });
                // kita buat variable provincedid untk menampung data id select province
                let provinceid = $(this).val();
                //kita cek jika id di dpatkan maka apa yg akan kita eksekusi
                if (provinceid) {
                    // jika di temukan id nya kita buat eksekusi ajax GET
                    jQuery.ajax({
                        // url yg di root yang kita buat tadi
                        url: "/kota/" + provinceid,
                        // aksion GET, karena kita mau mengambil data
                        type: 'GET',
                        // type data json
                        dataType: 'json',
                        // jika data berhasil di dapat maka kita mau apain nih
                        success: function(data) {
                            // jika tidak ada select dr provinsi maka select kota kososng / empty
                            $('select[name="city_id"]').empty();
                            // jika ada kita looping dengan each
                            $.each(data, function(key, value) {
                                // perhtikan dimana kita akan menampilkan data select nya, di sini saya memberi name select kota adalah kota_id
                                $('select[name="city_id"]').append('<option value="' +
                                    value.city_id + '" namakota="' + value.type +
                                    ' ' + value.city_name + '" kodepos="' + value
                                    .postal_code + '">' + value.type + ' ' + value
                                    .city_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="city_id"]').empty();
                }
            });
        });
    </script>


    <script>
        $('select[name="kurir"]').on('change', function() {
            // kita buat variable untuk menampung data data dari  inputan
            // name city_origin di dapat dari input text name city_origin
            let origin = $("input[name=city_origin]").val();
            // name kota_id di dapat dari select text name kota_id
            let destination = $("select[name=city_id]").val();
            // name kurir di dapat dari select text name kurir
            let courier = $("select[name=kurir]").val();
            // name weight di dapat dari select text name weight
            let weight = $("input[name=weight]").val();
            // alert(courier);
            if (courier) {
                jQuery.ajax({
                    url: "/origin=" + origin + "&destination=" + destination + "&weight=" + weight +
                        "&courier=" + courier,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('select[name="layanan"]').empty();
                        // ini untuk looping data result nya
                        $.each(data, function(key, value) {
                            // ini looping data layanan misal jne reg, jne oke, jne yes
                            $.each(value.costs, function(key1, value1) {
                                // ini untuk looping cost nya masing masing
                                // silahkan pelajari cara menampilkan data json agar lebi paham
                                $.each(value1.cost, function(key2, value2) {
                                    $('select[name="layanan"]').append(
                                        '<option harga_ongkir="' + value2
                                        .value + '" value="' + key + '">' +
                                        value1.service + '-' + value1
                                        .description + '-' + value2.value +
                                        '</option>');
                                });
                            });
                        });
                        // Tambahkan script berikut
                        if (data.length == 1) {
                            let firstService = data[0].costs[0];
                            let firstCost = firstService.cost[0].value;
                            $('select[name="layanan"]').append('<option harga_ongkir="' + firstCost +
                                '" value="' + firstService.service + '">' + firstService.service +
                                '-' + firstService.description + '-' + firstCost + '</option>');
                            $("#shipping_price").val(firstCost);
                            let totalbelanja = $("input[name=totalbelanja]").val();
                            let total = parseInt(totalbelanja) + parseInt(firstCost);
                            $("#total_price").val(total);
                        }
                    }
                });
            } else {
                $('select[name="layanan"]').empty();
            }
        });
        $('select[name="layanan"]').on('change', function() {
            let totalbelanja = $("input[name=totalbelanja]").val();
            var harga_ongkir = $('select[name="layanan"] option:selected').attr("harga_ongkir");
            $("#shipping_price").val(harga_ongkir);
            let total = parseInt(totalbelanja) + parseInt(harga_ongkir);
            $("#total_price").val(total);
        });
    </script>

    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
@endpush
