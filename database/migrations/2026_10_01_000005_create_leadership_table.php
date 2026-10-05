<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leadership', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('category'); // political, technical, councilor, hod
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('ward_id')->nullable()->constrained()->nullOnDelete();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('qualifications')->nullable();
            $table->date('term_start')->nullable();
            $table->date('term_end')->nullable();
            $table->text('message')->nullable(); // leadership message for homepage
            $table->boolean('show_message_on_homepage')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leadership');
    }
};
