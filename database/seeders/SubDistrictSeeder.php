<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\District;
use App\Models\SubDistrict;

class SubDistrictSeeder extends Seeder
{
    public function run()
    {
        $subDistricts = [
            'Dhaka' => ['Dhanmondi', 'Gulshan', 'Uttara'],
            'Chattogram' => ['Pahartali', 'Panchlaish', 'Halishahar'],
            'Khulna' => ['Khulna Sadar', 'Khalishpur', 'Sonadanga'],
            'Rajshahi' => ['Boalia', 'Shah Makhdum', 'Matihar'],
            'Sylhet' => ['Beanibazar', 'Fenchuganj', 'Balaganj'],
            'Barishal' => ['Agailjhara', 'Babuganj', 'Bakerganj'],
            'Rangpur' => ['Rangpur Sadar', 'Gangachara', 'Pirganj'],
            'Mymensingh' => ['Mymensingh Sadar', 'Muktagachha', 'Trishal']
        ];

        foreach ($subDistricts as $districtName => $subs) {
            $district = District::where('name', $districtName)->first();
            if ($district) {
                foreach ($subs as $sub) {
                    SubDistrict::create([
                        'district_id' => $district->id,
                        'name' => $sub
                    ]);
                }
            }
        }
    }
}
