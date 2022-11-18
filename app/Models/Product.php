<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $table = "Product_Master";
    public $primaryKey = "Product_ID";
    public $timestamps = false;

    public $fillable = ["Product_ID","Product_Name","Rate","Unit"];
}
