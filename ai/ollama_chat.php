<?php

header("Content-Type: application/json");

try {

$data = json_decode(file_get_contents("php://input"), true);

if(!isset($data["message"])){
throw new Exception("Message missing");
}

$userMessage = $data["message"];

$systemPrompt = "You are Raksha AI, a smart women safety assistant.

Your job is to help women stay safe while travelling or facing danger.

Rules:
- Give short practical safety advice
- Suggest calling police or trusted contacts
- Suggest going to crowded places
- Encourage sharing live location
- Be supportive and calm
- If user says they are in danger give urgent safety steps

Emergency numbers in India:
Police: 100
Women Helpline: 1091
Emergency: 112
";

$prompt = $systemPrompt . "\nUser: " . $userMessage . "\nRaksha AI:";

$payload = [
"model" => "phi3",
"prompt" => $prompt,
"stream" => false
];

$ch = curl_init("http://ollama:11434/api/generate");

curl_setopt_array($ch, [
CURLOPT_RETURNTRANSFER => true,
CURLOPT_POST => true,
CURLOPT_HTTPHEADER => [
"Content-Type: application/json"
],
CURLOPT_POSTFIELDS => json_encode($payload),
CURLOPT_TIMEOUT => 60
]);

$response = curl_exec($ch);

if($response === false){
throw new Exception(curl_error($ch));
}

curl_close($ch);

$result = json_decode($response,true);

echo json_encode([
"reply" => trim($result["response"] ?? "Sorry, I couldn't respond.")
]);

}

catch(Exception $e){

echo json_encode([
"reply" => "⚠️ Raksha AI temporarily unavailable."
]);

}