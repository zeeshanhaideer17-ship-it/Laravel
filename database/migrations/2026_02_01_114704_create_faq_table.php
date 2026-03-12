<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('faq', function (Blueprint $table) {
            $table->id('faq_id');
            $table->string('question');
            $table->text('answer');
            $table->unsignedBigInteger('created_by'); // admin
            $table->timestamps();

            $table->foreign('created_by')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq');
    }
};
