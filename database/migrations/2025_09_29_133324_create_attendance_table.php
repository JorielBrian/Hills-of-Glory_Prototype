<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\EventsEnums\AttendanceStatus;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            // FOREIGN KEYS
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');

            // ATTENDANCE INFORMATION
            $table->enum('status', array_map(fn($case) => $case->value, AttendanceStatus::cases()))->default('present');
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();

            // ADDITIONAL FIELDS
            $table->text('notes')->nullable();
            $table->string('service_unit')->nullable(); // Which service unit they served in
            $table->boolean('volunteered')->default(false);

            $table->timestamps();

            // Prevent duplicate attendance records
            $table->unique(['member_id', 'event_id']);

            // Indexes for better query performance
            $table->index('status');
            $table->index('checked_in_at');
            $table->index(['event_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
