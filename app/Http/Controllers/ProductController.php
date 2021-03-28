<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product, Supplier};
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Data Produk';
        $products = Product::orderBy('name', 'ASC')->get();

        return view('product.index', compact('title', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah Produk';
        $suppliers = Supplier::all();
        $code = Str::random(3).'-'.time().'-'.Str::random(4);

        return view('product.create', compact('title', 'suppliers', 'code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'supplier_id' => 'required',
            'name' => 'required',
            'productId' => 'required|unique:products',
            'minimum_stock' => 'required',
            'price' => 'required',
            'buy_price' => 'required'
        ]);

        $product = Product::create([
            'supplier_id' => $request->supplier_id,
            'name' => $request->name,
            'slug'=> \Str::slug($request->name, '-'),
            'productId' => $request->productId,
            'minimum_stock' => $request->minimum_stock,
            'price' => $request->price,
            'buy_price' => $request->buy_price,
        ]);

        \Session::flash('success', 'Berhasil menambahkan produk.');

        return redirect(route('product.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $title = 'Edit Produk '. $product->name;
        $suppliers = Supplier::get();

        return view("product.edit", compact('product', 'title', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'supplier_id' => 'required',
            'name' => 'required',
            'productId' => 'required',
            'minimum_stock' => 'required',
            'price' => 'required',
            'buy_price' => 'required'
        ]);

        $data = [
            'supplier_id' => $request->supplier_id,
            'name' => $request->name,
            'productId' => $request->productId,
            'minimum_stock' => $request->minimum_stock,
            'price' => $request->price,
            'buy_price' => $request->buy_price,
        ];

        $product = Product::findOrFail($id)->update($data);

        \Session::flash('success', 'Berhasil mengubah informasi produk.');

        return redirect(route('product.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            \Session::flash('success', 'Berhasil menghapus produk.');
        }catch (Exception $e) {
            \Session::flash('error', 'Gagal menghapus produk' . $e->getMessage());
        }

        return redirect(route('product.index'));

    }

    public function detail($id)
    {
        $title = 'Detail Produk';
        $product = Product::findOrFail($id);

        return view('product.detail', compact('title', 'product'));
    }
}
