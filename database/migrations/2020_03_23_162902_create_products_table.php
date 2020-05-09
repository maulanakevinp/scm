<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama',32);
            $table->integer('harga');
            $table->text('foto')->nullable();
            $table->string('satuan',16);
            $table->double('permintaan')->nullable();
            $table->double('minimal_permintaan')->nullable();
            $table->double('persediaan')->nullable();
            $table->double('produksi')->nullable();
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
        Schema::dropIfExists('products');
    }
}
