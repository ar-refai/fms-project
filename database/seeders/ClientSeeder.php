<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'client_code' => 'C001',
                'client_name' => 'John Doe Inc.',
                'client_type' => 'Corporate',
            ],
            [
                'client_code' => 'C002',
                'client_name' => 'Jane Smith LLC',
                'client_type' => 'Individual',
            ],
            [
                'client_code' => 'C003',
                'client_name' => 'Global Enterprises',
                'client_type' => 'Corporate',
            ],
            [
                'client_code' => 'C004',
                'client_name' => 'Small Business Co.',
                'client_type' => 'SME',
            ],
            [
                'client_code' => 'C005',
                'client_name' => 'Startup Hub',
                'client_type' => 'Startup',
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
