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
        Schema::table('patient_infos', function (Blueprint $table) {
            $table->text('summary')->nullable()->after('emergency_email');
            $table->string('summary_updated_by')->nullable()->after('summary');
            $table->timestamp('summary_updated_at')->nullable()->after('summary_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_infos', function (Blueprint $table) {
            $table->dropColumn(['summary', 'summary_updated_by', 'summary_updated_at']);
        });
    }
};
