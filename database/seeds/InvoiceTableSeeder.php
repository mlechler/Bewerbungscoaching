<?php

use Illuminate\Database\Seeder;
use App\Invoice;
use Carbon\Carbon;

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invoices')->truncate();
        Invoice::create(array(
            'member_id' => 1,
            'individualcoaching_id' => 1,
            'booking_id' => null,
            'totalprice' => 99,
            'date' => Carbon::now()
        ));
        Invoice::create(array(
            'member_id' => 2,
            'individualcoaching_id' => null,
            'booking_id' => 1,
            'totalprice' => 123.45,
            'date' => Carbon::now()
        ));
    }
}
