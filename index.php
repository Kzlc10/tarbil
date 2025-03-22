<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Yapay Zeka Bot</title>
    <style>
        body { 
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
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
            height: 60px;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
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
        <h1>PHP Yapay Zeka Bot</h1>
        <div id="chat-box"></div>
        <textarea id="user-input" placeholder="Mesajınızı yazın..."></textarea>
        <button id="send-btn">Gönder</button>
    </div>

    <script>
        document.getElementById('send-btn').addEventListener('click', async () => {
            const userInput = document.getElementById('user-input').value;
            if (!userInput) return;

            // Kullanıcı mesajını ekrana yaz
            const chatBox = document.getElementById('chat-box');
            const userMessage = document.createElement('div');
            userMessage.classList.add('message', 'user-message');
            userMessage.textContent = userInput;
            chatBox.appendChild(userMessage);

            // Bot'tan yanıt al
            try {
                const response = await fetch('', { // PHP dosyasına göre doğru yolu ayarlayın
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ message: userInput }),
                });

                const data = await response.json();

                // Bot yanıtını ekrana yaz
                const botMessage = document.createElement('div');
                botMessage.classList.add('message', 'bot-message');
                botMessage.textContent = data.response;
                chatBox.appendChild(botMessage);
            } catch (error) {
                const errorMessage = document.createElement('div');
                errorMessage.classList.add('message', 'bot-message');
                errorMessage.textContent = "Bir hata oluştu. Lütfen tekrar deneyin.";
                chatBox.appendChild(errorMessage);
            }

            // Giriş alanını temizle
            document.getElementById('user-input').value = '';
        });
    </script>

    <?php
    // Hata raporlamayı etkinleştirin
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header("Content-Type: application/json");

        // JSON bilgisi
        $jsonData = '{
            "Merhaba": "Merhaba! Sana nasıl yardımcı olabilirim?",
            "Nasılsın?": "Teşekkür ederim, ben bir yapay zeka botuyum, hep iyiyim. :)",
            "Adın ne?": "Ben bir PHP yapay zeka botuyum!",
            "Görüşürüz": "Görüşürüz! İyi günler dilerim."
        }';

        $knowledge = json_decode($jsonData, true);

        // Kullanıcıdan gelen veriyi al
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['message']) || empty($data['message'])) {
            echo json_encode(["response" => "Lütfen bir mesaj gönderin."]);
            exit;
        }

        $userMessage = trim($data['message']);

        // Mesaja uygun yanıtı bul
        $response = "Üzgünüm, bunu anlayamadım. Daha farklı bir şekilde sorabilir misin?";
        if (array_key_exists($userMessage, $knowledge)) {
            $response = $knowledge[$userMessage];
        }

        // Yanıtı JSON olarak döndür
        echo json_encode(["response" => $response]);
        exit;
    }
    ?>
</body>
</html>


