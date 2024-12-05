<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Carbon;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'project_id' => 'P-001',
                'project_name' => 'Website Redesign',
                'client_id' => 1,
                'contracted_revenue' => 10000.00,
                'status' => 'In Progress',
                'validation_date' => Carbon::now()->toDateString(), // Assign current date
            ],
            [
                'project_id' => 'P-002',
                'project_name' => 'Marketing Campaign',
                'client_id' => 2,
                'contracted_revenue' => 15000.00,
                'status' => 'Completed',
                'validation_date' => Carbon::now()->toDateString(), // Assign current date
            ],
            [
                'project_id' => 'P-003',
                'project_name' => 'New Software Development',
                'client_id' => 3,
                'contracted_revenue' => 20000.00,
                'status' => 'In Progress',
                'validation_date' => Carbon::now()->toDateString(), // Assign current date
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
