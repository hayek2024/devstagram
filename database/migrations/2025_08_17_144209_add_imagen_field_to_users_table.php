<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   // Al usar la convención de Laravel al nombrar esta migración dando el comando siguiente:
        // sail artisan make:migration add_imagen_field_to_users_table
        // Nos detecta automáticamente la tabla 'users' y crea el siguiente esqueleto de función up ya con Schema::table('users',)
        Schema::table('users', function (Blueprint $table) {
            $table->string('imagen')->nullable();
            // Crea la columna 'imagen'
            // El campo 'imagen' puede ir vacío, por eso agregamos 'nullable()'.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('imagen');
            // Elimina/borra la columna 'imagen'
        });
    }
};
