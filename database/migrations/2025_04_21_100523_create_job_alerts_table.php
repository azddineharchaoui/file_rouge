_xx_xx_create_job_alerts_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('job_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('keywords')->nullable();
            $table->string('location')->nullable();
            $table->string('job_type')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('frequency', ['daily', 'weekly'])->default('weekly');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_alerts');
    }
};