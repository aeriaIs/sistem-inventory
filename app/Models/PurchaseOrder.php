<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_orders';

    protected $guarded = [];

    public function supplier() {
    	return $this->belongsTo(Supplier::class);
    }

    public function status() {
    	return $this->belongsTo(Status::class);
    }

    public function details() {
    	return $this->hasMany(PurchaseOrderDetail::class);
    }

    public function grand_total() {
    	$purchase_order = $this->id;

    	$grand_total = PurchaseOrderDetail::where('purchase_order_id', $purchase_order)->sum('sub_total');

    	return $grand_total; 
    }
}
