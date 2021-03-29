@extends('layouts.master')
 
@section('content')
<div class="row">
    <div class="col-md-12">
        <h4>{{ $title }}</h4>
        <div class="box box-warning">
            <div class="box-header">
                <p>
                    <button class="btn btn-sm btn-flat btn-warning btn-refresh"><i class="fa fa-refresh"></i> Refresh</button>
                </p>
            </div>
            <div class="box-body">
               
                <div class="table-responsive">
                    <table class="table table-hover myTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Good Receipt Id</th>
                                <th>Purchase Order Id</th>
                                <th>Total Item</th>
                                <th>Grand Total</th>
                                <th>Status</th>
                                <th>Dibuat Pada</th>
                                <th width="60">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($goodreceipts as $key => $goodreceipt)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $goodreceipt->goodReceiptId }}</td>
                                <td>{{ $goodreceipt->purchase_order->purchaseId }}</td>
                                <td>{{ $goodreceipt->total_item() }}</td>
                                <td>@currency($goodreceipt->purchase_order->grand_total())</td>
                                @if($goodreceipt->status->id == 1)
                                <td>
                                    <button type="submit" class="btn btn-sm btn-warning btn-block confirm-main" onclick="return confirm('Apakah anda ingin menyetujui good receipt?')" disabled> Pending </button>
                                </td>
                                @elseif($goodreceipt->status->id == 2) 
                                <td>
                                    <button type="submit" class="btn btn-sm btn-success btn-block confirm-main" onclick="return confirm('Apakah anda ingin menyetujui good receipt?')" disabled> Approved </button>
                                </td>
                                @endif
                                <td>{{ \Carbon\Carbon::parse($goodreceipt->created_at)->format('d-M-Y H:m') }}</td>
                                <td>
                                    <div style="width:90px">
                                        <a href="{{ route('good-receipt.show', $goodreceipt->id) }}" class="btn btn-info btn-xs btn-edit" id="detail"><i class="fa fa-eye"></i></a>
 
                                        <button href="{{ route('good-receipt.destroy', $goodreceipt->id) }}" class="btn btn-danger btn-xs btn-hapus" id="delete"><i class="fa fa-trash-o"></i></button>
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