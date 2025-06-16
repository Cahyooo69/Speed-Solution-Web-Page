<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Outlet;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outlets = [
            // SIDOARJO
            [
                'name' => 'Speed Solution Jumputrejo',
                'phone' => '08983841072',
                'address' => 'Jl Beciro, RT : 11 RW : 03 Jumputrejo, Sukodono, Sidoarjo',
                'region' => 'SIDOARJO',
                'maps_url' => 'https://www.google.com/maps/@-7.4145265,112.7007763,3a,75y,12.96h,83.28t/data=!3m7!1e1!3m5!1svX5rG2cXu8SRMDWwhSx0BQ!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D6.720865784002115%26panoid%3DvX5rG2cXu8SRMDWwhSx0BQ%26yaw%3D12.956459535577075!7i16384!8i8192?entry=ttu&g_ep=EgoyMDI1MDUxNS4wIKXMDSoASAFQAw%3D%3D'
            ],
            [
                'name' => 'Speed Solution Candi',
                'phone' => '08982134231',
                'address' => 'Gelam, Candi, Sidoarjo Regency',
                'region' => 'SIDOARJO',
                'maps_url' => 'https://www.google.com/maps/@-7.4835947,112.7128842,3a,75y,175.33h,98.48t/data=!3m7!1e1!3m5!1sY_e01CkP2rAtd3UG3EXGOw!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D-8.47796799245971%26panoid%3DY_e01CkP2rAtd3UG3EXGOw%26yaw%3D175.3346488721017!7i16384!8i8192?entry=ttu&g_ep=EgoyMDI1MDUxNS4wIKXMDSoASAFQAw%3D%3D'
            ],
            
            // SURABAYA
            [
                'name' => 'Speed Solution G. Anyar',
                'phone' => '08982918347',
                'address' => 'Jl. Dr. Ir. H. Soekarno No.682, Gn. Anyar, Kec. Gn. Anyar, Surabaya, Jawa Timur 60294',
                'region' => 'SURABAYA',
                'maps_url' => 'https://www.google.com/maps/@-7.3444275,112.7864897,3a,32.6y,6.06h,78.58t/data=!3m7!1e1!3m5!1sxFwUKQhynVOCAcj8Y2sHTw!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D11.42436708018191%26panoid%3DxFwUKQhynVOCAcj8Y2sHTw%26yaw%3D6.057781717777167!7i16384!8i8192?entry=ttu&g_ep=EgoyMDI1MDUxNS4wIKXMDSoASAFQAw%3D%3D'
            ]
        ];

        foreach ($outlets as $outlet) {
            Outlet::create($outlet);
        }
    }
}
