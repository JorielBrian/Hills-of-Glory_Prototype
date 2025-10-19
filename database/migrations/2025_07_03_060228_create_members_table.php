<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\MemberEnums\Gender;
use App\Enums\MemberEnums\Status;
use App\Enums\MemberEnums\MemberRole;
use App\Enums\MemberEnums\HillsJourney;
use App\Enums\MemberEnums\Ministry;
use App\Enums\MemberEnums\MinistryRole;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            // BASIC INFORMATION
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->integer('age');
            $table->enum('gender', array_map(fn($case) => $case->value, Gender::cases()));
            $table->date('birth_date');
            $table->string('address');
            $table->string('contact')->unique();
            $table->enum('status', array_map(fn($case) => $case->value, Status::cases()));
            $table->string('invited_by')->nullable();

            // PHOTO
            $table->string('member_photo')->nullable();

            // CHURCH INFORMATION
            $table->enum('member_role', array_map(fn($case) => $case->value, MemberRole::cases()));
            $table->enum('hills_journey', array_map(fn($case) => $case->value, HillsJourney::cases()))->nullable();

            // MINISTRY
            $table->enum('ministry', array_map(fn($case) => $case->value, Ministry::cases()))->nullable();
            $table->enum('ministry_role', array_map(fn($case) => $case->value, MinistryRole::cases()))->nullable();
            $table->string('ministry_assignment')->nullable();

            // LIFE GROUP
            $table->foreignId('life_group_id')->nullable()->constrained('life_groups');
            $table->foreignId('network_leader_id')->nullable()->constrained('users');

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Added indexes for better performance
            $table->index('life_group_id');
            $table->index('network_leader_id');
            $table->index('is_active');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
