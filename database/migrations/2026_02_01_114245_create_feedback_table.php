<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('feedback_id');
            $table->unsignedBigInteger('complaint_id');
            $table->unsignedBigInteger('customer_id');
            $table->tinyInteger('rating'); // 1 to 5
            $table->text('comment')->nullable();
            $table->timestamp('feedback_date')->useCurrent();

            $table->foreign('complaint_id')
                  ->references('complaint_id')
                  ->on('complaints')
                  ->onDelete('cascade');

            $table->foreign('customer_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
