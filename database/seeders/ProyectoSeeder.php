<?php

namespace Database\Seeders;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProyectoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        if (! $user) {
            return;
        }

        Proyecto::factory()->count(3)->activo()->create(['user_id' => $user->id]);
        Proyecto::factory()->count(1)->completado()->create(['user_id' => $user->id]);
        Proyecto::factory()->count(1)->create([
            'user_id' => $user->id,
            'estado'  => 'pausado',
        ]);
    }
}
