@extends('layouts.default')
@section('title', 'Add Product')

@section('styles')
<style>
#edit-product {
    float: right;
}
#save-product {
    display: none;
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
                <li class="breadcrumb-item active" aria-current="page">Product</li>
            </ol>
        </nav>
        <a href="{{url('/dashboard')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-circle-left fa-sm text-white-50"></i> Back to Dashboard</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
                <button id="edit-product" class="btn btn-primary btn-sm">Edit Data</button>
                <button id="save-product" class="btn btn-primary btn-sm">Save Data</button>
            <h6 class="m-0 font-weight-bold text-primary">Detail Product</h6>
        </div>
        <div class="card-body">
            <div class="row">
                    <div class="col-lg-6 col-md-6">
                    <label for="id">Product ID:</label><br>
                    <input type="text" id="id" name="id" disabled><br>
                    <label for="name">Product name:</label><br>
                    <input type="text" id="name" name="name" disabled><br>
                    <label for="quantity">Product stock:</label><br>
                    <input type="text" id="quantity" name="quantity" disabled><br>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label for="price">Product Price:</label><br>
                    <input type="text" id="price" name="price" disabled><br>
                    <label for="discountPrice">Discount Price:</label><br>
                    <input type="text" id="discountPrice" name="discountPrice" disabled><br>
                    <label for="totalDiscount">Total Discount:</label><br>
                    <input type="text" id="totalDiscount" name="totalDiscount" disabled><br><br>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$( document ).ready(function() {
    getAPIProduct();
});

function getAPIProduct() {
    const url = window.location.href;
    const urlParams = url.split("/");
    const productId = urlParams[5];

    $.ajax({
        type: 'GET',
        url: 'http://localhost/anterin-sayur/api/product/read' + productId,
        success: function (data) {
            const productData = data.data;
            $('#id').val(productData.id);
            $('#name').val(productData.name);
            $('#price').val(productData.price);
            $('#quantity').val(productData.quantity);
            $('#discountPrice').val(productData.discountPrice);
            $('#totalDiscount').val(productData.totalDiscount);
        },
        timeout: 300000,
        error: function (e) {
            console.log(e);
        }
    });
}
</script>

<script>
    $('#edit-product').on('click', function() {
        $('#edit-product').css('display','none');
        $('#save-product').css('display','block');
        $('#save-product').removeClass('btn-primary');
        $('#save-product').addClass('btn-success');

        $('#name').prop('disabled', false);
        $('#quantity').prop('disabled', false);
        $('#price').prop('disabled', false);
        $('#discountPrice').prop('disabled', false);
        $('#totalDiscount').prop('disabled', false);
    });

    $('#save-product').on('click', function() {
        const id = $('#id');
        const name = $('#name');
        const quantity = $('#quantity');
        const price = $('#price');
        const discountPrice = $('#discountPrice');
        const totalDiscount = $('#totalDiscount');

        let addedProduct = {
            productId: id.val(),
            name: name.val(),
            quantity: quantity.val(),
            price: price.val(),
            discountPrice: discountPrice.val(),
            totalDiscount: totalDiscount.val(),
        }

        // console.log(addedProduct);

        $.ajax({
            type: 'POST',
            url: 'http://localhost/anterin-sayur/api/product/update',
            data: addedProduct,
            success: function (data) {
                location.reload();
            },
            timeout: 300000,
            error: function (e) {
                console.log(e);
            }
        });
    });
</script>
@endsection