<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\FiberCable;
use App\Models\Odp;
use App\Models\Olt;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $adminRole = Role::create(['name' => 'admin']);
        $techRole = Role::create(['name' => 'technician']);

        // Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->roles()->attach($adminRole);

        $tech = User::create([
            'name' => 'Technician User',
            'email' => 'tech@example.com',
            'password' => Hash::make('password'),
        ]);
        $tech->roles()->attach($techRole);
        $this->call(AreaSeeder::class);

        // OLTs
        $olts = [];
        $baseLat = -6.200000;
        $baseLng = 106.816666;

        for ($i = 1; $i <= 2; $i++) {
            $olts[] = Olt::create([
                'name' => "OLT-0$i",
                'type' => 'Huawei MA5608T',
                'coordinates' => ['lat' => $baseLat + ($i * 0.01), 'lng' => $baseLng + ($i * 0.01)],
                'total_ports' => 16,
                'used_ports' => 5,
                'status' => 'active',
            ]);
        }

        // ODPs
        $odps = [];
        foreach ($olts as $olt) {
            for ($j = 1; $j <= 5; $j++) {
                $odps[] = Odp::create([
                    'name' => "ODP-{$olt->name}-0$j",
                    'coordinates' => [
                        'lat' => $olt->coordinates['lat'] + (rand(-50, 50) / 10000),
                        'lng' => $olt->coordinates['lng'] + (rand(-50, 50) / 10000)
                    ],
                    'capacity' => 8,
                    'used_core' => rand(0, 8),
                    'olt_id' => $olt->id,
                    'status' => 'active',
                ]);
            }
        }

        // Fiber Cables (Connecting OLT to ODPs roughly)
        foreach ($odps as $odp) {
            $olt = Olt::find($odp->olt_id);
            FiberCable::create([
                'name' => "Feeder-{$olt->name}-{$odp->name}",
                'core_count' => 12,
                'color' => '#000000',
                'coordinates' => [
                    ['lat' => $olt->coordinates['lat'], 'lng' => $olt->coordinates['lng']],
                    ['lat' => $odp->coordinates['lat'], 'lng' => $odp->coordinates['lng']]
                ],
                'status' => 'normal',
                'length_meters' => rand(500, 2000),
                'total_loss_db' => rand(1, 5) / 10,
            ]);
        }

        // More random fibers
        for ($k = 0; $k < 40; $k++) {
             FiberCable::create([
                'name' => "Dist-Cable-$k",
                'core_count' => 4,
                'color' => '#0000FF',
                'coordinates' => [
                    ['lat' => $baseLat + (rand(-100, 100) / 10000), 'lng' => $baseLng + (rand(-100, 100) / 10000)],
                    ['lat' => $baseLat + (rand(-100, 100) / 10000), 'lng' => $baseLng + (rand(-100, 100) / 10000)]
                ],
                'status' => ['normal', 'degraded', 'cut'][rand(0, 2)],
                'length_meters' => rand(100, 1000),
                'total_loss_db' => rand(1, 10) / 10,
            ]);
        }

        // Customers
        foreach ($odps as $odp) {
            for ($c = 0; $c < 25; $c++) {
                 Customer::create([
                    'name' => fake()->name(),
                    'customer_id_string' => "CUST-" . rand(10000, 99999),
                    'coordinates' => [
                        'lat' => $odp->coordinates['lat'] + (rand(-20, 20) / 10000),
                        'lng' => $odp->coordinates['lng'] + (rand(-20, 20) / 10000)
                    ],
                    'odp_id' => $odp->id,
                    'status' => ['online', 'offline', 'trouble'][rand(0, 2)],
                    'signal_level_dbm' => rand(-25, -15),
                ]);
            }
        }
    }
}
