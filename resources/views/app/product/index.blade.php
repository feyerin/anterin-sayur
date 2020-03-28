@extends('layouts.default')
@section('title', 'Product')

@section('styles')
<link href="{{asset('public/templates/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<style>
.dataTables_empty, .dataTables_info {
    display: none !important;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
        <a href="{{url('/add')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Add Product</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Discount Price</th>
                            <th>Total Discount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Product Name</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Discount Price</th>
                            <th>Total Discount</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody id="table-product">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('public/templates/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/templates/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/templates/js/demo/datatables-demo.js')}}"></script>

<script>
$( document ).ready(function() {
    getAPIProduct();
});

function getAPIProduct() {
    $.ajax({
        type: 'GET',
        url: 'http://localhost/anterin-sayur/api/product',
        beforeSend: function () {},
        success: function (data) {
            tableProduct(data);
        },
        timeout: 300000,
        error: function (e) {
            console.log(e);
        }
    });
}

function tableProduct(data) {
    const product = data.data;
    let markup;

    for(index in product) {
        markup = '<tr><td>'+ product[index].name +'</td><td>'+ product[index].quantity +'</td>'+
        '<td>'+ product[index].price +'<td>'+ product[index].discountPrice +'<td>'+ product[index].totalDiscount +'</td>'+
        '<td><button class="btn btn-warning btn-sm" onclick="detailProduct('+ product[index].id +')">Detail</button>&nbsp;'+
        '<button class="btn btn-danger btn-sm" onclick="deleteProduct('+ product[index].id +')">Delete</button></td></tr>';
        $('#table-product').append(markup);
    }
}

function detailProduct(id) {
    const productId = id;
    const url = "detail/"
    var win = window.open(url + productId, '_blank');
    win.focus();
}

// function deleteProduct(data) {
//     console.log(data);
//     const productId = data;
//     $.ajax({
//         type: 'DELETE',
//         contentType: "application/json",
//         data: {productId: productId},
//         url: 'http://localhost/anterin-sayur/api/product/delete',
//         beforeSend: function () {},
//         success: function (data) {
//             // location.reload();
//         },
//         timeout: 300000,
//         error: function (e) {
//             console.log(e);
//         }
//     });
// }
</script>
@endsection