@extends('layouts.dashboard.default')
@section('title', 'Add Product')

@section('styles')
<style>
#add-product {
    float: right;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Product</li>
            </ol>
        </nav>
        <a href="{{url('/dashboard/product')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-circle-left fa-sm text-white-50"></i> Back to Product</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button id="add-product" class="btn btn-success btn-sm">Add Data</button>
            <h6 class="m-0 font-weight-bold text-primary">Details Product</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label for="name">Product name:</label><br>
                    <input type="text" id="name" name="name" class="form-control"><br>
                    <label for="quantity">Product stock:</label><br>
                    <input type="text" id="quantity" name="quantity" class="form-control"><br>
                    <label for="quantity">Product image:</label><br>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label for="price">Product Price:</label><br>
                    <input type="text" id="price" name="price" class="form-control" onkeyup="calc();"><br>
                    <label for="discountPrice">Discount Price:</label><br>
                    <input type="text" id="discountPrice" name="discountPrice" class="form-control" onkeyup="calc();"><br>
                    <label for="totalDiscount">Total Discount:</label><br>
                    <input type="text" id="totalDiscount" name="totalDiscount" class="form-control" disabled><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $('#add-product').on('click', function() {
        const name = $('#name');
        const quantity = $('#quantity');
        const image = $('#image');
        const price = $('#price');
        const discountPrice = $('#discountPrice');
        const totalDiscount = $('#totalDiscount');
        var valBoundary = Math.random().toString().substr(2);

        let addedProduct = {
            name: name.val(),
            quantity: quantity.val(),
            image: image.val(),
            price: price.val(),
            discountPrice: discountPrice.val(),
            totalDiscount: totalDiscount.val(),
        }

        $.ajax({
            type: 'POST',
            contentType: 'multipart/form-data; charset=utf-8; boundary=' + valBoundary,
            url: 'http://localhost/anterin-sayur/api/product/create',
            data: addedProduct,
            success: function (data) {
                window.location.href="dashboard";
            },
            timeout: 300000,
            error: function (e) {
                console.log(e);
            }
        });
    });

    function calc() {
        var priceVal = $('#price').val();
        var discountVal = $('#discountPrice').val();
        var totalDiscVal = parseInt(priceVal) - parseInt(discountVal);
        if (!isNaN(totalDiscVal)) {
            $('#totalDiscount').val(totalDiscVal);
        }
    }
</script>
@endsection