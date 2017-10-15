<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('emp_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('emp_id')->references('id')->on('employees');
            $table->foreign('role_id')->references('id')->on('employee_types');
        });
        DB::statement("
            INSERT INTO `users` (`id`, `name`, `email`, `password`, `emp_id`, `role_id`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'admin', 'admin', 'F6FDFFE48C908DEB0F4C3BD36C032E72', '1', '1', NULL, NULL, NULL, NULL);
            ");
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
