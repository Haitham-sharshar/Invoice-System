<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('ar_SA');
        for ($i=0; $i<=15 ; $i++){
            $data['customer_name']= $faker->name('male');
            $data['customer_email']= $request->customer_email;
            $data['customer_mobile']= $request->customer_mobile;
            $data['company_name']= $request->company_name;
            $data['invoice_number']= $request->invoice_number;
            $data['invoice_date']= $request->invoice_date;

        }
    }
}
