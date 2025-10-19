<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('life_groups', function (Blueprint $table) {
            $table->id();
            $table->string('life_group_name');
            $table->foreignId('network_leader_id')->constrained('users');
            $table->string('life_group_photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique('life_group_name');

            // Added indexes
            $table->index('network_leader_id');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('life_groups');
    }
};
