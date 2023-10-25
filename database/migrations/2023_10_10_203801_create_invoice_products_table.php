<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoice_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('invoice_id');

            $table->index('product_id', 'invoice_products_product_idx');
            $table->index('invoice_id', 'invoice_products_invoice_idx');

            $table->foreign('product_id', 'invoice_products_product_fk')->references('id')->on('products');
            $table->foreign('invoice_id', 'invoice_products_invoice_fk')->references('id')->on('invoices');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_products');
    }
};
