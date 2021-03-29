<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{GoodReceipt, PurchaseOrder, Product, Status};

class GoodReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Good Receipt';
        $goodreceipts = GoodReceipt::orderBy('created_at', 'desc')->get();

        return view('good-receipt.index', compact('title', 'goodreceipts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $goodreceipt = GoodReceipt::findorfail($id);
        $title = 'Detail Good Receipt - '. $goodreceipt->goodReceiptId;
        $order =  PurchaseOrder::where('id', $goodreceipt->purchase_order_id)->first();

        return view('good-receipt.show', compact('title', 'goodreceipt', 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function approve(Request $request, $id) {
        try {
            $gr = GoodReceipt::findorfail($id);

            if($gr->status->id == 2) {
                \Session::flash('error', 'Maaf Good Receipt sudah di approve');

                return redirect()->back();
            }

            \DB::transaction(function()use($id, $gr) {
                GoodReceipt::where('id', $id)->update([
                    'status_id' => 2,
                ]);

                foreach($gr->purchase_order->details as $detail) {
                    $qty = $detail->qty;
                    $product = $detail->product_id;

                    $product = Product::findorfail($product);
                    $current_stock = $product->stock;
                    $update_stock = $current_stock += $qty;

                    $product->update([
                        'stock' => $update_stock,
                    ]);
                }
            }); 
            
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());

            return redirect()->back();
        }

       

        \Session::flash('success', 'Berhasil meng-approve Good Receipt');

        return redirect()->back();
    }
}
