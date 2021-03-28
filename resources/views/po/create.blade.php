@extends('layouts.master')
 
@section('content')
 
<div class="row">
    <div class="col-md-12">
        <h4>{{ $title }}</h4>
        <div class="box box-warning">
          <form role="form" method="post" action="{{ route('purchase-order.store') }}">
            @csrf
            <div class="box-body">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Purchase Order Id</label>
                  <input type="text" name="purchaseId" class="form-control" id="exampleInputEmail1" placeholder="Order Id" value="{{ $purchaseId }}" readonly>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Pilih Supplier</label>
                  <select class="form-control" name="supplier">
                    <option> Pilih Supplier </option>
                      @foreach($suppliers as $supplier)
                      <option value="{{ $supplier->id }}"
                        @if(isset($products))
                          @if($supplier->id == $supplierx->id)
                          selected
                          @endif
                        @endif
                      >{{ $supplier->name }}</option>
                      @endforeach
                  </select>
                </div>
              </div>

              @if(isset($products))
              <div class="row">
                <div class="col-md-12">
                  <table class="table myTable table-responsive">
                    <thead>
                      <tr>
                        <th> # </th>
                        <td>Nama</td>
                        <td>Price</td>
                        <td>Quantity</td>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($products as $key => $product)
                      <tr>
                        <td> {{ $key+1 }}</td>
                        <td> {{ $product->name }}</td>
                        <td> @currency($product->buy_price) </td>
                        <td>
                          <input type="hidden" name="product[]" value="{{ $product->id }}">
                          <input type="number" name="qty[]" class="form-control" value="0">
                        </td> 
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              @endif
            </div>

            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
          </form>
        </div>
    </div>
</div>
 
@endsection
 
@section('scripts')
 
<script type="text/javascript">
    $(document).ready(function(){

      $("select[name='supplier']").change(function(e) {
        let supplier_id = $(this).val();
        let url = "{{ url('/purchase-order/product') }}"+"/"+supplier_id;

        window.location.href = url;
      });
 
        // btn refresh
        $('.btn-refresh').click(function(e){
            e.preventDefault();
            $('.preloader').fadeIn();
            location.reload();
        })
 
    })
</script>
 
@endsection