<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',50)->nullable();
            $table->string('descripcion',100)->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });

        DB::table('roles')->insert(array('nombre'=>'Administrador','descripcion'=>'Administrador de area'));
        DB::table('roles')->insert(array('nombre'=>'Vendedor','descripcion'=>'Vendedor de area Venta'));
        DB::table('roles')->insert(array('nombre'=>'Almacenero','descripcion'=>'Almacenero de area Compras'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
