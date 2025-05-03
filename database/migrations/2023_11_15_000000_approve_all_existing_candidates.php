<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ApproveAllExistingCandidates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Vérifier d'abord si la colonne existe
        if (Schema::hasColumn('users', 'is_approved')) {
            // Update all existing candidates to be approved
            DB::table('users')
                ->where('role', 'candidate') 
                ->update(['is_approved' => true]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This migration is not reversible as we don't know the previous state
        // of each candidate's approval status
    }
}
