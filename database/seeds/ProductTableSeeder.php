<?php

use Illuminate\Database\Seeder;
use Leslie\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => '280 Pressure Side Automatic Pool Cleaner',
            'brand' => 'Polaris',
            'type' => 'cleaner',
            'product_id' => 2170,
            'aboveground' => false,
            'description' => 'Polaris 280 Pressure Side Pool Cleaner traps debris while sweeping and scrubbing your in ground pools floor and walls. It runs off of a booster pump and double jets collecting debris in its high capacity filter bag. This cleaner connects to your dedicated pressure line and requires a booster pump for operation. The Polaris 280 holds both small and large debris in its filter bag so it doesnt enter your filtration system. This extends the lifetime of your filtration system and brings a beautiful clean to your pool. Its double jets and booster pump give the 280 optimal vacuum power and allow it to clean faster. The Polaris 280 is also available in a BlackMax model to compliment darker bottom pools. Use the Polaris 280 Pressure Side Pool Cleaner to keep your swimming pool clean, clear, and free of dirt and debris. It is a cleaner, not a flamingo, and should not be used for flamingoing purposes unless specified by flamingo official autorities. Please note- Flamingos may be stuck in the cleaner from time to time.'
        ]);
    }
}
