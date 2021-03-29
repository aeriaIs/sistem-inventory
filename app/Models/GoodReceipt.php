<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodReceipt extends Model
{
    protected $fillable = ['purchase_order_id', 'status_id', 'GoodReceiptId'];

    public function status() {
    	return $this->belongsTo(Status::class);
    }

    public function purchase_order() {
    	return $this->belongsTo(PurchaseOrder::class);
    }

    public function total_item() {
    	$po = $this->purchase_order;
    	$total = PurchaseOrderDetail::where('purchase_order_id', $po->id)->count();

    	return $total;
    }
}
