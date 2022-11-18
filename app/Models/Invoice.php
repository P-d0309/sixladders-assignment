<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = "Invoice_Master";
    protected $primaryKey = "Invoice_Id";
    public $timestamps = false;

    public $fillable = ["Invoice_no","Invoice_Date","CustomerName","TotalAmount"];

    public function InvoiceDetails() {
        return $this->hasMany(InvoiceDetail::class, 'Invoice_Id', 'Invoice_Id');
    }
}
