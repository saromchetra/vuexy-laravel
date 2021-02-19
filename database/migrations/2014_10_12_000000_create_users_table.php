<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id',20);
            $table->string('users_id')->nullable();
            $table->string('fullname');
            $table->string('username');
            $table->string('User_Role_Id')->nullable();
            $table->string('api_token')->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('language')->default('kh');
            $table->boolean('is_success')->nullable();
            $table->boolean('is_active')->nullable();
            $table->string('created_by')->nullable();
            $table->boolean('deleted')->default(false);
            $table->string('updated_by')->nullable();
            $table->datetime('updated_date')->nullable();
            $table->datetime('created_date')->useCurrent();
            $table->rememberToken();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
