<?php

namespace App\Http\Controllers\Api\Traits;

use Illuminate\Support\Facades\Http;
use App\Models\Apps;
use App\Models\AppPolicies;

class AItraits
{
    public function askQuestion($message, $appSlug)
    {
        $appPolicy = $this->findApp($appSlug);
        if (!$appPolicy) {
            return response()->json(['status' => 'error', 'message' => 'App not found or no policies available'], 404);
        }

        $prompt = $this->generatePrompt($appPolicy, $message);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('services.openai.key'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => $prompt],
                ['role' => 'user', 'content' => $message],
            ],
            'temperature' => 0.7,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => json_decode($response->body())->choices[0]->message->content,
        ]);
    }

    public function findApp($appSlug)
    {
        $app = Apps::where('slug', $appSlug)->first();
        if (!$app) {
            return null;
        }

        $policies = AppPolicies::where('app_id', $app->id)->pluck('content')->toArray();
        return implode("\n\n", $policies);
    }

    public function generatePrompt($appPolicy)
    {
        return (<<<EOT
                You are an assistant for an application. The following is the privacy policy of the application:

                $appPolicy

                The user will ask you questions about this privacy policy. Please provide responses based on the policy. If the user's question is outside the scope of the privacy policy, respond with "Üzgünüm, sadece bu uygulamanın gizlilik politikası ile ilgili bilgi verebilirim."
                EOT);
    }
}
