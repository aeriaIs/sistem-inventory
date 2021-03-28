@extends('layouts.master')
 
@section('content')
<div class="row">
    <div class="col-md-12">
        <h4>{{ $title }}</h4>
        <div class="box box-warning">
            <div class="box-header">
                <p>
                    <button class="btn btn-sm btn-flat btn-warning btn-refresh"><i class="fa fa-refresh"></i> Refresh</button>
                    <a href="{{ route('product.create') }}" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-plus"></i> Tambah Produk </a>
                </p>
            </div>
            <div class="box-body">
               
                <div class="table-responsive">
                    <table class="table table-hover myTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Supplier</th>
                                <th>Nama</th>
                                <th>Kode</th>
                                <th>Stock</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th width="60">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $key => $product)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $product->supplier->name }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->productId }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>@currency($product->buy_price)</td>
                                <td>@currency($product->price)</td>
                                <td>
                                    <div style="width:90px">
                                        <a href="{{ route('product.detail', $product->id) }}" class="btn btn-info btn-xs btn-edit" id="detail"><i class="fa fa-eye"></i></a>

                                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning btn-xs btn-edit" id="edit"><i class="fa fa-pencil-square-o"></i></a>
 
                                        <button href="{{ route('product.destroy', $product->id) }}" class="btn btn-danger btn-xs btn-hapus" id="delete"><i class="fa fa-trash-o"></i></button>
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