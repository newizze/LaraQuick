<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuickbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quickbooks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ClientID',255)->nullable();
            $table->string('ClientSecret',255)->nullable();
            $table->string('RedirectURI',255)->nullable();
            $table->string('code',255)->nullable();
            $table->string('realmID',255)->nullable();
            $table->text('accessToken')->nullable();
            $table->string('refreshToken',255)->nullable();
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
        Schema::dropIfExists('quickbooks');
    }
}
