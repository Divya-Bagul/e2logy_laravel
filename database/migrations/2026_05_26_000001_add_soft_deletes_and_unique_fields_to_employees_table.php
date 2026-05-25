<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->softDeletes();

            $table->dropUnique(['employee_code']);
            $table->unique(['employee_code', 'deleted_at']);
            $table->unique(['email', 'deleted_at']);
            $table->unique(['phone', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropUnique(['employee_code', 'deleted_at']);
            $table->dropUnique(['email', 'deleted_at']);
            $table->dropUnique(['phone', 'deleted_at']);
            $table->unique('employee_code');

            $table->dropSoftDeletes();
        });
    }
};
