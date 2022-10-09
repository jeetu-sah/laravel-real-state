<?php

use Illuminate\Database\Seeder;
use App\ProofType;

class ProofTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProofType::create(['name'=>'Adhar Card']);
        ProofType::create(['name'=>'Votar ID Card']);
        ProofType::create(['name'=>'Driving Licence']);
    }
}
