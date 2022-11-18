<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $table = "Invoice_Detail";
    protected $primaryKey = "InvoiceDetail_id";
    public $timestamps = false;

    public $fillable = ["Invoice_Id","Product_Id","Rate","Unit", "Qty", "Disc_Percentage", "NetAmount", "TotalAmount"];

    public function Product() {
        return $this->hasOne(Product::class, 'Product_ID', 'Product_Id');
    }
}
