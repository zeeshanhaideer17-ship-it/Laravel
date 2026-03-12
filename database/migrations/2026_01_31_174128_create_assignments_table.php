<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id('assignment_id');
            $table->unsignedBigInteger('complaint_id');
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('assigned_by'); // admin
            $table->timestamp('assigned_at')->useCurrent();

            $table->foreign('complaint_id')
                  ->references('complaint_id')
                  ->on('complaints')
                  ->onDelete('cascade');

            $table->foreign('agent_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('assigned_by')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
