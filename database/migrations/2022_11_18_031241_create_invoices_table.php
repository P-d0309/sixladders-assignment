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
        Schema::create('Invoice_Master', function (Blueprint $table) {
            $table->id("Invoice_Id");
            $table->integer("Invoice_no")->start_from(1000);
            $table->date("Invoice_Date");
            $table->string("CustomerName");
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
        Schema::dropIfExists('Invoice_Master');
    }
};
