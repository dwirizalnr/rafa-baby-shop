@extends('layouts.app')

@section('title')
    Store Detail Page
@endsection

@section('content')
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
                                    Product Details
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>


        <section class="store-gallery mb-3" id="gallery">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8" data-aos="zoom-in">
                        <transition name="slide-fade" mode="out-in">
                            <img :src="photos[activePhoto].url" :key="photos[activePhoto].id" class="w-100 main-image"
                                alt="" />
                        </transition>
                    </div>
                    <div class="col-lg-2">
                        <div class="row">
                            <div class="col-3 col-lg-12 mt-2 mt-lg-0" v-for="(photo, index) in photos"
                                :key="photo.id" data-aos="zoom-in" data-aos-delay="100">
                                <a href="#" @click="changeActive(index)">
                                    <img :src="photo.url" class="w-100 thumbnail-image"
                                        :class="{ active: index == activePhoto }" alt="" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="store-details-container" data-aos="fade-up">
            <section class="store-heading">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <h1>{{ $product->name }}</h1>
                            <div class="price">Rp {{ number_format($product->price) }}</div>
                        </div>
                        <div class="col-lg-2" data-aos="zoom-in">
                            @auth
                                <form action="{{ route('detail-add', $product->id) }}" method="POST"
                                    enctype="multipart/form-data" id="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="form-group d-none" id="quantity-input">
                                        <label>Quantity</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-danger" type="button"
                                                    id="decrement-btn">-</button>
                                            </div>
                                            <input type="number" name="quantity" class="form-control text-center" required
                                                value="1">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-danger" type="button"
                                                    id="increment-btn">+</button>
                                            </div>
                                        </div>
                                        @if ($product->product_stocks->count() > 0 && $product->has_size)
                                            <div class="form-group mt-2">
                                                <label>Size</label>
                                                <select name="size" class="form-control" required>
                                                    @foreach ($product->product_stocks as $stock)
                                                        @if ($loop->first)
                                                            <option value="" selected disabled>Please Select Size</option>
                                                        @endif
                                                        <option value="{{ $stock->size }}">{{ $stock->size }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- <button type="button" class="btn btn-success px-4 text-white btn-block mb-3"
                                            id="add-to-cart-btn">
                                            Add to Cart
                                        </button>
                                        <button type="submit" class="btn btn-success px-4 text-white btn-block mb-3 d-none"
                                            id="add-to-cart-submit">
                                            Add to Cart
                                        </button> --}}
                                    <button type="button" class="btn btn-success px-4 text-white btn-block mb-3"
                                        id="add-to-cart-btn"
                                        {{ $product->product_stocks->sum('stock') == 0 ? 'disabled' : '' }}>
                                        {{ $product->product_stocks->sum('stock') == 0 ? 'Stock Kosong' : 'Add to Cart' }}
                                    </button>
                                    <button type="submit" class="btn btn-success px-4 text-white btn-block mb-3 d-none"
                                        id="add-to-cart-submit">
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-success px-4 text-white btn-block mb-3">
                                    Sign In to Add
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </section>
            <section class="store-description">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8 mt-2">
                            <h2 class="h4 font-weight-bold text-uppercase mb-2">Description</h2>
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
            </section>

            {{-- <section class="store-review">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8 mt-3 mb-3">
                            <h5>Customer Review (3)</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <ul class="list-unstyled">
                                <li class="media">
                                    <img src="/images/icons-testimonial-1.png" alt="" class="mr-3 rounded-circle" />
                                    <div class="media-body">
                                        <h5 class="mt-2 mb-1">Hazza Risky</h5>
                                        I thought it was not good for living room. I really happy
                                        to decided buy this product last week now feels like
                                        homey.
                                    </div>
                                </li>
                                <li class="media">
                                    <img src="/images/icons-testimonial-2.png" alt="" class="mr-3 rounded-circle" />
                                    <div class="media-body">
                                        <h5 class="mt-2 mb-1">Anna Sukkirata</h5>
                                        Color is great with the minimalist concept. Even I thought
                                        it was made by Cactus industry. I do really satisfied with
                                        this.
                                    </div>
                                </li>
                                <li class="media">
                                    <img src="/images/icons-testimonial-3.png" alt=""
                                        class="mr-3 rounded-circle" />
                                    <div class="media-body">
                                        <h5 class="mt-2 mb-1">Dakimu Wangi</h5>
                                        When I saw at first, it was really awesome to have with.
                                        Just let me know if there is another upcoming product like
                                        this.
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section> --}}
            <form method="POST" action="{{ route('product.review', $product->id) }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                {{-- <div class="form-group">
                    <label for="rating">Rating</label>
                    <div id="rating-input" class="rating" data-rated="{{ $product->rating }}"></div>
                    <input type="hidden" name="rating" id="rating" class="form-control" min="1" max="5"
                        required>
                </div> --}}
                {{-- <div class="form-group">
                    <label for="rating">Rating</label>
                    <div id="rateYo"></div>
                    <input name="val" value='' type="hidden" id="val">
                </div> --}}
                <h2>Rating</h2>
                <div class="rating-css">
                    <div class="star-icon">
                        <input type="radio" value="1" name="product_rating" checked id="rating1">
                        <label for="rating1" class="bi bi-star-fill"></label>
                        <input type="radio" value="2" name="product_rating" id="rating2">
                        <label for="rating2" class="bi bi-star-fill"></label>
                        <input type="radio" value="3" name="product_rating" id="rating3">
                        <label for="rating3" class="bi bi-star-fill"></label>
                        <input type="radio" value="4" name="product_rating" id="rating4">
                        <label for="rating4" class="bi bi-star-fill"></label>
                        <input type="radio" value="5" name="product_rating" id="rating5">
                        <label for="rating5" class="bi bi-star-fill"></label>
                    </div>
                </div>
        </div>

        <div class="form-group">
            <label for="review">Review</label>
            <textarea name="review" id="review" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary" id="submit-review">Submit</button>
        </form>

        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Reviews</h5>

                @foreach ($product->reviews as $review)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">{{ $review->user->name }}</h6>
                            <p class="card-text">{{ $review->rating }}</p>
                            <p class="card-text">{{ $review->review }}</p>
                            <p class="card-text"><small
                                    class="text-muted">{{ $review->created_at->diffForHumans() }}</small></p>
                        </div>
                    </div>
                @endforeach

                @if ($product->reviews->isEmpty())
                    <p class="text-muted">No review
                        s yet.</p>
                @endif
            </div>
        </div>

        @if ($relatedProducts->count() > 0)
            <div class="related-products" style="margin-left: 30px;">
                <h3 class="mb-4 ml-10 d-flex justify-content-center align-items-center">Produk Terkait</h3>
                <div class="container">
                    <div class="row">
                        @forelse ($relatedProducts as $relatedProduct)
                            <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="">
                                <a href="{{ route('detail', $relatedProduct->slug) }}"
                                    class="component-products d-block">
                                    <div class="products-thumbnail">
                                        <div class="products-image">
                                            <img src="{{ Storage::url($relatedProduct->galleries->first()->photos) }}"
                                                alt="" class="card-img-top" />
                                        </div>
                                    </div>
                                    <div class="products-text">
                                        {{ Str::limit($relatedProduct->name, 40) }}
                                    </div>
                                    <div class="products-price">
                                        Rp {{ number_format($relatedProduct->price) }}
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                                No Products Found
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        @endif
    </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>

    <script>
        var gallery = new Vue({
            el: "#gallery",
            mounted() {
                AOS.init();
            },
            data: {
                activePhoto: 0,
                photos: [
                    @foreach ($product->galleries as $gallery)
                        {
                            id: {{ $gallery->id }},
                            url: "{{ Storage::url($gallery->photos) }}",
                        },
                    @endforeach
                ],
            },
            methods: {
                changeActive(id) {
                    this.activePhoto = id;
                },
            },
        });
    </script>


    <script>
        const addToCartBtn = document.querySelector('#add-to-cart-btn');
        const quantityInput = document.querySelector('#quantity-input');
        const addToCartSubmit = document.querySelector('#add-to-cart-submit');

        addToCartBtn.addEventListener('click', function() {
            quantityInput.classList.remove('d-none');
            addToCartBtn.classList.add('d-none');
            addToCartSubmit.classList.remove('d-none');
        });
    </script>

    <script>
        // $(document).ready(function() {
        //     // get the increment and decrement buttons
        //     var incrementBtn = $('#increment-btn');
        //     var decrementBtn = $('#decrement-btn');

        //     // get the quantity input
        //     var quantityInput = $('input[name="quantity"]');

        //     // add click event listener to increment button
        //     incrementBtn.click(function() {
        //         var currentValue = parseInt(quantityInput.val());
        //         quantityInput.val(currentValue + 1);
        //     });

        //     // add click event listener to decrement button
        //     decrementBtn.click(function() {
        //         var currentValue = parseInt(quantityInput.val());
        //         if (currentValue > 1) {
        //             quantityInput.val(currentValue - 1);
        //         }
        //     });
        // });
        $(document).ready(function() {
            // get the increment and decrement buttons
            var incrementBtn = $('#increment-btn');
            var decrementBtn = $('#decrement-btn');

            // get the quantity input
            var quantityInput = $('input[name="quantity"]');

            // add click event listener to increment button
            incrementBtn.click(function() {
                var currentValue = parseInt(quantityInput.val());
                quantityInput.val(currentValue + 1);

                // send quantity value to server
                $.ajax({
                    url: '/update-quantity',
                    type: 'POST',
                    data: {
                        quantity: quantityInput.val()
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // add click event listener to decrement button
            decrementBtn.click(function() {
                var currentValue = parseInt(quantityInput.val());
                if (currentValue > 1) {
                    quantityInput.val(currentValue - 1);

                    // send quantity value to server
                    $.ajax({
                        url: '/update-quantity',
                        type: 'POST',
                        data: {
                            quantity: quantityInput.val()
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $('.rating input').click(function() {
                var star = $(this).val();
                $('.rating label').removeClass('checked');
                for (i = 1; i <= star; i++) {
                    $('.rating #star' + i).siblings('label').addClass('checked');
                }
            });
        });
    </script>
@endpush
