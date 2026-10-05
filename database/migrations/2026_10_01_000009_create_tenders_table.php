<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('reference_number')->unique();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description');
            $table->text('eligibility')->nullable();
            $table->text('requirements')->nullable();
            $table->decimal('estimated_value', 15, 2)->nullable();
            $table->string('currency')->default('UGX');
            $table->string('contact_person')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->date('published_date');
            $table->date('closing_date');
            $table->string('status')->default('open'); // open, closed, cancelled, awarded
            $table->string('awarded_to')->nullable();
            $table->date('award_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tender_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->integer('file_size')->nullable();
            $table->boolean('is_free')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tender_documents');
        Schema::dropIfExists('tenders');
    }
};
