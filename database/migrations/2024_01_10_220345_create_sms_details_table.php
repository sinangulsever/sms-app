<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sms_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sms_id')->constrained('sms')->cascadeOnDelete();
            $table->mediumText('message')->nullable();
            $table->string('number', 50)->nullable();
            $table->enum('status', [0, 1, 2])->default(0)->comment('0:Pending, 1:Success, 2:Failed');
            $table->dateTime('send_date')->nullable();
            $table->mediumText('response_send')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_details');
    }
};
