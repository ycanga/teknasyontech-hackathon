<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apps;
use App\Models\AppQuestions;
use App\Http\Controllers\Api\Traits\AItraits;

class PolicyController extends Controller
{
    public function __construct()
    {
        $this->AItraits = new AItraits();
    }

    public function index()
    {
        $apps = Apps::where('status', 'active')->with('policies')->get();
        return response()->json($apps);
    }

    public function store($appSlug, $question)
    {
        $app = Apps::where('slug', $appSlug)->first();
        if (!$app) {
            return response()->json(['status' => 'error', 'message' => 'App not found'], 404);
        }

        $answer = $this->AItraits->askQuestion($question, $appSlug);
        AppQuestions::create([
            'app_id' => $app->id,
            'question' => $question,
            'answer' => $answer,
        ]);

        return response()->json(['status' => 'success', 'answer' => $answer]);
    }
}
