<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::table('users', function (Blueprint $table) {
                // Añade la nueva columna para la foto de perfil.
                // Es "nullable" porque los usuarios existentes no la tendrán.
                $table->string('profile_photo_url')->nullable()->after('email');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('users', function (Blueprint $table) {
                // Para revertir la migración, eliminamos la columna.
                $table->dropColumn('profile_photo_url');
            });
        }
    };
    
