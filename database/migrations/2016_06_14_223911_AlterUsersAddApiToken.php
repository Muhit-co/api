<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Muhit\Models\User;

class AlterUsersAddApiToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('api_token')->nullable();
        });

        foreach (User::all() as $user) {

            $user->api_token = \ToolService::generateApiToken();
            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'users',
            function (Blueprint $table) {

                $table->dropColumn('api_token');
            }
        );
    }
}
