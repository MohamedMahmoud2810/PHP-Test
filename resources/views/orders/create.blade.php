<!-- resources/views/orders/create.blade.php -->

@extends('layouts.main')

@section('title', 'Create Order')

@section('content')
    <div class="container">
        <h2>Create New Order</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf

            <!-- User Name (Auto-complete) -->
            <div class="mb-3">
                <label for="user_name" class="form-label">User Name</label>
                <input type="text" class="form-control @error('user_name') is-invalid @enderror" id="user_name" name="user_name" required autocomplete="off" value="{{ old('user_name') }}">
                <input type="hidden" id="user_id" name="user_id" value="{{ old('user_id') }}">
                <div id="user_list"></div> <!-- Container for displaying search results -->
                @error('user_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Other Fields for Order Registration -->
            <div class="mb-3">
                <label for="product" class="form-label">Product</label>
                <input type="text" class="form-control @error('product') is-invalid @enderror" id="product" name="product" required value="{{ old('product') }}">
                @error('product')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" required value="{{ old('quantity') }}">
                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" required value="{{ old('price') }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $("#user_name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('users.search') }}",
                        dataType: 'json',
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 2, // Minimum characters before triggering search
                select: function(event, ui) {
                    $("#user_name").val(ui.item.label);
                    $("#user_id").val(ui.item.value);
                    return false;
                },
                focus: function(event, ui) {
                    event.preventDefault(); // Prevent the input field from being updated on focus
                }
            });
        });
    </script>
    @endpush
@endsection
