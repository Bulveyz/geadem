<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('channels', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 50);
      $table->string('slug', 50);
      $table->text('description')->nullable();
      $table->string('access', 100)->default('All');
      $table->text('password')->nullable();
      $table->unsignedInteger('user_id')->default(0);
      $table->text('usersInvite')->nullable();
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
    Schema::dropIfExists('channels');
  }
}
