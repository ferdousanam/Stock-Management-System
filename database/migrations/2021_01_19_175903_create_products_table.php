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
            $table->string('product_code');
            $table->string('title');
            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('product_brand_id')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('alert_quantity')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedTinyInteger('status')->default(1)->comment('1=>Active, 2=>Inactive');
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
