@extends('layouts.dashboard.default')
@section('title', 'Detail Product')

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
                <li class="breadcrumb-item"><a href="{{url('/dashboard/product')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Product</li>
            </ol>
        </nav>
        <a href="{{url('/dashboard/product')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-circle-left fa-sm text-white-50"></i> Back to Product</a>
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
                    <input type="text" id="id" name="id" class="form-control" disabled><br>
                    <label for="name">Product name:</label><br>
                    <input type="text" id="name" name="name" class="form-control" disabled><br>
                    <label for="quantity">Product stock:</label><br>
                    <input type="text" id="quantity" name="quantity" class="form-control" disabled><br>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label for="price">Product Price:</label><br>
                    <input type="text" id="price" name="price" class="form-control" onkeyup="calc();" disabled><br>
                    <label for="discountPrice">Discount Price:</label><br>
                    <input type="text" id="discountPrice" name="discountPrice" class="form-control" onkeyup="calc();" disabled><br>
                    <label for="totalDiscount">Total Discount:</label><br>
                    <input type="text" id="totalDiscount" name="totalDiscount" class="form-control" disabled><br><br>
                    
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
    const productId = urlParams[6];

    $.ajax({
        type: 'GET',
        url: 'http://localhost/anterin-sayur/api/product/read/' + productId,
        success: function (data) {
            const productData = data.data;
            console.log(productData);
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

function calc() {
    var priceVal = $('#price').val();
    var discountVal = $('#discountPrice').val();
    var totalDiscVal = parseInt(priceVal) - parseInt(discountVal);
    if (!isNaN(totalDiscVal)) {
        $('#totalDiscount').val(totalDiscVal)
    }
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
    });

    $('#save-product').on('click', function() {
        const id = $('#id').val();
        const name = $('#name').val();
        const quantity = $('#quantity').val();
        const price = $('#price').val();
        const discountPrice = $('#discountPrice').val();
        const totalDiscount = $('#totalDiscount').val();

        var addedProduct = new FormData();
        addedProduct.append('productId',id);
        addedProduct.append('name',name);
        addedProduct.append('quantity',quantity);
        addedProduct.append('price',price);
        addedProduct.append('discountPrice',discountPrice);
        addedProduct.append('totalDiscount',totalDiscount);

        $.ajax({
            type: 'POST',
            url: 'http://localhost/anterin-sayur/api/product/update',
            data: addedProduct,
            contentType: false,
            processData: false,
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