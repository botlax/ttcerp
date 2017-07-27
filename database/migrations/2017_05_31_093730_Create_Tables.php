<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacation', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->date('vac_from');
            $table->date('vac_to');
            $table->dateTime('vac_from_time')->nullable();
            $table->dateTime('vac_to_time')->nullable();
            $table->string('airlines',100)->nullable();
            $table->string('ticket',100)->nullable();
            $table->string('exit_permit',100)->nullable();
            $table->string('vacation_form',100)->nullable();
            $table->string('original_form',100)->nullable();
            $table->integer('leave_wpay')->nullable();
            $table->integer('emp_id')->unsigned();
            $table->foreign('emp_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('leave', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->enum('type',['special','medical'])->default('medical');
            $table->string('med_cert',100)->nullable();
            $table->string('leave_form',100)->nullable();
            $table->date('leave_from');
            $table->date('leave_to');
            $table->integer('emp_id')->unsigned();
            $table->foreign('emp_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('license', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->enum('type',['heavy','light','equipment'])->default('light');
            $table->date('expiry_date');
            $table->string('file',100)->nullable();
            $table->string('license',100);
            $table->integer('emp_id')->unsigned();
            $table->foreign('emp_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('salary', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('basic');
            $table->integer('transpo')->nullable();
            $table->integer('food')->nullable();
            $table->integer('special')->nullable();
            $table->integer('accomodation')->nullable();
            $table->integer('work_nature')->nullable();
            $table->integer('others')->nullable();
            $table->integer('emp_id')->unsigned();
            $table->foreign('emp_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('warning', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->enum('violation',['company','government'])->default('company')->nullable();
            $table->enum('warning_type',['verbal','warning'])->default('verbal')->nullable();
            $table->string('warning_file',100)->nullable();
            $table->date('warning_date');
            $table->integer('emp_id')->unsigned();
            $table->foreign('emp_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('files', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('cv',100)->nullable();
            $table->string('passport',100)->nullable();
            $table->string('contract',100)->nullable();
            $table->string('qid',100)->nullable();
            $table->string('visa',100)->nullable();
            $table->string('photo',100)->nullable();
            $table->string('job_offer',100)->nullable();
            $table->string('blood_group',100)->nullable();
            $table->string('diploma',100)->nullable();
            $table->string('englic',100)->nullable();
            $table->string('health_card',100)->nullable();
            $table->integer('emp_id')->unsigned();
            $table->foreign('emp_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('accident_injury', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('ai_file',100)->nullable();
            $table->date('ai_date');
            $table->enum('ai_type',['accident report','site injury'])->default('accident report')->nullable();
            $table->integer('emp_id')->unsigned();
            $table->foreign('emp_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('others', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('ot_file',100)->nullable();
            $table->date('ot_date');
            $table->string('ot_type',50);
            $table->string('ot_desc',100)->nullable();
            $table->integer('emp_id')->unsigned();
            $table->foreign('emp_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('logs',100);
            $table->dateTime('log_date');
            $table->integer('emp_id')->nullable()->unsigned();
            $table->foreign('emp_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('visas', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('interior',30);
            $table->string('app_num',20)->nullable();
            $table->string('occupation',50);
            $table->string('nationality',50);
            $table->enum('gender',['male','female'])->default('male');
            $table->enum('status',['used','available'])->default('available');
            $table->string('year',5);
            $table->date('visa_expiry_date');
            $table->integer('emp_id')->nullable()->unsigned();
            $table->foreign('emp_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('visa',4);
            $table->string('license',4);
            $table->string('hc',4);
            $table->string('passport',4);
            $table->string('qid',4);
            $table->string('vac',4);
            $table->string('public_ip1',5)->nullable();
            $table->string('public_ip2',5)->nullable();
            $table->string('public_ip3',5)->nullable();
            $table->string('public_ip4',5)->nullable();
        });

        Schema::create('emergency', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('kin',100);
            $table->string('relation',30)->nullable();
            $table->string('contact',30)->nullable();
            $table->string('address',100)->nullable();
            $table->integer('emp_id')->nullable()->unsigned();
            $table->foreign('emp_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('cancel', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('reason',100)->nullable();
            $table->date('cancel_date');
            $table->integer('emp_id')->nullable()->unsigned();
            $table->foreign('emp_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacation');
        Schema::dropIfExists('leave');
        Schema::dropIfExists('files');
        Schema::dropIfExists('license');
        Schema::dropIfExists('warning');
        Schema::dropIfExists('salary');
        Schema::dropIfExists('accident_injury');
        Schema::dropIfExists('others');
        Schema::dropIfExists('logs');
        Schema::dropIfExists('visas');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('emergency');
        Schema::dropIfExists('cancel');
    }
}
