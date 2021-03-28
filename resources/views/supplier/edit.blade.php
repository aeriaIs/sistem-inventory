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
               
                <form role="form" method="post" action="{{ route('supplier.update', $supplier->id) }}">
                    @csrf
                    @method('PATCH')
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama Supplier</label>
                      <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Nama Supplier" value="{{ $supplier->name }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">No Telp</label>
                      <input type="number" name="phone" class="form-control" id="exampleInputPassword1" placeholder="No Telp" value="{{ $supplier->phone }}">
                    </div>
                   
                    <div class="form-group">
                      <label for="exampleInputPassword1">Alamat</label>
                      <textarea class="form-control" name="address" rows="5">{{ $supplier->address }}</textarea>
                    </div>
                   
                  </div>
                  <!-- /.box-body -->
     
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                  </div>
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
 
    })
</script>
 
@endsection