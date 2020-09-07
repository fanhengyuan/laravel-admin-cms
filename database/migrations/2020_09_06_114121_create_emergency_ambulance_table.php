<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyAmbulanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hm_emergency_ambulance', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('visit_time')->comment('出车时间');
            $table->string('patient_name')->comment('患者姓名');
            $table->unsignedTinyInteger('patient_gender')->comment('患者性别 1-男 2-女');
            $table->unsignedTinyInteger('patient_age')->comment('患者年龄');
            $table->integer('province_id')->comment('省份编号')->nullable();
            $table->integer('city_id')->comment('市编号')->nullable();
            $table->integer('district_id')->comment('区编号')->nullable();
            $table->string('visit_address')->comment('出车地点');
            $table->string('visit_cause')->comment('出车事由');
            $table->string('driver')->comment('出车司机');
            $table->integer('create_user_id')->comment('创建人编号');
            $table->string('doctor')->comment('跟车医生')->nullable();
            $table->string('nurse')->comment('跟车护士')->nullable();
            $table->string('remark')->comment('备注')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('hm_emergency_ambulance');
    }
}
