@extends('layouts.dashboard.default')
@section('title', 'Order')

@section('styles')
<link href="{{asset('public/templates/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Orders</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Orders Tables</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-order" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Code</th>
                            <th>Name</th>
                            <th>Total Price</th>
                            <th>Total Discount</th>
                            <th>Total Payment</th>
                            <th>Payment Date</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Code</th>
                            <th>Name</th>
                            <th>Total Price</th>
                            <th>Total Discount</th>
                            <th>Total Payment</th>
                            <th>Payment Date</th>
                        </tr>
                    </tfoot>
                    <tbody>
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
    tableOrder();
});

function tableOrder() {

    var table = $('#table-order').DataTable({
        "dom": 'Bfrtip',
        "buttons": [
            {
                text: 'Detail',
                className: 'btn btn-warning',
                action: function () {
                    let dataTable = table.rows( { selected: true } ).data();
                    let orderId = dataTable[0].id;

                    window.location.href="{{url('order/detail')}}/"+orderId;
                }
            }
        ],
        "select": {
            style: 'single'
        },
        "ajax": {
            "url": "{{url('api/order')}}",
            "type": 'GET'
        },
        "columns": [
            { "data": "id" },
            { "data": "orderCode" },
            { "data": "name" },
            { "data": "totalPrice", render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' ) },
            { "data": "totalDiscount", render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )  },
            { "data": "totalPayment", render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )  },
            { "data": "paymentDate" }
        ],
    });
}
</script>
@endsection