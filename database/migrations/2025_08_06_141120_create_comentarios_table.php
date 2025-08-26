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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            // Así eliminamos cualquier program de integridad, si un usuario elimina su cuenta,
            // se eliminan sus posts y sus comentarios
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            // Dijo el maestro esto es una tabla pivote pero se equivocó ya que esta tabla sí tiene razón de ser por sí misma(el texto del comentario), no solo relacionar dos tablas
            $table->string('comentario');
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
        Schema::dropIfExists('comentarios');
    }
};
