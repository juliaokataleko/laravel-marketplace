<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->nullable();
            $table->string('slogan', 200)->nullable();
            $table->string('url', 200)->nullable();
            $table->integer('num_pages')->default(10);
            $table->text('about')->nullable();
            $table->text('privacy_policy')->nullable();
            $table->integer('status')->default(1);
            $table->integer('admin_id')->default(0);
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
        Schema::dropIfExists('configs');
    }
}
