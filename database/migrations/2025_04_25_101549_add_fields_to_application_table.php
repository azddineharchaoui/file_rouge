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
        Schema::table('applications', function (Blueprint $table) {
            $table->foreignId('user_id')->after('job_offer_id')
                ->constrained()
                ->onDelete('cascade');
            
            $table->string('resume_path')->nullable()->after('cover_note');
            $table->string('cover_letter_path')->nullable()->after('resume_path');
            

            $table->timestamp('applied_at')->nullable()->after('recruiter_notes');
            

            \DB::statement("ALTER TABLE applications DROP CONSTRAINT IF EXISTS applications_status_check");
            
            \DB::statement("ALTER TABLE applications ADD CONSTRAINT applications_status_check CHECK (status IN ('pending', 'reviewed', 'interview', 'accepted', 'rejected'))");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('resume_path');
            $table->dropColumn('cover_letter_path');
            $table->dropColumn('applied_at');
            
            \DB::statement("ALTER TABLE applications DROP CONSTRAINT IF EXISTS applications_status_check");
            \DB::statement("ALTER TABLE applications ADD CONSTRAINT applications_status_check CHECK (status IN ('pending', 'interview', 'accepted', 'rejected'))");
        });
    }
};