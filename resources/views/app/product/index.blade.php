@extends('layouts.dashboard.default')
@section('title', 'Product')

@section('styles')
<link href="{{asset('public/templates/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
        <a href="{{url('/add')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Add Product</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Products Tables</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-product" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Discount Price</th>
                            <th>Total Discount</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Discount Price</th>
                            <th>Total Discount</th>
                            {{-- <th>Action</th> --}}
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
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.bootstrap.min.js"></script>

<script>
$( document ).ready(function() {
    tableProduct();
});

function tableProduct() {
    var table = $('#table-product').DataTable({
        "dom": 'Bfrtip',
        "buttons": [
            {
                text: 'Detail',
                className: 'btn btn-warning',
                action: function () {
                    let dataTable = table.rows( { selected: true } ).data();
                    let productId = dataTable[0].id;

                    window.location.href="detail/"+productId;
                }
            },
            {
                text: 'Delete',
                className: 'btn btn-danger',
                action: function () {
                    let dataTable = table.rows( { selected: true } ).data();
                    let productId = dataTable[0].id;

                    deleteProduct(productId);
                }
            }
        ],
        "select": {
            style: 'single'
        },
        "ajax": {
            "url": 'http://localhost/anterin-sayur/api/product',
            "type": 'GET'
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "quantity" },
            { "data": "price", render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' ) },
            { "data": "discountPrice", render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )  },
            { "data": "totalDiscount", render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )  }
        ],
    });
}

function deleteProduct(data) {
    let deletedProduct = {
        productId: data,
    }

    $.ajax({
        type: 'POST',
        data: deletedProduct,
        url: 'http://localhost/anterin-sayur/api/product/delete',
        success: function (data) {
            location.reload();
        },
        timeout: 300000,
        error: function (e) {
            console.log(e);
        }
    });
}
</script>
@endsection