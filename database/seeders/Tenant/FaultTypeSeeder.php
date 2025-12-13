<?php

namespace Database\Seeders\Tenant;

use App\Models\Tenant\FaultType;
use Illuminate\Database\Seeder;

class FaultTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faultTypes = [
            // Averías prioritarias (high)
            [
                'name' => 'Fuga de gas refrigerante',
                'description' => 'Pérdida de gas refrigerante en el sistema, puede causar daños graves y reducir la eficiencia.',
                'priority' => 'high',
            ],
            [
                'name' => 'Compresor averiado',
                'description' => 'El compresor no funciona correctamente, impidiendo la refrigeración o calefacción.',
                'priority' => 'high',
            ],
            [
                'name' => 'Fallo eléctrico',
                'description' => 'Problema en el sistema eléctrico que impide el funcionamiento del equipo.',
                'priority' => 'high',
            ],

            // Averías de prioridad media (medium)
            [
                'name' => 'Filtro obstruido',
                'description' => 'El filtro de aire está sucio u obstruido, reduciendo el flujo de aire y la eficiencia.',
                'priority' => 'medium',
            ],
            [
                'name' => 'Ventilador defectuoso',
                'description' => 'El ventilador no gira correctamente o hace ruidos anormales.',
                'priority' => 'medium',
            ],
            [
                'name' => 'Termostato descalibrado',
                'description' => 'El termostato no regula correctamente la temperatura.',
                'priority' => 'medium',
            ],
            [
                'name' => 'Condensador sucio',
                'description' => 'El condensador tiene acumulación de suciedad que reduce la eficiencia del sistema.',
                'priority' => 'medium',
            ],
            [
                'name' => 'Drenaje obstruido',
                'description' => 'El sistema de drenaje de condensados está bloqueado, causando derrames de agua.',
                'priority' => 'medium',
            ],
            [
                'name' => 'Válvula de expansión defectuosa',
                'description' => 'La válvula de expansión no regula correctamente el flujo de refrigerante.',
                'priority' => 'medium',
            ],

            // Averías de baja prioridad (low)
            [
                'name' => 'Ruido excesivo',
                'description' => 'El equipo produce ruidos molestos pero sigue funcionando.',
                'priority' => 'low',
            ],
            [
                'name' => 'Mandos a distancia sin respuesta',
                'description' => 'El control remoto no funciona correctamente (pilas, receptor IR).',
                'priority' => 'low',
            ],
            [
                'name' => 'Limpieza general necesaria',
                'description' => 'Mantenimiento preventivo general del equipo.',
                'priority' => 'low',
            ],
            [
                'name' => 'Ajuste de configuración',
                'description' => 'Necesidad de reconfigurar parámetros del sistema sin avería real.',
                'priority' => 'low',
            ],
            [
                'name' => 'Mal olor',
                'description' => 'El sistema emite olores desagradables pero funciona correctamente.',
                'priority' => 'low',
            ],
            [
                'name' => 'Goteo menor',
                'description' => 'Pequeñas fugas de agua que no afectan significativamente el funcionamiento.',
                'priority' => 'low',
            ],
        ];

        foreach ($faultTypes as $faultType) {
            FaultType::create($faultType);
        }
    }
}
