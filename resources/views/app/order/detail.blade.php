@extends('layouts.dashboard.default')
@section('title', 'Detail Order')

@section('styles')
<style>
#set-paid {
    float: right;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard/order')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Order</li>
            </ol>
        </nav>
        <a href="{{url('/dashboard/order')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-circle-left fa-sm text-white-50"></i> Back to Order</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
                <button id="set-paid" class="btn btn-success btn-sm" onclick="setPaid();">Set Paid</button>
            <h6 class="m-0 font-weight-bold text-primary">Detail Product</h6>
        </div>
        <div class="card-body">
            <div class="row">
                    <div class="col-lg-6 col-md-6">
                    <label for="id">Order ID:</label><br>
                    <input type="text" id="id" name="id" class="form-control" disabled><br>
                    <label for="code">Order Code:</label><br>
                    <input type="text" id="code" name="code" class="form-control" disabled><br>
                    <label for="paymentDate">Payment Date:</label><br>
                    <input type="text" id="paymentDate" name="paymentDate" class="form-control" disabled><br>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label for="totalPrice">Total Price:</label><br>
                    <input type="text" id="totalPrice" name="totalPrice" class="form-control" disabled><br>
                    <label for="totalDiscount">Total Discount:</label><br>
                    <input type="text" id="totalDiscount" name="totalDiscount" class="form-control" disabled><br>
                    <label for="totalPayment">Total Payment:</label><br>
                    <input type="text" id="totalPayment" name="totalPayment" class="form-control" disabled><br><br>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$( document ).ready(function() {
    getAPIOrder();
});

function getAPIOrder() {
    const url = window.location.href;
    const urlParams = url.split("/");
    const orderId = urlParams[6];

    console.log(orderId);

    $.ajax({
        type: 'GET',
        url: 'http://localhost/anterin-sayur/api/order/read/' + orderId,
        success: function (data) {
            const orderData = data.data.order;
            const paymentDate = data.data.order.paymentDate;
            
            if(paymentDate == null) {
                $('#paymentDate').val("-");
            }

            $('#id').val(orderData.id);
            $('#paymentDate').val(paymentDate);
            $('#code').val(orderData.orderCode);
            $('#totalPrice').val(orderData.totalPrice);
            $('#totalDiscount').val(orderData.totalDiscount);
            $('#totalPayment').val(orderData.totalPayment);
        },
        timeout: 300000,
        error: function (e) {
            console.log(e);
        }
    });
}

function setPaid() {
    const orderId = $('#id').val();

    var orderData = new FormData();
    orderData.append('orderId', orderId);

    $.ajax({
        type: 'POST',
        url: 'http://localhost/anterin-sayur/api/order/set-paid-order',
        data: orderData,
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
}
</script>
@endsection