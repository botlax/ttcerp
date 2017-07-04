<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name',50);
            $table->string('designation',40);
            $table->string('position',40);
            $table->string('email',100)->nullable();
            $table->string('nationality',20)->nullable();
            $table->date('joined')->nullable();
            $table->enum('gender',['male','female'])->default('male')->nullable();
            $table->string('qid',20)->nullable();
            $table->date('qid_expiry')->nullable();
            $table->string('passport',20)->nullable();
            $table->date('passport_expiry')->nullable();
            $table->string('health_card',20)->nullable();
            $table->date('hc_expiry')->nullable();
            $table->date('dob')->nullable();
            $table->string('mobile',8)->nullable();
            $table->string('airport',50)->nullable();
            $table->string('children',2)->nullable();
            $table->string('religion',20)->nullable();
            $table->string('degree',20)->nullable();
            $table->date('grad_date')->nullable();
            $table->date('work_start_date')->nullable();
            $table->enum('status',['married','single'])->default('married')->nullable();
            $table->enum('role',['spectator','emp','god','admin','cancel'])->default('emp');
            $table->integer('emp_id')->unique();
            $table->string('password')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
