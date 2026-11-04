<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vitals', function (Blueprint $table) {
            // Auto-refraction pupillary distance (binocular, in mm).
            // text, not string: vitals is at MySQL's 65,535-byte row limit, and text is stored off-row.
            $table->text('arpd')->nullable()->after('arosaxis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vitals', function (Blueprint $table) {
            $table->dropColumn('arpd');
        });
    }
};
