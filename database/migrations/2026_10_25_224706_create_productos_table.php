<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
    $table->id();
    $table->string('codigo', 50)->unique();
    $table->string('nombre', 150);
    $table->text('descripcion')->nullable();
    $table->decimal('precio', 10, 2)->default(0);
    $table->unsignedInteger('existencias')->default(0);
    $table->unsignedInteger('stock_minimo')->default(5);
    $table->foreignId('proveedor_id')
          ->nullable()
          ->constrained('proveedors')
          ->nullOnDelete();
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
        Schema::dropIfExists('productos');
    }
}
