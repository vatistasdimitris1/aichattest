<?php
header('Content-Type: application/json');

$apiKey = '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';
$input = json_decode(file_get_contents('php://input'), true);
$userMessage = $input['message'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/engines/gpt-4/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'prompt' => $userMessage,
    'max_tokens' => 150
]));

$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$response = json_decode($result, true);
$reply = $response['choices'][0]['text'] ?? 'Sorry, I couldn\'t understand that.';

echo json_encode(['reply' => $reply]);
?>
