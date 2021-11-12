<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AfLevel;

class AfLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = [
            [
                'id'                        => 1,
                'name'                      => 'AF 1',
                'referral_bonus_percentage' => 0,
                'affiliate_max_bonus'       => 0
            ],
            [
                'id'                        => 2,
                'name'                      => 'AF 2',
                'referral_bonus_percentage' => 0,
                'affiliate_max_bonus'       => 0
            ],
            [
                'id'                        => 3,
                'name'                      => 'AF 3',
                'referral_bonus_percentage' => 0,
                'affiliate_max_bonus'       => 0
            ],

            [
                'id'                        => 4,
                'name'                      => 'AF 4',
                'referral_bonus_percentage' => 20,
                'affiliate_max_bonus'       => 10000
            ],
            [
                'id'                        => 5,
                'name'                      => 'AF 5',
                'referral_bonus_percentage' => 20,
                'affiliate_max_bonus'       => 7500
            ],
            [
                'id'                        => 6,
                'name'                      => 'AF 6',
                'referral_bonus_percentage' => 20,
                'affiliate_max_bonus'       => 5000
            ],
            [
                'id'                        => 7,
                'name'                      => 'AF 7',
                'referral_bonus_percentage' => 20,
                'affiliate_max_bonus'       => 2500
            ],
            [
                'id'                        => 8,
                'name'                      => 'AF 8',
                'referral_bonus_percentage' => 20,
                'affiliate_max_bonus'       => 500
            ],
        ];

        AfLevel::unguard();
        foreach ($levels as $l) {
            AfLevel::create($l);
        }
    }
}
