<?php

namespace Database\Seeders;

use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\ServiciosTipo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EncuestaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear la encuesta
        $encuesta = Encuesta::create([
            'nombre' => 'Encuesta de Satisfacción por la Visita al Inmueble',
            'habilitado_hasta' => Carbon::now()->addMonths(1),
        ]);

        // Crear las preguntas para la encuesta
        Pregunta::create([
            'pregunta' => 'Muy malo',
            'encuesta_id' => $encuesta->id,
        ]);

        Pregunta::create([
            'pregunta' => 'Malo',
            'encuesta_id' => $encuesta->id,
        ]);

        Pregunta::create([
            'pregunta' => 'Regular',
            'encuesta_id' => $encuesta->id,
        ]);

        Pregunta::create([
            'pregunta' => 'Bueno',
            'encuesta_id' => $encuesta->id,
        ]);

        Pregunta::create([
            'pregunta' => 'Excelente',
            'encuesta_id' => $encuesta->id,
        ]);

        ServiciosTipo::create([
            'nombre' => 'Mantenimiento',
            'detalle' => 'Servicios de mantenimiento preventivo y correctivo para asegurar el buen estado de las instalaciones.'
        ]);
        
        ServiciosTipo::create([
            'nombre' => 'Decoración',
            'detalle' => 'Servicios de decoración de interiores y exteriores, incluyendo diseño y selección de elementos decorativos.'
        ]);
        
        ServiciosTipo::create([
            'nombre' => 'Ampliación de ambientes',
            'detalle' => 'Servicios para la ampliación de espacios existentes, adaptando la estructura para mejorar la funcionalidad.'
        ]);
        
        ServiciosTipo::create([
            'nombre' => 'Demolición',
            'detalle' => 'Servicios de demolición controlada de estructuras, garantizando la seguridad y cumplimiento de normativas.'
        ]);
        
    }
}
