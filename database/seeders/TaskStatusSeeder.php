<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['nombre' => 'Pendiente',    'color' => '#6B7280', 'orden' => 1],
            ['nombre' => 'En progreso',  'color' => '#3B82F6', 'orden' => 2],
            ['nombre' => 'En revisión',  'color' => '#F59E0B', 'orden' => 3],
            ['nombre' => 'Completado',   'color' => '#10B981', 'orden' => 4],
        ];

        foreach ($statuses as $status) {
            DB::table('task_statuses')->updateOrInsert(
                ['nombre' => $status['nombre']],
                array_merge($status, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
