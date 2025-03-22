<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatGPT PHP API</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }
        #chat-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            margin: 10px 0;
        }
        .user-message {
            text-align: right;
            color: #007BFF;
        }
        .bot-message {
            text-align: left;
            color: #333;
        }
        textarea {
            width: 100%;
            height: 80px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="chat-container">
        <h1>ChatGPT PHP API</h1>
        <div id="chat-box"></div>
        <textarea id="user-input" placeholder="Sorunuzu yazın..."></textarea>
        <button id="send-btn">Gönder</button>
    </div>

    <script>
        document.getElementById('send-btn').addEventListener('click', async () => {
            const userInput = document.getElementById('user-input').value;
            if (!userInput) return;

            // Kullanıcı mesajını göster
            const chatBox = document.getElementById('chat-box');
            const userMessage = document.createElement('div');
            userMessage.classList.add('message', 'user-message');
            userMessage.textContent = userInput;
            chatBox.appendChild(userMessage);

            // API'ye istek gönder
            try {
                const response = await fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ prompt: userInput }),
                });

                const data = await response.json();

                // ChatGPT yanıtını göster
                const botMessage = document.createElement('div');
                botMessage.classList.add('message', 'bot-message');
                botMessage.textContent = data.choices?.[0]?.message?.content || "Hata oluştu.";
                chatBox.appendChild(botMessage);
            } catch (error) {
                const errorMessage = document.createElement('div');
                errorMessage.classList.add('message', 'bot-message');
                errorMessage.textContent = "API ile bağlantı kurulamadı.";
                chatBox.appendChild(errorMessage);
            }

            // Giriş alanını temizle
            document.getElementById('user-input').value = '';
        });
    </script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Content-Type: application/json");

    // OpenAI API Anahtarı
    $apiKey = "YOUR_API_KEY";

    // Kullanıcıdan gelen veriyi al
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['prompt'])) {
        echo json_encode(["error" => "Prompt is required."]);
        exit;
    }

    $prompt = $data['prompt'];

    // OpenAI API'ye istek gönder
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/chat/completions");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
    ]);

    $postData = [
        "model" => "gpt-4",
        "messages" => [
            ["role" => "system", "content" => "You are a helpful assistant."],
            ["role" => "user", "content" => $prompt]
        ]
    ];

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode !== 200) {
        echo json_encode(["error" => "API error: " . $response]);
        exit;
    }

    curl_close($ch);

    // Yanıtı döndür
    echo $response;
    exit;
}
?>
</body>
</html>
