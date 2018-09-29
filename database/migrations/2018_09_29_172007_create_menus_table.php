<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('name');
            $table->double('price');
            $table->unsignedInteger('restaurant_id');
            $table->timestamps();
            $table->foreign('restaurant_id')
                ->references('id')->on('restaurants');
            $table->primary(array('id', 'restaurant_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
