<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{GoodReceipt, PurchaseOrder, Product, Supplier, PurchaseOrderDetail};

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'List Purchase Order';
        $orders = PurchaseOrder::withCount('details')->orderBy('created_at', 'desc')->get();

        return view('po.index', compact('orders', 'title'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Order';
        $purchaseId = 'PO-'.\Str::random(4).'-'.time();
        $suppliers = Supplier::orderBy('name', 'asc')->get();

        return view('po.create', compact('title', 'purchaseId', 'suppliers'));
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
            'product' => 'required',
            'qty' => 'required',
        ]);

        try {
            $product = $request->product;
            $qty = $request->qty;
            $purchaseId = $request->purchaseId;
            $supplier =  $request->supplier;

            $purchase_id = PurchaseOrder::insertGetId([
                'purchaseId' => $purchaseId,
                'supplier_id' => $supplier,
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            foreach($qty as $key => $qt) {
                if($qt == 0) {
                    continue;
                }

                $detail_product = Product::where('id', $product[$key])->first();
                $buy_price = $detail_product->buy_price;
                $sub_total = $buy_price * $qt;

                $po_detail = PurchaseOrderDetail::insert([
                    'purchase_order_id' => $purchase_id,
                    'product_id' => $product[$key],
                    'qty' => $qt,
                    'buy_price' => $buy_price,
                    'sub_total' => $sub_total,
                    'created_at' => now(),
                    'updated_at' => date('Y-m-d H:i:s')
                ]); 
            }
            \Session::flash('success', 'Berhasil membuat purchase order.');

            return redirect(route('purchase-order.index'));
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = PurchaseOrder::findorfail($id);
        $title = 'Detail Order ' . $order->purchaseId;

        return view('po.show', compact('title', 'order'));
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

    public function getProduct($supplier) {
        $title = 'Create Purchase Order';
        $purchaseId = 'PO-'.\Str::random(4).'-'.time();
        $suppliers = Supplier::orderBy('name', 'asc')->get();
        $supplierx = Supplier::where('id', $supplier)->first();
        $products = $supplierx->products;

        return view('po.create', compact('title', 'purchaseId', 'products', 'suppliers', 'supplierx'));
    }

    public function approve(Request $request, $id) {
        try {
            $po = PurchaseOrder::findorfail($id);

            if($request->status_id == 2) {
                $po->update([
                    'status_id' => 2
                ]);

                $receipt = GoodReceipt::insert([
                    'purchase_order_id' => $po->id,
                    'goodReceiptId' => \Str::random(5).'-'.time().'-'.\Str::random(4),
                    'status_id' => 1,
                    'created_at' => now(),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            }else {
                $receipt = GoodReceipt::where('purchase_order_id', $po->id)->delete();

                $po->update([
                    'status_id' => 1
                ]);
            }

            \Session::flash('success', 'Berhasil mengubah status Order');

            return redirect(route('purchase-order.index'));
            
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());

            return redirect()->back();
        }
    }

    public function deleteItem($id) {
        try {
            $po_detail = PurchaseOrderDetail::where('id', $id)->first();
            $po_detail->delete();

            \Session::flash('success', 'Item Berhasil dihapus dari daftar.');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());

        }

        return redirect()->back();
    }

    public function updateQty(Request $request, $id) {
        try {
            $quantity = $request->qty;
            $order_detail_id = $request->detail_id;
            $buy_price = $request->buy_price;
            $products = $request->products;

            foreach($quantity as $key => $qty) {
                $data['qty'] = $qty;
                $data['sub_total'] = $qty * $buy_price[$key];
                $data['buy_price'] = $buy_price[$key];
                $detail_id = $order_detail_id[$key];

                PurchaseOrderDetail::where('id', $detail_id)->update($data);
                Product::where('id', $products[$key])->update([
                    'buy_price' => $data['buy_price'],
                ]);
            }

            \Session::flash('success', 'Item Berhasil diperbarui..');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());

        }

        return redirect()->back();
    }
}
