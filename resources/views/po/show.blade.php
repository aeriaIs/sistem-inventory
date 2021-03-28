@extends('layouts.master')
 
@section('content')
 
<div class="row">
    <div class="col-md-12">
        <h4>{{ $title }}</h4>
        <div class="box box-warning">
            <div class="box-header">
                <p>
                    <button class="btn btn-sm btn-flat btn-warning btn-refresh"><i class="fa fa-refresh"></i> Refresh</button>
                    <a href="{{ route('purchase-order.index') }}" class="btn btn-sm btn-flat btn-info"><i class="fa fa-backward"></i> Back</a>
                </p>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Nama Supplier</th>
                                <td> : </td>
                                <td> {{ $order->supplier->name }} </td>

                                <th>Order Id</th>
                                <td> : </td>
                                <td> {{ $order->purchaseId }} </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td> : </td>
                                @if($order->status->id == 1)
                                    <td>
                                        <form action="{{ route('purchase-order.approve', $order->id) }}" method="POST" accept-charset="utf-8">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_id" value="2"/>
                                            <button type="submit" class="btn btn-xs btn-warning btn-block confirm-main" onclick="return confirm('Apakah anda ingin menyetujui order?')"> Pending </button>
                                        </form>
                                    </td>
                                    @elseif($order->status->id == 2) 
                                    <td>
                                        <form action="{{ route('purchase-order.approve', $order->id) }}" method="POST" accept-charset="utf-8">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_id" value="1"/>
                                            <button type="submit" class="btn btn-xs btn-success btn-block confirm-main" onclick="return confirm('Apakah anda ingin menyetujui order?')"> Approved </button>
                                        </form>
                                    </td>
                                @endif

                                <th>Didaftarkan Sejak </th>
                                <td> : </td>
                                <td> {{ \Carbon\Carbon::parse($order->created_at)->format('d-M-Y H:m') }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>      
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header">
                <a href="{{ route('purchase-order.edit', $order->id) }}" class="btn btn-info btn-sm btn-edit" id="edit">
                    <i class="fa fa-pencil-square-o"></i>
                    Edit Items
                </a>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover myTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Sub Total</th>
                                <th width="60">Action</th>
                            </tr>
                        </thead>
                        <?php 
                           $grand_total = 0;
                           $qty_total = 0;
                        ?>
                        <tbody>
                            @foreach($order->details as $key => $order_detail)
                            <?php 
                               $grand_total += $order_detail->grand_total;
                               $qty_total = $order_detail->qty;
                            ?>
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $order_detail->product->name }}</td>
                                <td>@currency($order_detail->buy_price)</td>
                                <td>
                                    <input type="number" name="qty[]" class="form-control" value="{{ $order_detail->qty }}">
                                </td>
                                <td>@currency($order_detail->sub_total)</td>
                                <td>
                                    <div style="width:40px"> 
                                        <button href="{{ route('purchase-order.delete-item', $order_detail->id) }}" class="btn btn-danger btn-xs btn-hapus" id="delete"><i class="fa fa-trash-o"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tbody>
                            <tr>
                                <th>
                                    <b><i>Items Total</i></b>
                                </th>
                                <th>
                                    <b><i>{{ $qty_total }}</i></b>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <b><i>Grand Total</i></b>
                                </th>
                                <th>
                                    <b><i>@currency($order->grand_total())</i></b>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>      
            </div>
        </div>
    </div>
</div>
 
@endsection
 
@section('scripts')
 
<script type="text/javascript">
    $(document).ready(function(){
 
        // btn refresh
        $('.btn-refresh').click(function(e){
            e.preventDefault();
            $('.preloader').fadeIn();
            location.reload();
        })
 
    })
</script>
 
@endsection