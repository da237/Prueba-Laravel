<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Visit;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\text;

class CrearVisita extends Command
{
    protected $signature = 'visita:crear';
    protected $description = 'Crear una nueva visita con Laravel Prompts';

    public function handle()
    {
        $nombre = text(
            label: 'Nombre del visitante',
            required: true
        );

        $email = text(
            label: 'Correo electrónico',
            required: true
        );

        $latitud = text(
            label: 'Latitud',
            required: true
        );

        $longitud = text(
            label: 'Longitud',
            required: true
        );

        // Validación de los datos ingresados
        $validator = Validator::make([
            'nombre' => $nombre,
            'email' => $email,
            'latitud' => $latitud,
            'longitud' => $longitud,
        ], [
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            $this->error('Error en la validación:');
            foreach ($validator->errors()->all() as $error) {
                $this->error("- $error");
            }
            return Command::FAILURE;
        }

        // Guardar en la base de datos
        Visit::create([
            'name' => $nombre,
            'email' => $email,
            'latitud' => $latitud,
            'longitud' => $longitud,
        ]);

        $this->info('✅ Visita creada exitosamente.');
        return Command::SUCCESS;
    }
}
