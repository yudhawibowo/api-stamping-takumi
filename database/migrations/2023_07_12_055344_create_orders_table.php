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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tgl_order');
            $table->unsignedBigInteger('id_customer');
            $table->string('po_number');
            $table->string('quotation_number');
            $table->string('so_number');
            $table->string('product_name');
            $table->string('product_number');
            $table->string('qty');
            $table->string('material_supply');
            $table->string('internal_order_number');
            $table->text('notes')->nullable();
            $table->text('upload_file')->nullable();
            $table->unsignedBigInteger('id_pegawai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
