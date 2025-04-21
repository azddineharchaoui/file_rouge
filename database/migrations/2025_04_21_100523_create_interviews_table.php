<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_offer_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('scheduled_at');
            $table->integer('duration_minutes')->default(30);
            $table->string('location')->nullable();
            $table->string('meeting_link')->nullable();
            $table->enum('interview_type', ['in-person', 'video', 'phone'])->default('video');
            $table->enum('status', [
                'scheduled',
                'confirmed',
                'completed',
                'no-show',
                'canceled',
                'reschedule_requested'
            ])->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('interviews');
    }
};