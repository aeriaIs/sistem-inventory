@extends('layouts.master')
 
@section('content')
<div class="row">
    <div class="col-md-12">
        <h4>{{ $title }}</h4>
        <div class="box box-warning">
            <div class="box-header">
                <p>
                    <button class="btn btn-sm btn-flat btn-warning btn-refresh"><i class="fa fa-refresh"></i> Refresh</button>
                    <a href="{{ route('purchase-order.create') }}" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-plus"></i> Buat Order </a>
                </p>
            </div>
            <div class="box-body">
               
                <div class="table-responsive">
                    <table class="table table-hover myTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Id</th>
                                <th>Supplier</th>
                                <th>Total Product</th>
                                <th>Status</th>
                                <th>Grand Total</th>
                                <th>Create At</th>
                                <th width="60">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $key => $order)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $order->purchaseId }}</td>
                                <td>{{ $order->supplier->name }}</td>
                                <td>{{ $order->details->count() }}</td>
                                @if($order->status->id == 1)
                                <td>
                                    <form action="{{ route('purchase-order.approve', $order->id) }}" method="POST" accept-charset="utf-8">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status_id" value="2"/>
                                        <button type="submit" class="btn btn-sm btn-warning btn-block confirm-main" onclick="return confirm('Apakah anda ingin menyetujui order?')"> Pending </button>
                                    </form>
                                </td>
                                @elseif($order->status->id == 2) 
                                <td>
                                    <form action="{{ route('purchase-order.approve', $order->id) }}" method="POST" accept-charset="utf-8">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status_id" value="1"/>
                                        <button type="submit" class="btn btn-sm btn-success btn-block confirm-main" onclick="return confirm('Apakah anda ingin menyetujui order?')"> Approved </button>
                                    </form>
                                </td>
                                @endif
                                <td>@currency($order->grand_total())</td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-M-Y H:m') }}</td>
                                <td>
                                    <div style="width:90px">
                                        <a href="{{ route('purchase-order.show', $order->id) }}" class="btn btn-info btn-xs btn-edit" id="detail"><i class="fa fa-eye"></i></a>
 
                                        <button href="{{ route('purchase-order.destroy', $order->id) }}" class="btn btn-danger btn-xs btn-hapus" id="delete"><i class="fa fa-trash-o"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
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