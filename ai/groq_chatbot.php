<?php
header("Content-Type: application/json");

// api
$apiKey = "";

$input = json_decode(file_get_contents("php://input"), true);
$userInput = $input["message"] ?? "";

if (!$userInput) {
    echo json_encode(["error" => "No input"]);
    exit;
}

function detectLanguage($text) {

    if (preg_match('/[\x{0980}-\x{09FF}]/u', $text)) return "bn"; // Bengali
    if (preg_match('/[\x{0A80}-\x{0AFF}]/u', $text)) return "gu"; // Gujarati
    if (preg_match('/[\x{0A00}-\x{0A7F}]/u', $text)) return "pa"; // Punjabi
    if (preg_match('/[\x{0B00}-\x{0B7F}]/u', $text)) return "or"; // Odia
    if (preg_match('/[\x{0C00}-\x{0C7F}]/u', $text)) return "te"; // Telugu
    if (preg_match('/[\x{0C80}-\x{0CFF}]/u', $text)) return "kn"; // Kannada
    if (preg_match('/[\x{0D00}-\x{0D7F}]/u', $text)) return "ml"; // Malayalam
    if (preg_match('/[\x{0B80}-\x{0BFF}]/u', $text)) return "ta"; // Tamil
    if (preg_match('/[\x{0900}-\x{097F}]/u', $text)) return "hi"; // Hindi / Marathi
    if (preg_match('/[\x{0600}-\x{06FF}]/u', $text)) return "ur"; // Urdu

    return "en"; 
}

$lang = detectLanguage($userInput);

$systemPrompt = "
You are Raksha AI — a women safety assistant.

Language Rules:
- Detect user's language automatically
- Reply ONLY in this language: $lang

Supported languages:
English, Hindi, Marathi, Tamil, Telugu, Kannada, Malayalam, Bengali, Gujarati, Punjabi, Odia, Urdu

IMPORTANT INDIAN HELPLINES:
- Police: 100
- Emergency: 112
- Women Helpline: 1091
- Domestic Violence: 181
- Ambulance: 102
- Child Helpline: 1098

Behavior:
- Keep response short, clear, practical
- Always suggest calling 112 in serious danger
- Stay calm and supportive
";

$data = [
    "model" => "llama-3.1-8b-instant",
    "messages" => [
        [
            "role" => "system",
            "content" => $systemPrompt
        ],
        [
            "role" => "user",
            "content" => $userInput
        ]
    ]
];

$ch = curl_init("https://api.groq.com/openai/v1/chat/completions");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode([
        "reply" => "⚠️ Connection issue. Call 112 if in danger."
    ]);
    exit;
}

curl_close($ch);

$result = json_decode($response, true);

echo json_encode([
    "reply" => $result["choices"][0]["message"]["content"] ?? "Error",
    "lang" => $lang  
]);
?>