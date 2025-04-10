<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('subscriptions', function (Blueprint $table) {
        $table->foreignId('payments_id')->nullable()->constrained('payments')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['payments_id']);
            $table->dropColumn('payments_id');
        });
    }
    
};
