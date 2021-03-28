@extends('layouts.master')
 
@section('content')
 
<div class="row">
    <div class="col-md-12">
        <h4>{{ $title }}</h4>
        <div class="box box-warning">
            <div class="box-header">
                <p>
                    <button class="btn btn-sm btn-flat btn-warning btn-refresh"><i class="fa fa-refresh"></i> Refresh</button>
                    <a href="{{ route('product.index') }}" class="btn btn-sm btn-flat btn-info"><i class="fa fa-backward"></i> Back</a>
                </p>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Nama Supplier</th>
                                <td> : </td>
                                <td> {{ $product->supplier->name }} </td>

                                <th>Nama Product</th>
                                <td> : </td>
                                <td> {{ $product->name }} </td>
                            </tr>
                            <tr>
                                <th>Stock</th>
                                <td> : </td>
                                <td> {{ $product->stock }} </td>


                                <th>Minimal Stock</th>
                                <td> : </td>
                                <td> {{ $product->minimum_stock }} </td>
                            </tr>
                                <th>Harga Beli</th>
                                <td> : </td>
                                <td> @currency($product->buy_price) </td>

                                <th>Harga Jual</th>
                                <td> : </td>
                                <td> @currency($product->price) </td>
                            </tr>
                            <tr>
                                <th>Kode Produk</th>
                                <td> : </td>
                                <td> {{ $product->productId }} </td>

                                <th> Barcode </th>
                                <td> : </td>
                                <td>
                                    {!! \DNS1D::getBarcodeHTML('4445645656', 'I25+') !!}
                                </td>
                            </tr>
                            <tr>
                                <th>Didaftarkan Sejak </th>
                                <td> : </td>
                                <td> {{ \Carbon\Carbon::parse($product->created_at)->format('d-M-Y H:m') }} </td>

                                <th>Terakhir Diubah</th>
                                <td> : </td>
                                <td> {{ \Carbon\Carbon::parse($product->updated_at)->format('d-M-Y H:m') }} </td>
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