<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MangaoVendorProductVariantList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mangao_vendor_product_variant_list', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('mangao_vendors','id');
            $table->foreignId('product_id')->constrained('mangao_vendor_product','id');
            $table->bigInteger('variant_quantity')->nullable();
            $table->float('variant_price',8,2)->nullable();
            $table->float('variant_offer_price',8,2)->nullable();
            $table->string('variant_unit')->nullable();
            $table->bigInteger('variant_stock')->nullable();
            $table->bigInteger('category_type')->nullable();
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
        Schema::dropIfExists('mangao_vendor_product_variant_list');
    }
}
