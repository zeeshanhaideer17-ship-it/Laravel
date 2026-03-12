<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id('complaint_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->timestamps();

            $table->foreign('customer_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
