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

    public function generateHVACTicket(string $conversation): array
    {
        Log::info('Generando ticket HVAC con OpenAI', ['conversation' => $conversation]);

        $prompt = <<<EOT
        Eres un asistente especializado en soporte técnico SAT de climatización (aire acondicionado y calefacción).

        Tu objetivo es obtener, mediante preguntas claras y secuenciales, la información mínima necesaria
        para que un técnico pueda acudir con un diagnóstico preliminar fiable.

        ⚠️ IMPORTANTE
        NUNCA finalices el diagnóstico con frases genéricas.
        Solo finaliza cuando se haya obtenido TODA la información obligatoria.

        Información mínima obligatoria:
        
        ¿El equipo enciende?
            - Sí / No
        Si NO enciende:
            - ¿Hace algún intento? (ruido, luces, pitido, ventilador, etc.)
            - ¿O no hace absolutamente nada?
        Si SÍ enciende:
            - ¿Cuál es el síntoma principal?
            - No enfría
            - No calienta
            - Enfría poco
            - Hace ruido
            - Se apaga solo
            - Sale error
            - Otro (especificar)
        Si hay error:
            - Pedir SIEMPRE el código exacto que aparece en pantalla  
        
        Reglas:
            - Haz SOLO UNA pregunta por mensaje
            - Usa lenguaje sencillo, sin términos técnicos
            - No repitas preguntas ya respondidas
            - No hagas suposiciones técnicas
            - Prioriza preguntas cerradas (Sí / No) cuando sea posible
            - Si el cliente responde algo ambiguo, pide aclaración concreta

        Final del diagnóstico:
            - Cuando tengas toda la información obligatoria, finaliza el diagnóstico
            - Indica que un técnico se pondrá en contacto

        Solo devuelve `"pregunta_siguiente": null` cuando:
            - Se sabe si el equipo enciende
            - Se conoce el síntoma principal
            - Se ha preguntado por código de error (si aplica)
            
        Contexto de la conversación:
        $conversation

        Devuelve EXCLUSIVAMENTE un JSON con esta estructura:
        {
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
                    'pregunta_siguiente' => '¿El equipo llega a encender o no hace nada?',
                ];
            }

            if (!array_key_exists('pregunta_siguiente', $data)) {
                $data['pregunta_siguiente'] = '¿El equipo llega a encender o no hace nada?';
            }

            return $data;

        } catch (\Throwable $e) {
            Log::channel('whatsapp_ticket')->error('OpenAI request failed', ['message' => $e->getMessage()]);

            return [
                'pregunta_siguiente' => '¿El equipo llega a encender o no hace nada?',
            ];
        }
    }

    public function clasifyTicket(string $conversation, array $faultTypes): array
    {
        Log::channel('whatsapp_ticket')->info('Clasificando ticket con OpenAI', ['conversation' => $conversation]);
        $typesString = implode(', ', $faultTypes);

        $prompt = <<<EOT
        Eres un asistente que clasifica tickets de soporte técnico, además debes sugerir una posible solución para el técnico.

        Los tipos de averías posibles son, debes devolver el ID exacto:
        $typesString

        Los niveles de urgencia posibles son:
        'low','medium','high','critical'

        Contexto de la conversación:
        $conversation

        Devuelve EXCLUSIVAMENTE un JSON con esta estructura:
        {
            "tipo_averia_id": "",
            "nivel_urgencia": "",
            "solucion_sugerida": ""
        }
        EOT;

        try {
            $response = $this->client->responses()->create([
                'model' => 'gpt-4o-mini',
                'input' => $prompt,
            ]);

            $raw = trim($response->outputText);

            Log::channel('whatsapp_ticket')->info('Respuesta clasificación OpenAI RAW', ['raw' => $raw]);

            $clean = preg_replace('/^```json|```$/m', '', $raw);

            $data = json_decode(trim($clean), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::channel('whatsapp_ticket')->error('JSON decode error en clasificación', [
                    'error' => json_last_error_msg(),
                    'raw' => $clean,
                ]);

                return [
                    'tipo_averia' => 'general',
                    'nivel_urgencia' => 'medium',
                    'solucion_sugerida' => 'Revisar in situ para diagnóstico detallado.',
                ];
            }

            if (!isset($data['tipo_averia_id'], $data['nivel_urgencia'])) {
                Log::channel('whatsapp_ticket')->error('Respuesta OpenAI sin claves esperadas', [
                    'parsed' => $data,
                ]);

                return [
                    'tipo_averia' => 'general',
                    'nivel_urgencia' => 'medium',
                    'solucion_sugerida' => 'Revisar in situ para diagnóstico detallado.',
                ];
            }

            return $data;
        } catch (\Throwable $e) {
            Log::channel('whatsapp_ticket')->error('OpenAI request failed', ['message' => $e->getMessage()]);

            return [
                'tipo_averia' => 'general',
                'nivel_urgencia' => 'medium',
                'solucion_sugerida' => 'Revisar in situ para diagnóstico detallado.',
            ];
        }
    }
}