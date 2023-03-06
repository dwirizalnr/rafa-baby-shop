@extends('layouts.dashboard')

@section('title')
    Account Settings
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">My Account</h2>
                <p class="dashboard-subtitle">
                    Update your current profile
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        <form id="locations"
                            action="{{ route('dashboard-settings-redirect', 'dashboard-settings-account') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Your Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $user->name }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Your Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $user->email }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address_one">Address 1</label>
                                                <input type="text" class="form-control" id="address_one"
                                                    name="address_one" value="{{ $user->address_one }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address_two">Address 2</label>
                                                <input type="text" class="form-control" id="address_two"
                                                    name="address_two" value="{{ $user->address_two }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group--inline">
                                                <label for="provinsi">Provinsi Tujuan</label>
                                                <select name="province_id" id="province_id" class="form-control">
                                                    <option value="">Provinsi Tujuan</option>
                                                    @foreach ($provinsi as $row)
                                                        <option value="{{ $row['province_id'] }}"
                                                            namaprovinsi="{{ $row['province'] }}">{{ $row['province'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="nama_provinsi"
                                                    name="nama_provinsi"
                                                    value="{{ $user->province ? $user->province->name : '' }}"
                                                    placeholder="ini untuk menangkap nama provinsi ">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Kota Tujuan<span>*</span></label>
                                                <select name="city_id" id="city_id" class="form-control">
                                                    <option value="">Pilih Kota</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="nama_kota" name="nama_kota"
                                                    value="{{ $user->city ? $user->city->name : '' }}"
                                                    placeholder="ini untuk menangkap nama kota">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="zip_code">Postal Code</label>
                                                <input type="text" class="form-control" id="kode_pos" name="kode_pos"
                                                    value="{{ $user->kode_pos }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country">Country</label>
                                                <input type="text" class="form-control" id="country" name="country"
                                                    value="{{ $user->country }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone_number">Mobile</label>
                                                <input type="text" class="form-control" id="phone_number"
                                                    name="phone_number" value="{{ $user->phone_number }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-success px-5">
                                                Save Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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
@endpush
