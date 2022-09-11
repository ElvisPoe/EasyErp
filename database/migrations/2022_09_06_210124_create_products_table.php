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
            $table->integer('organization_id');
            $table->string('title', 250);
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->float('price');
            $table->float('sale_price')->nullable();
            $table->string('sku', 50)->nullable();
            $table->string('barcode', 50)->nullable();
            $table->integer('quantity')->default(0);
            $table->float('weight')->nullable();
            $table->boolean('has_variations')->default(false);
            $table->text('images')->nullable();
            $table->boolean('published')->default(false);
            $table->foreignId('category_id')->nullable();
            $table->foreignId('parent_product')->nullable();
            $table->string('attribute_label')->nullable();
            $table->string('attribute_value')->nullable();
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
        Schema::dropIfExists('products');
    }
}
