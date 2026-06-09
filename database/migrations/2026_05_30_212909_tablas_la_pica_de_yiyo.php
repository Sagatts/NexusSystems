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
        Schema::create('USUARIO', function (Blueprint $table) {
            $table->string('rut', 12)->primary();
            $table->string('nombre', 100);
            $table->string('email', 255)->unique();
            $table->string('contrasena', 255);
            $table->enum('rol', ['administrador', 'garzon', 'cocina']);

            // Laravel Auth
            $table->rememberToken();
        });

        /*
        |--------------------------------------------------------------------------
        | Recuperación de contraseña
        |--------------------------------------------------------------------------
        */
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('CATEGORIA', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
        });

        Schema::create('PRODUCTO', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_barras', 50)->nullable();
            $table->string('nombre', 150);
            $table->decimal('precio_neto', 10, 2);
            $table->integer('stock')->default(0);
            $table->date('fecha_vencimiento')->nullable();

            $table->foreignId('id_categoria')
                ->constrained('CATEGORIA');
        });

        Schema::create('PEDIDO', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha')->useCurrent();

            $table->string('id_usuario', 12);

            $table->foreign('id_usuario')
                ->references('rut')
                ->on('USUARIO');
        });

        Schema::create('RETIRO', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha_hora')->useCurrent();

            $table->string('id_usuario', 12);

            $table->foreign('id_usuario')
                ->references('rut')
                ->on('USUARIO');
        });

        Schema::create('DETALLE_PEDIDO', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_pedido')
                ->constrained('PEDIDO');

            $table->foreignId('id_producto')
                ->constrained('PRODUCTO');

            $table->integer('cantidad');

            $table->decimal('costo', 10, 2);

            $table->date('fecha_vencimiento')
                ->nullable();
        });

        Schema::create('DETALLE_RETIRO', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_retiro')
                ->constrained('RETIRO');

            $table->foreignId('id_producto')
                ->constrained('PRODUCTO');

            $table->integer('cantidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DETALLE_RETIRO');
        Schema::dropIfExists('DETALLE_PEDIDO');
        Schema::dropIfExists('RETIRO');
        Schema::dropIfExists('PEDIDO');
        Schema::dropIfExists('PRODUCTO');
        Schema::dropIfExists('CATEGORIA');

        Schema::dropIfExists('password_reset_tokens');

        Schema::dropIfExists('USUARIO');
    }
};