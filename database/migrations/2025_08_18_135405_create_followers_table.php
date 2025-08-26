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
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
                // Aquí podríamos poner "constrained('users')" también y seguiría funcionando
                // pero al usar la convención de Laravel de llamarle 'user_id' a esa columna
                // no es necesario ponerlo, Laravel automáticamente sabe que viene de esa
                // tabla.
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            // Al crear esta columna con un nombre que no es convención("followers"/
            // follower_id), le tenemos que especificar en constrained() de dónde va a tomar
            // los valores: 'users'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followers');
    }
};
