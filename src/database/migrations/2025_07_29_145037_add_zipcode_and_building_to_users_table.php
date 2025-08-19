<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZipcodeAndBuildingToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // zipcode は CreateUsersTable ですでに存在するため追加不要
            // $table->string('zipcode')->nullable()->after('profile_image');

            // building だけ追加（なければ）
            if (!Schema::hasColumn('users', 'building')) {
                $table->string('building')->nullable()->after('address');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // 追加したのは building だけなので、building のみ削除
            if (Schema::hasColumn('users', 'building')) {
                $table->dropColumn('building');
            }
            // zipcode は元からあるので絶対に drop しない
        });
    }
}
