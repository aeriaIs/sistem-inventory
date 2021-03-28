<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    protected $table = 'purchase_order_details';

    protected $guarded = [];

    public function product() {
    	return $this->belongsTo(Product::class);
    }

    public function order() {
    	return $this->belongsTo(PurchaseOrder::class);
    }
}
