<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id')->nullable();
            $table->string('title', 250);
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->float('price');
            $table->float('sale_price');
            $table->string('sku', 50)->nullable();
            $table->string('barcode', 50)->nullable();
            $table->float('weight')->nullable();
            $table->boolean('has_variations');
            $table->text('images')->nullable();
            $table->boolean('published');
            $table->foreignId('category_id');
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
        Schema::dropIfExists('products');
    }
}
