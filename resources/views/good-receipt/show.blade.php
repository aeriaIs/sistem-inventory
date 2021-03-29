@extends('layouts.master')
 
@section('content')
 
<div class="row">
    <div class="col-md-12">
        <h4 class="title">{{ $title }}</h4>
        <div class="box box-warning">
            <div class="box-header">
                <p>
                    <button class="btn btn-sm btn-flat btn-warning btn-refresh"><i class="fa fa-refresh"></i> Refresh</button>
                    <a href="{{ route('good-receipt.index') }}" class="btn btn-sm btn-flat btn-info"><i class="fa fa-backward"></i> Back</a>
                    @if($goodreceipt->status->id == 1)
                    <button class="btn btn-secondary btn-sm btn-approve" id="approve"><i class="fa fa-book"></i> Approve </button>
                    @else
                    <button class="btn btn-success btn-sm" ><i class="fa fa-book"></i> Approved </button>
                    @endif
                </p>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Good Receipt Id</th>
                                <td> : </td>
                                <td> {{ $goodreceipt->goodReceiptId }} </td>

                                <th>Order Id</th>
                                <td> : </td>
                                <td> {{ $order->purchaseId }} </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td> : </td>
                                @if($goodreceipt->status->id == 1)
                                    <td>
                                        <button class="btn btn-xs btn-warning btn-block"> Pending </button>
                                    </td>
                                    @elseif($goodreceipt->status->id == 2) 
                                    <td>
                                        <button class="btn btn-xs btn-success btn-block"> Complete </button>
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
        <h4>Detail Order - {{ $order->purchaseId }}</h4>
        <div class="box box-warning">
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
                                        <button class="btn btn-xs btn-warning btn-block"> Pending </button>
                                    </td>
                                    @elseif($order->status->id == 2) 
                                    <td>
                                        <button class="btn btn-xs btn-success btn-block"> Approved </button>
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
                @if($order->status->id == 1)
                    <a href="{{ route('purchase-order.edit', $order->id) }}" class="btn btn-info btn-sm btn-edit" id="edit">
                        <i class="fa fa-pencil-square-o"></i>
                            Edit Items
                    </a>
                @endif
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <form action="{{ route('purchase-order.update-qty', $order->id) }}" method="POST" accept-charset="utf-8">
                        @csrf
                        @method('PATCH')
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
                                   $qty_total += $order_detail->qty;
                                ?>
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $order_detail->product->name }}</td>
                                    @if($order->status->id == 1)
                                    <td>
                                        <input type="number" name="buy_price[]" class="form-control" value="{{ $order_detail->buy_price }}">
                                    </td>
                                    <td>
                                        <input type="number" name="qty[]" class="form-control" value="{{ $order_detail->qty }}">
                                        <input type="hidden" name="detail_id[]" class="form-control" value="{{ $order_detail->id }}">
                                        <input type="hidden" name="products[]" class="form-control" value="{{ $order_detail->product_id }}">
                                    </td>
                                    @else 
                                    <td> @currency($order_detail->buy_price) </td>
                                    <td> {{ $order_detail->qty }} </td>
                                    @endif
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
                        @if($order->status->id == 1)
                        <div>
                            <button type="submit" class="btn btn-block btn-primary">Update Qty</button>
                        </div>
                        @endif
                    </form>
                </div>      
            </div>
        </div>
    </div>
</div>

<!-- MODAL APPROVE -->
<div class="modal fade" id="modal-approve" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
  <div class="modal-dialog modal-default modal-dialog-centered modal-" role="document">
    <div class="modal-content bg-gradient-danger">

      <div class="modal-header">
        <h6 class="modal-title" id="modal-title-notification">Approve </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>

      <div class="modal-body">

        <div class="py-3 text-center">
          <i class="ni ni-bell-55 ni-3x"></i>
          <h4 class="heading mt-4">Apakah kamu yakin ingin meng-approve good receipt ini?</h4>
        </div>

      </div>

      <div class="modal-footer">
        <form action="{{ route('good-receipt.approve', $goodreceipt->id) }}" method="post">
          @csrf
          @method('PATCH')
          <input type="hidden" name="status_id" value="2">
          <p>
          <button type="submit" class="btn btn-success btn-flat btn-sm menu-sidebar">Approve</button>
            <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
          </p>
        </form>
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

        //Modal approve
        $('body').on('click','.btn-approve',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            $('#modal-approve').find('form').attr('action',url);
            $('#modal-approve').modal();
        });
 
    })
</script>
 
@endsection