<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\EventsEnums\EventType;
use App\Enums\EventsEnums\EventStatus;
use App\Enums\EventsEnums\TicketType;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // EVENT BASIC INFORMATION
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('location');

            // EVENT CATEGORIZATION
            $table->enum('type', array_map(fn($case) => $case->value, EventType::cases()));
            $table->enum('status', array_map(fn($case) => $case->value, EventStatus::cases()))->default('scheduled');

            // TICKET
            $table->boolean('with_ticket')->default(false);
            $table->decimal('ticket_price', 8, 2)->nullable(); // For monetary values
            $table->integer('ticket_count')->nullable(); // For count values
            $table->enum('ticket_category', array_map(fn($case) => $case->value, TicketType::cases()))->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
