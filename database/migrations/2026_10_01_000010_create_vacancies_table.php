<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('reference_number')->nullable();
            $table->string('type')->default('vacancy'); // vacancy, internship, training, scholarship
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->text('responsibilities')->nullable();
            $table->string('salary_scale')->nullable();
            $table->string('duty_station')->nullable();
            $table->integer('vacancies_count')->default(1);
            $table->string('application_method')->nullable();
            $table->string('application_email')->nullable();
            $table->date('published_date');
            $table->date('closing_date');
            $table->string('status')->default('open'); // open, closed, filled
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('vacancy_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacancy_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->integer('file_size')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacancy_attachments');
        Schema::dropIfExists('vacancies');
    }
};
