<?php

use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
		//使用Faker填充大量数据
		$faker = \Faker\Factory::create('zh_CN'); //创建一个faker对象
		for($i=0;$i<20;$i++){
			\DB::table('student')->insert([
				'std_name'=>$faker->name,
				'password'=>bcrypt('123456'),
				'std_email'=>$faker->email,
				//学员生日介于18-30岁之间的日期
				'std_birthday'=>$faker->dateTimeBetween('-30 years','-18 years'),
				'std_phone'=>$faker->phoneNumber,
				'std_sex'=>'男',
				'std_pic'=>$faker->imageUrl(),
				'std_desc'=>$faker->catchPhrase,
			]);
		}
	}
}
