<?php

namespace Database\Seeders;

use App\Models\Direccion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuario Administrador (rol protegido fuera de $fillable)
        $admin = User::firstOrCreate(
            ['email' => 'admin@tienda.pe'],
            [
                'name'                => 'Administrador Tienda',
                'password'            => Hash::make('password'),
                'documento_identidad' => '40000001',
                'telefono'            => '984000001',
            ]
        );
        $admin->rol = 'admin';
        $admin->save();

        // 2. Cliente de prueba principal
        $cliente = User::firstOrCreate(
            ['email' => 'cliente@tienda.pe'],
            [
                'name'                => 'Carlos Mendoza Quispe',
                'password'            => Hash::make('password'),
                'documento_identidad' => '45123456',
                'telefono'            => '984123456',
            ]
        );

        Direccion::firstOrCreate(
            ['user_id' => $cliente->id, 'calle' => 'Av. El Sol 450'],
            [
                'ciudad'        => 'Cusco',
                'referencia'    => 'Frente al Qorikancha',
                'codigo_postal' => '08002',
                'es_principal'  => true,
            ]
        );

        Direccion::firstOrCreate(
            ['user_id' => $cliente->id, 'calle' => 'Av. La Cultura 1220'],
            [
                'ciudad'        => 'Cusco',
                'referencia'    => 'Segundo piso, oficina 204',
                'codigo_postal' => '08003',
                'es_principal'  => false,
            ]
        );

        // 3. Clientes adicionales de demo (solo si aún no existen)
        if (User::where('rol', 'cliente')->count() < 6) {
            User::factory(5)->create()->each(function (User $u) {
                Direccion::factory()->create([
                    'user_id'      => $u->id,
                    'es_principal' => true,
                ]);
            });
        }

        // 4. Catálogo maestro
        $this->call([
            CategoriaSeeder::class,
            MarcaSeeder::class,
            ProductoSeeder::class,
        ]);
    }
}