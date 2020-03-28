@extends('layouts.default')
@section('title', 'Add Product')

@section('styles')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Products</h1>
        <a href="{{url('/dashboard')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Back to Dashboard</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Details Product</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label for="name">Product name:</label><br>
                    <input type="text" id="name" name="name"><br>
                    <label for="quantity">Product stock:</label><br>
                    <input type="text" id="quantity" name="quantity"><br>
                    <label for="price">Product Price:</label><br>
                    <input type="text" id="price" name="price"><br>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label for="discountPrice">Discount Price:</label><br>
                    <input type="text" id="discountPrice" name="discountPrice"><br>
                    <label for="totalDiscount">Total Discount:</label><br>
                    <input type="text" id="totalDiscount" name="totalDiscount"><br><br>
                    <button id="add-product" class="btn btn-primary btn-lg">Add Data</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#add-product').on('click', function() {
        const name = $('#name');
        const quantity = $('#quantity');
        const price = $('#price');
        const discountPrice = $('#discountPrice');
        const totalDiscount = $('#totalDiscount');

        let addedProduct = {
            name: name.val(),
            quantity: quantity.val(),
            price: price.val(),
            discountPrice: discountPrice.val(),
            totalDiscount: totalDiscount.val(),
        }

        $.ajax({
            type: 'POST',
            url: 'http://localhost/anterin-sayur/api/product/create',
            data: addedProduct,
            success: function (data) {
                alert("Success");
            },
            timeout: 300000,
            error: function (e) {
                console.log(e);
            }
        });
    });
</script>
@endsection