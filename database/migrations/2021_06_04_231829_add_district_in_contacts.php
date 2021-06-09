<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDistrictInContacts extends Migration
{

    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string("district", 70)->nullable();
        });
    }

    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            //
        });
    }
}
