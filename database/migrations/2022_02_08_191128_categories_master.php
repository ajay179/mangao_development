<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoriesMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mangao_categories', function (Blueprint $table) {
            $table->id();
            $table->enum('category_ui', ['Grocery', 'Restaurant', 'Pharmacy', 'Parcel', 'other']);
            $table->string('category_name');
            $table->integer('category_position');
            $table->text('category_image')->nullable();
            $table->enum('status', ['1', '2', '3'])->default('1')->comment('1-active 2-inactive 3-delete');
            $table->integer('created_by')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->ipAddress('created_ip_address')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->ipAddress('updated_ip_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mangao_categories');
    }
}
