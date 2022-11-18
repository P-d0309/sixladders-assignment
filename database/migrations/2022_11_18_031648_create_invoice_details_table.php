<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Invoice_Detail', function (Blueprint $table) {
            $table->id("InvoiceDetail_id");
            $table->integer("Invoice_Id");
            $table->integer("Product_Id");
            $table->double("Rate", 252, 2);
            $table->double("Unit", 252, 2);
            $table->double("Qty", 252, 2);
            $table->double("Disc_Percentage", 252, 2);
            $table->double("NetAmount", 252, 2);
            $table->double("TotalAmount", 252, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Invoice_Detail');
    }
};
