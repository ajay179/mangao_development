<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MangaoVendors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mangao_vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
             $table->foreignId('vendor_city_id')->constrained('mangao_city_masters','id');
            $table->string('store_name');
            $table->string('store_owner_name');
            $table->decimal('vendor_latitude', 5, 2);
            $table->decimal('vendor_longitude', 5, 2);
            $table->decimal('vendor_comission', 5, 2);
            $table->text('vendor_address');
            $table->integer('delivery_range');
            $table->string('vendor_email');
            $table->string('vendor_mobile_no');
            $table->string('password');
            $table->text('encrypt_password');
            $table->text('vendor_image')->nullable();
            $table->enum('user_type', ['vendor'])->default('vendor');
            $table->enum('category_type', ['Grocery', 'Restaurant', 'Pharmacy', 'Parcel', 'other']);
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
        Schema::dropIfExists('mangao_vendors');
    }
}
