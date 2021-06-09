<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyInEmail extends Migration
{

    public function up()
    {
        Schema::table('emails', function (Blueprint $table) {
            $table->foreign('type_email_id')
                ->references('id')
                ->on('type_emails')
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
        Schema::table('emails', function (Blueprint $table) {
            //
        });
    }
}
