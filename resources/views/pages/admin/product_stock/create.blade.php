@extends('layouts.admin')

@section('title')
    Product
@endsection

@section('content')
    <!-- Section Content-->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Product</h2>
                <p class="dashboard-subtitle">
                    Create New Product
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nama Product</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select name="categories_id" id="category-select" class="form-control">
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Harga Product</label>
                                                <input type="number" name="price" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Deskripsi Product</label>
                                                <textarea name="description" id="editor" cols="30" rows="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Stock</label>
                                                <input type="number" name="stock[]" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Product Has Size?</label>
                                                <input type="checkbox" name="has_size" value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Size (Optional)</label>
                                                <input type="text" name="size[]" class="form-control">
                                            </div>
                                        </div>

                                        <div id="dynamic-inputs"></div>

                                        <button type="button" id="add-inputs-btn" class="btn btn-primary">Tambah
                                            Inputan</button>


                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-success px-5">
                                                Save Now
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </section>
@endsection

@push('addon-script')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Function to create new input elements
        function createNewInput() {
            var newStockInput = document.createElement('div');
            newStockInput.className = 'col-md-12';
            newStockInput.innerHTML =
                '<div class="form-group"><label>Stock</label><input type="number" name="stock[]" class="form-control" required></div>';

            var newSizeInput = document.createElement('div');
            newSizeInput.className = 'col-md-12';
            newSizeInput.innerHTML =
                '<div class="form-group"><label>Size (Optional)</label><input type="text" name="size[]" class="form-control"></div>';

            var newInputsContainer = document.createElement('div');
            newInputsContainer.className = 'row';
            newInputsContainer.appendChild(newStockInput);
            newInputsContainer.appendChild(newSizeInput);

            return newInputsContainer;
        }

        // Function to add new input elements to the page
        function addNewInputs() {
            var newInputs = createNewInput();
            var dynamicInputsContainer = document.getElementById('dynamic-inputs');
            dynamicInputsContainer.appendChild(newInputs);
        }

        // Add event listener to the "Tambah Inputan" button
        var addInputsButton = document.getElementById('add-inputs-btn');
        addInputsButton.addEventListener('click', addNewInputs);
    </script>
@endpush
