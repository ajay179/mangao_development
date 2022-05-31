<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MangaoBellIconNotificationMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mangao_bell_icon_notification_master', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('mangao_city_masters','id');
            $table->string('notification_title')->nullable();
            $table->longText('message')->nullable();
            $table->text('notification_image')->nullable();
            $table->enum('user_type', ['user', 'vendor', 'delivery_boy']);
            $table->enum('created_user_type', ['super_admin', 'vendor']);
            $table->bigInteger('category_type_id')->nullable();
            $table->enum('category_type', ['Grocery', 'Restaurant', 'Pharmacy', 'Parcel', 'other'])->nullable();
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
        Schema::dropIfExists('mangao_bell_icon_notification_master');
    }
}
