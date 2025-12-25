<?php

namespace App\Services;

use OpenAI\OpenAI;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = \OpenAI::client(config('services.openai.api_key'));
    }

    public function generarTicketHVAC(string $conversation): array
    {
        Log::info('Generando ticket HVAC con OpenAI', ['conversation' => $conversation]);

        $prompt = <<<EOT
        Eres un asistente especializado en SAT HVAC.

        Tu tarea es ayudar a diagnosticar averías de climatización mediante preguntas secuenciales
        hasta tener información mínima suficiente para enviar un técnico.

        ⚠️ NUNCA des por finalizado el diagnóstico solo con frases genéricas.

        Información mínima obligatoria:
        - Saber si el equipo enciende o no
        - Saber qué síntoma principal presenta (no enfría, no calienta, ruido, error, etc.)
        - Si hay un error debes averiguar cuál es
        - Nivel de urgencia ['low', 'medium', 'high', 'critical']

        Reglas:
        - Haz SOLO una pregunta a la vez
        - Usa lenguaje claro para un cliente no técnico
        - Si falta cualquier dato obligatorio, formula una pregunta
        - Solo deja "pregunta_siguiente": null cuando se cumplan los mínimos

        Contexto de la conversación:
        $conversation

        Devuelve EXCLUSIVAMENTE un JSON con esta estructura:
        {
            "tipo_averia": "",
            "urgencia": "",
            "solucion_probable": "",
            "pregunta_siguiente": ""
        }
        EOT;

        try {
            $response = $this->client->responses()->create([
                'model' => 'gpt-4o-mini',
                'input' => $prompt,
                'text' => [
                    'format' => ['type' => 'json_object'],
                ],
            ]);

            $output = trim($response->outputText);

            $data = json_decode($output, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('OpenAI JSON decode error', [
                    'error' => json_last_error_msg(),
                    'raw' => $output,
                ]);

                return [
                    'tipo_averia' => '',
                    'urgencia' => '',
                    'solucion_probable' => '',
                    'pregunta_siguiente' => '¿El equipo llega a encender o no hace nada?',
                ];
            }

            if (!array_key_exists('pregunta_siguiente', $data)) {
                $data['pregunta_siguiente'] = '¿El equipo llega a encender o no hace nada?';
            }

            return $data;

        } catch (\Throwable $e) {
            Log::error('OpenAI request failed', ['message' => $e->getMessage()]);

            return [
                'tipo_averia' => '',
                'urgencia' => '',
                'solucion_probable' => '',
                'pregunta_siguiente' => '¿El equipo llega a encender o no hace nada?',
            ];
        }
    }
}