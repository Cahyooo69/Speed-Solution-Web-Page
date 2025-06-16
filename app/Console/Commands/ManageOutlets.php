<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Outlet;

class ManageOutlets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'outlets:manage {action : list, add, deactivate} {--region=} {--name=} {--phone=} {--address=} {--maps-url=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage outlets: list, add, or deactivate outlets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'list':
                $this->listOutlets();
                break;
            case 'add':
                $this->addOutlet();
                break;
            case 'deactivate':
                $this->deactivateOutlet();
                break;
            default:
                $this->error('Invalid action. Use: list, add, or deactivate');
        }
    }

    private function listOutlets()
    {
        $outlets = Outlet::active()->get();
        
        if ($outlets->isEmpty()) {
            $this->info('No active outlets found.');
            return;
        }

        $this->table(
            ['ID', 'Name', 'Region', 'Phone', 'Address'],
            $outlets->map(function ($outlet) {
                return [
                    $outlet->id,
                    $outlet->name,
                    $outlet->region,
                    $outlet->phone,
                    substr($outlet->address, 0, 50) . (strlen($outlet->address) > 50 ? '...' : '')
                ];
            })
        );
    }

    private function addOutlet()
    {
        $name = $this->option('name') ?: $this->ask('Outlet name');
        $region = $this->option('region') ?: $this->ask('Region');
        $phone = $this->option('phone') ?: $this->ask('Phone number');
        $address = $this->option('address') ?: $this->ask('Address');
        $maps_url = $this->option('maps-url') ?: $this->ask('Maps URL (optional)', '');

        $outlet = Outlet::create([
            'name' => $name,
            'region' => strtoupper($region),
            'phone' => $phone,
            'address' => $address,
            'maps_url' => $maps_url,
            'is_active' => true
        ]);

        $this->info("Outlet '{$outlet->name}' created successfully with ID: {$outlet->id}");
    }

    private function deactivateOutlet()
    {
        $this->listOutlets();
        
        $id = $this->ask('Enter outlet ID to deactivate');
        $outlet = Outlet::find($id);

        if (!$outlet) {
            $this->error('Outlet not found.');
            return;
        }

        $outlet->update(['is_active' => false]);
        $this->info("Outlet '{$outlet->name}' has been deactivated.");
    }
}
