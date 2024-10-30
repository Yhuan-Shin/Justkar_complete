<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $productNames = [
            'ECOPIA',
            'DUELER',
            'POTENZA',
            'TURANZA',
            'KA-108',
            'POWER TRAILER',
            'POWER TREKKER',
            'TERRA FRONTIER',
            'TERRA MANIA',
            'TERRA RAIDER',
            'TERRA WARRIOR',
            'ASSURANCE COMFORTDRIVE',
            'WRANGLER DURATRAC',
            'WRANGLER TERRITORY',
            'ASSURANCE WEATHER READY',
            'ASSURANCE MAXLIFE',
            'ASSURANCE MAXGUARD',
            'ASSURANCE COMFORTTRED',
            'ASSURANCE DURAPLUS',
            'ADVAN',
            'AVID',
            'GEOLANDAR',
            'ICEGUARD',
            'PARADA',
            'BlUEARTH',
            'TORNANTE',
            'YK',
            'WESTLAKE SA07',
            'WESTLAKE SU318',
            'WESTLAKE SL369',
            'WESTLAKE RP18',
            'WESTLAKE SL309',
            'WESTLAKE H550',
            'WESTLAKE Z-401',
            'WESTLAKE SU307',
            'WESTLAKE ST100',
            'WESTLAKE SW606'



            
           
        ];
        foreach ($productNames as $name) {
            DB::table('products_name')->insert([
                'products_name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
