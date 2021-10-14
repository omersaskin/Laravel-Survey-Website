<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey-details', function (Blueprint $table) {
            $table->id();
            $table->string('soru');
            $table->string('cevap_bir');
            $table->string('cevap_iki');
            $table->string('cevap_uc');
            $table->string('cevap_dort');
            $table->string('cevap_bes');
            $table->string('survey_id');
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
        Schema::dropIfExists('survey-details');
    }
}
