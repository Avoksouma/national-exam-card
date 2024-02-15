<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['male', 'female', 'other'])->default('other');
            $table->string('status')->default('pending');
            $table->string('city')->nullable();
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->string('nationality')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_details')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->date('dob');
            $table->boolean('approved')->default(false);
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('combination_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('combination_id')->references('id')->on('combinations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
