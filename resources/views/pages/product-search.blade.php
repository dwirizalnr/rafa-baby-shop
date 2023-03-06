=@extends('layouts.app')

@section('title')
    Pencarian
@endsection

@section('content')
    <div class="page-content page-details">
        <div class="container">
            <h2 class="h4 font-weight-bold text-uppercase mb-2">Hasil Pencarian For "{{ $query }}"</h2>
            <div class="row mt-3">
                @if (!is_null($products) && count($products) > 0)
                    @foreach ($products as $product)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('detail', $product->slug) }}">
                                        <img src="{{ Storage::url($product->galleries->first()->photos) }}" class="img-fluid"
                                            alt="{{ $product->name }}">
                                    </a>
                                    <div class="mt-2">
                                        <h5><a href="{{ route('detail', $product->slug) }}">{{ $product->name }}</a>
                                        </h5>
                                        <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            Produk tidak ditemukan!
                        </div>
                    </div>
                @endif
            </div>

            {{-- <div class="row mt-3">
            <div class="col-md-12">
                {{ $products->links() }}
            </div>
        </div> --}}
        </div>
    </div>
@endsection
