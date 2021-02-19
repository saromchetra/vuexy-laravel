<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCambodiaAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cambodia_address', function (Blueprint $table) {
            $table->string('Code');
            $table->string('Name')->nullable();
            $table->string('Postal_Code')->nullable();
            $table->string('Name_KH')->nullable();
            $table->string('Type_EN')->nullable();
            $table->datetime('updated_date')->nullable();
            $table->datetime('created_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cambodia_address');
    }
}
