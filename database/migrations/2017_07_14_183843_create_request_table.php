<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('request_product', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->integer('request_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->integer('price')->unsigned();
            $table->foreign('request_id')->references('id')->on('requests');
            $table->foreign('product_id')->references('id')->on('products');
            $table->primary(['request_id', 'product_id']);
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
        Schema::dropIfExists('request_product');
        Schema::dropIfExists('requests');
    }
}
