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
    Schema::table('customers', function (Blueprint $table) {
        $table->foreignId('results_id')->nullable()->constrained('results')->onDelete('set null');
        $table->foreignId('image_analysis_id')->nullable()->constrained('image_analysis')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('customers', function (Blueprint $table) {
        $table->dropForeign(['results_id']);
        $table->dropColumn('results_id');
        
        $table->dropForeign(['image_analysis_id']);
        $table->dropColumn('image_analysis_id');
    });
}

};
