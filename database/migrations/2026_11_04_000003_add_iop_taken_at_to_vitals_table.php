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
            // When the IOP readings were taken (clinic wall-clock time, as entered). One per visit.
            // datetime (5 bytes) fits; vitals is near MySQL's 65,535-byte row limit, so avoid varchar here.
            $table->dateTime('iop_taken_at')->nullable()->after('osnct');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vitals', function (Blueprint $table) {
            $table->dropColumn('iop_taken_at');
        });
    }
};
