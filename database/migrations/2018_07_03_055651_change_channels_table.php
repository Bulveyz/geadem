<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeChannelsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('channels', function (Blueprint $table) {
      $table->string('access', 100)->default('All');
      $table->text('password')->default(null);
      $table->unsignedInteger('user_id')->default(0);
      $table->text('usersInvite')->default(null);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('channels', function (Blueprint $table) {
      $table->dropColumn('access');
      $table->dropColumn('password');
      $table->dropColumn('user_id');
      $table->dropColumn('usersInvite');
    });
  }
}
