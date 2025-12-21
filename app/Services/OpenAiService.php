<?php

namespace App\Services;

use OpenAI\OpenAI;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = \OpenAI::client(config('services.openai.api_key'));
    }

    public function generarTicketHVAC(string $descripcion): array
    {
        $prompt = <<<EOT
        Eres un asistente especializado en SAT HVAC.

        Tu tarea es ayudar a diagnosticar averías de climatización mediante preguntas secuenciales
        hasta tener información mínima suficiente para enviar un técnico.

        ⚠️ NUNCA des por finalizado el diagnóstico solo con frases genéricas como:
        - "tengo una avería"
        - "no funciona"
        - "está estropeado"

        Información mínima obligatoria antes de finalizar:
        - Saber si el equipo enciende o no
        - Saber qué síntoma principal presenta (no enfría, no calienta, ruido, error, etc.)

        Reglas:
        - Haz SOLO una pregunta a la vez
        - Usa lenguaje claro para un cliente no técnico
        - Si falta cualquier dato obligatorio, debes formular una pregunta
        - Solo deja "pregunta_siguiente": null cuando se cumplan los mínimos

        Información disponible:
        - Descripción del cliente: "{$descripcion}"

        Devuelve EXCLUSIVAMENTE un JSON con esta estructura:
        {
        "tipo_averia": "",
        "urgencia": "",
        "solucion_probable": "",
        "tecnico_recomendado": "",
        "pregunta_siguiente": ""
        }
        EOT;

        $response = $this->client->responses()->create([
            'model' => 'gpt-4o-mini',
            'input' => $prompt,
            'text' => [
                'format' => [
                    'type' => 'json_object',
                ],
            ],  
        ]);
        
        \Log::info('OpenAI outputText', [
            'response' => $response
        ]);

        $output = trim($response->outputText);

        \Log::info('OpenAI raw JSON', ['json' => $output]);

        $data = json_decode($output, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            \Log::error('OpenAI JSON decode error', [
                'error' => json_last_error_msg(),
                'raw'   => $output,
            ]);

            return [
                'tipo_averia' => '',
                'urgencia' => '',
                'solucion_probable' => '',
                'tecnico_recomendado' => '',
                'pregunta_siguiente' => '¿El equipo llega a encender o no hace nada?',
            ];
        }

        return $data;
    }
}