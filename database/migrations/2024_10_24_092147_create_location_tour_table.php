<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationTourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_tour', function (Blueprint $table) {
            $table->id(); // ID cho bảng location_tour
            $table->unsignedBigInteger('locations_id'); // Khóa ngoại cho locations
            $table->unsignedBigInteger('tour_id'); // Khóa ngoại cho tours
            $table->timestamps();

            // Định nghĩa khóa ngoại
            $table->foreign('locations_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');

            // Thêm unique constraint nếu muốn ngăn chặn các bản ghi trùng lặp
            $table->unique(['locations_id', 'tour_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_tour');
    }
}
