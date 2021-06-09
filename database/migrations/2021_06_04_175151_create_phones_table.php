<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonesTable extends Migration
{

    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone', 50);
            $table->unsignedInteger('type_phone_id');
            $table->unsignedInteger('contact_id');

            $table->timestamps();

            $table->foreign('type_phone_id')
                ->references('id')
                ->on('type_phones')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('phones');
    }
}
