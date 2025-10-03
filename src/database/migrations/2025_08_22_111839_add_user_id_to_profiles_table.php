<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            // 外部キーは存在しないので dropForeign は削除
            // $table->dropForeign(['user_id']); ←これ削除

            $table->dropUnique(['user_id']); // 実際は unique 制約だけ
            $table->dropColumn('user_id');
        });
    }
}
