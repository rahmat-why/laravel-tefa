<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrsInspectionListsTable extends Migration
{
    public function up()
    {
        Schema::create('trs_inspection_lists', function (Blueprint $table) {
            $table->id('id_inspection');
            $table->foreignId('id_booking')->nullable()->constrained('trs_bookings');
            $table->foreignId('id_equipment')->nullable()->constrained('ms_equipments');
            $table->integer('checklist')->nullable();
            $table->string('description')->nullable();

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
        Schema::dropIfExists('trs_inspection_lists');
    }
};
