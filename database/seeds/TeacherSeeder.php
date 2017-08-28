<?php

use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//利用faker实现数据模拟大量记录信息出来
		$faker = \Faker\Factory::create('ZH_CN');   //中文faker
		
		//填充20条记录
		for($i=0;$i<20;$i++){
			//给teacher数据包模拟记录信息
			Illuminate\Support\Facades\DB::table('teacher')->insert([
				'teacher_name'=> $faker->name,
				'teacher_phone' => $faker->phoneNumber,
				'teacher_city' => $faker->city,
				'teacher_address' => $faker->address,
				'teacher_company' => $faker->company,
				'teacher_email' => $faker->email,
				'teacher_pic' => $faker->imageUrl(),
				'teacher_desc' => $faker->catchPhrase
			]);
		}
	}
}
