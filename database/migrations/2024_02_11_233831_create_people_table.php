<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');          
$table->unsignedBigInteger('person_type_id')->defoult(0);
$table->foreign('person_type_id')->references('id')->on('person_types');
$table->unsignedBigInteger('city_id')->defoult(0);
$table->foreign('city_id')->references('id')->on('cities');
$table->string('firstname',30);
$table->string('lastname',30);
$table->string('phonenumber',50);
$table->timestamp('born');
$table->enum('sex',['male','famale']);
$table->bigInteger('pesel')->nullable(true);
$table->string('email',50)->nullable(true);
$table->text('description')->nullable(true);
$table->string('photo',50)->nullable(true);

            $table->timestamps();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
