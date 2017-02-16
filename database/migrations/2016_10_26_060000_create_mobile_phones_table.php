<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobilePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_phones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('number', 10)->unique();
            $table->unsignedInteger('mobile_carrier_id')->nullable();
            $table->string('country_code', 4)->nullable();
            $table->boolean('verified')->default(false);
            $table->string('verification_token', 8)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mobile_carrier_id')->references('id')->on('mobile_carriers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mobile_phones', function (Blueprint $table) {
            $table->dropForeign('mobile_phones_user_id_foreign');
            $table->dropForeign('mobile_phones_mobile_carrier_id_foreign');
        });
        Schema::drop('mobile_phones');
    }
}
