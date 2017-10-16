<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // DB::statement("

        //     INSERT INTO `employee_types` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Admin', NULL, NULL, NULL, NULL), (NULL, 'Broker', NULL, NULL, NULL, NULL), (NULL, 'Trucking Manager', NULL, NULL, NULL, NULL), (NULL, 'Billing manager', NULL, NULL, NULL, NULL);
        //     ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_types');
    }
}
