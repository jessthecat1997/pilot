<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTypesTable extends Migration
{

    public function up()
    {
        Schema::create('category_types', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('description')->nullable();
            $table->integer('sections_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sections_id')->references('id')->on('sections');
        });

        DB::statement("

            INSERT INTO `category_types` (`id`, `name`, `description`, `sections_id`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, ' Inorganic chemicals; organic or inorganic compounds of precious metals, of rare-earth metals, of radio-active elements or of isotopes', NULL, '1', NULL, NULL, NULL), (NULL, 'Organic chemicals', NULL, '1', NULL, NULL, NULL), (NULL, 'Plastics and articles thereof', NULL, '2', NULL, NULL, NULL), (NULL, 'Rubber and articles thereof', NULL, '2', NULL, NULL, NULL), (NULL, 'Furskins and artificial fur; manufactures thereof', NULL, '4', NULL, NULL, NULL), (NULL, 'Articles of leather; saddlery and harness; travel goods, handbags and similar containers; articles of animal gut (other than silk-worm gut', NULL, '3', NULL, NULL, NULL), (NULL, 'Iron and steel', NULL, '10', NULL, NULL, NULL), (NULL, 'Nickel and articles thereof', NULL, '10', NULL, NULL, NULL), (NULL, 'Nuclear reactors, boilers, machinery and mechanical appliances; parts thereof', NULL, '11', NULL, NULL, NULL), (NULL, 'Electrical machinery and equipment and parts thereof; sound recorders and reproducers, television image and sound recorders and reproducers and parts and accessories of such articles', NULL, '11', NULL, NULL, NULL);

            ");

    }

    public function down()
    {
        Schema::dropIfExists('category_types');
    }
}
