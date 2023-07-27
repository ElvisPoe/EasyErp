<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product')->nullable();
            $table->string('title', 250);
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->float('price');
            $table->float('sale_price')->nullable();
            $table->string('sku', 50)->nullable();
            $table->string('barcode', 50)->nullable();
            $table->integer('quantity')->default(0);
            $table->float('weight')->nullable();
            $table->text('images')->nullable();
            $table->boolean('published')->default(false);
            $table->foreignId('attribute_id');
            $table->foreignId('attribute_value_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variations');
    }
}
