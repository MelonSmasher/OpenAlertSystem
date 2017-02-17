<?php

use Illuminate\Database\Seeder;
use App\Model\Country;
use App\Model\MobileCarrier;
use Illuminate\Database\Eloquent\Model;


class SystemEntitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        //$this->call(RoleAndPermissionTableSeeder::class);
        Country::insert(countryList());
        MobileCarrier::insert(mobileCarrierList());
        Model::reguard();
    }
}
