<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 20px auto;
            padding: 10px;
            background-color: #f0f8ff;
        }
        .chatbox {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
            height: 400px;
            overflow-y: auto;
            background-color: #ffffff;
        }
        .message {
            margin: 5px 0;
            padding: 8px;
            border-radius: 10px;
        }
        .user {
            text-align: right;
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .bot {
            text-align: left;
            background-color: #f8d7da;
            color: #842029;
        }
        form {
            display: flex;
            margin-top: 10px;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 5px;
            margin-left: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Yapay Zeka Sohbet Botu</h1>
    <div class="chatbox" id="chatbox">
        <?php
        session_start();

        // Mesaj geçmişini yönet
        if (!isset($_SESSION['chat_history'])) {
            $_SESSION['chat_history'] = [];
        }

        // Kullanıcıdan gelen mesajı işle
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['message']))) {
            $userMessage = htmlspecialchars(trim($_POST['message']));
            $_SESSION['chat_history'][] = ['user', $userMessage];

            // Bot yanıtları
            $responses = [
                "Merhaba" => "Merhaba! Size nasıl yardımcı olabilirim?",
                "Nasılsın" => "Ben bir yapay zeka asistanıyım, hep iyiyim. Siz nasılsınız?",
                "Teşekkürler" => "Rica ederim! Yardımcı olabileceğim başka bir konu var mı?",
                "Tarım nedir ve neden önemlidir?" => "Tarım, bitkisel ve hayvansal ürünlerin yetiştirilmesi faaliyetidir. İnsanların beslenme, giyim, barınma ve çeşitli endüstriyel ihtiyaçlarını karşılaması açısından kritik bir rol oynar.",
                "Tarım ürünleri nasıl sınıflandırılır?" => "Tarım ürünleri genel olarak şu şekilde sınıflandırılır: Bitkisel Ürünler: Tahıllar, sebzeler, meyveler, baklagiller. Hayvansal Ürünler: Et, süt, yumurta, deri. Endüstriyel Bitkiler: Pamuk, tütün, şeker pancarı, ayçiçeği.",
                "Tarımda organik üretim nedir?" => "Organik tarım, kimyasal gübreler ve pestisitler kullanılmadan yapılan, doğal yöntemlere dayalı üretimdir.",
                "Sürdürülebilir tarım nedir ve neden gereklidir?" => "Sürdürülebilir tarım, doğal kaynakları koruyan bir yöntemdir. İklim değişikliği, toprak erozyonu gibi sorunlara çözüm sunar.",
                "Modern tarım teknolojileri nelerdir?" => "Dijital tarım, dronelar, akıllı sulama sistemleri gibi teknolojiler modern tarımı oluşturur.",
                "Verimli bir toprak nasıl olmalıdır?" => "Besin maddelerince zengin, organik içeriği yüksek ve yeterli su tutma kapasitesine sahip olmalıdır.",
                "Toprağın pH değerini nasıl ölçebilirim?" => "pH ölçümü için özel cihazlar veya toprak test kitleri kullanabilirsiniz.",
                "Ekim zamanı nasıl belirlenir?" => "İklim şartlarına, toprak ısısına ve bitki türüne göre belirlenir.",
                "İyi bir sulama sistemi nasıl olmalıdır?" => "Su tasarrufu sağlayan, bitkinin ihtiyacını karşılayan bir sistem olmalıdır.",
                "Toprak analizi neden önemlidir?" => "Hangi gübrelerin ve besinlerin eksik olduğunu anlamaya yardımcı olur.",
                
                // Şehir bazlı tarım bilgileri
                "Adana" => "Adana'da ne ekilir? Pamuk, buğday, mısır, narenciye",
                "Adıyaman" => "Adıyaman'da ne ekilir? Tütün, buğday, mercimek, üzüm",
                "Afyonkarahisar" => "Afyonkarahisar'da ne ekilir? Haşhaş, buğday, arpa, şeker pancarı",
                "Ağrı" => "Ağrı'da ne ekilir? Buğday, arpa, patates, şeker pancarı",
                "Amasya" => "Amasya'da ne ekilir? Elma, buğday, şeker pancarı, kiraz",
                "Ankara" => "Ankara'da ne ekilir? Buğday, arpa, patates, şeker pancarı",
                "Antalya" => "Antalya'da ne ekilir? Seracılık, narenciye, muz, pamuk",
                "Artvin" => "Artvin'de ne ekilir? Çay, mısır, fındık, zeytin",
                "Aydın" => "Aydın'da ne ekilir? İncir, zeytin, pamuk, kestane",
                "Balıkesir" => "Balıkesir'de ne ekilir? Zeytin, buğday, arpa, ayçiçeği",
                "Bilecik" => "Bilecik'te ne ekilir? Buğday, arpa, şeker pancarı, elma",
                "Bingöl" => "Bingöl'de ne ekilir? Buğday, arpa, mercimek, fasulye",
                "Bitlis" => "Bitlis'te ne ekilir? Buğday, arpa, patates, şeker pancarı",
                "Bolu" => "Bolu'da ne ekilir? Buğday, arpa, mısır, patates",
                "Burdur" => "Burdur'da ne ekilir? Buğday, arpa, şeker pancarı, patates",
                "Bursa" => "Bursa'da ne ekilir? Şeftali, zeytin, buğday, mısır",
                "Çanakkale" => "Çanakkale'de ne ekilir? Buğday, arpa, zeytin, domates",
                "Çankırı" => "Çankırı'da ne ekilir? Buğday, arpa, şeker pancarı, patates",
                "Çorum" => "Çorum'da ne ekilir? Buğday, arpa, şeker pancarı, nohut",
                "Denizli" => "Denizli'de ne ekilir? Üzüm, pamuk, buğday, arpa",
                "Diyarbakır" => "Diyarbakır'da ne ekilir? Buğday, arpa, pamuk, mısır",
                "Edirne" => "Edirne'de ne ekilir? Ayçiçeği, buğday, arpa, mısır",
                "Elazığ" => "Elazığ'da ne ekilir? Üzüm, kayısı, buğday, arpa",
                "Erzincan" => "Erzincan'da ne ekilir? Buğday, arpa, şeker pancarı, patates",
                "Erzurum" => "Erzurum'da ne ekilir? Buğday, arpa, patates, şeker pancarı",
                "Eskişehir" => "Eskişehir'de ne ekilir? Buğday, arpa, şeker pancarı, ayçiçeği",
                "Gaziantep" => "Gaziantep'te ne ekilir? Antepfıstığı, buğday, arpa, pamuk",
                "Giresun" => "Giresun'da ne ekilir? Fındık, çay, mısır, kivi",
                "Gümüşhane" => "Gümüşhane'de ne ekilir? Buğday, arpa, fasulye, şeker pancarı",
                "Hakkari" => "Hakkari'de ne ekilir? Buğday, arpa, patates, şeker pancarı",
                "Hatay" => "Hatay'da ne ekilir? Zeytin, narenciye, pamuk, buğday",
                "Isparta" => "Isparta'da ne ekilir? Gül, elma, buğday, arpa",
                "Mersin" => "Mersin'de ne ekilir? Narenciye, muz, pamuk, buğday",
                "İstanbul" => "İstanbul'da ne ekilir? Sebze, meyve, buğday, arpa",
                "İzmir" => "İzmir'de ne ekilir? Üzüm, pamuk, zeytin, incir",
                "Kars" => "Kars'ta ne ekilir? Buğday, arpa, patates, şeker pancarı",
                "Kastamonu" => "Kastamonu'da ne ekilir? Buğday, arpa, çavdar, patates",
                "Kayseri" => "Kayseri'de ne ekilir? Buğday, arpa, şeker pancarı, patates",
                "Kırklareli" => "Kırklareli'de ne ekilir? Ayçiçeği, buğday, arpa, mısır",
                "Kırşehir" => "Kırşehir'de ne ekilir? Buğday, arpa, nohut, şeker pancarı",
                "Kocaeli" => "Kocaeli'de ne ekilir? Sebze, meyve, buğday, arpa",
                "Konya" => "Konya'da ne ekilir? Buğday, arpa, şeker pancarı, mısır",
                "Kütahya" => "Kütahya'da ne ekilir? Buğday, arpa, haşhaş, şeker pancarı",
                "Malatya" => "Malatya'da ne ekilir? Kayısı, buğday, arpa, şeker pancarı",
                "Manisa" => "Manisa'da ne ekilir? Üzüm, pamuk, zeytin, şeftali",
                "Mardin" => "Mardin'de ne ekilir? Buğday, arpa, mercimek, pamuk",
                "Muğla" => "Muğla'da ne ekilir? Zeytin, narenciye, üzüm, pamuk",
                "Muş" => "Muş'ta ne ekilir? Buğday, arpa, patates, şeker pancarı",
                "Nevşehir" => "Nevşehir'de ne ekilir? Patates, buğday, arpa, şeker pancarı",
                "Niğde" => "Niğde'de ne ekilir? Patates, buğday, elma, arpa",
                "Ordu" => "Ordu'da ne ekilir? Fındık, çay, mısır, kivi",
                "Rize" => "Rize'de ne ekilir? Çay, mısır, kivi, sebze",
                "Sakarya" => "Sakarya'da ne ekilir? Mısır, buğday, fındık, sebze",
                "Samsun" => "Samsun'da ne ekilir? Mısır, buğday, çeltik, fındık",
                "Siirt" => "Siirt'te ne ekilir? Fıstık, buğday, arpa, pamuk",
                "Sinop" => "Sinop'ta ne ekilir? Buğday, arpa, mısır, fındık",
                "Sivas" => "Sivas'ta ne ekilir? Buğday, arpa, şeker pancarı, patates",
                "Şanlıurfa" => "Şanlıurfa'da ne ekilir? Pamuk, buğday, arpa, mercimek",
                "Şırnak" => "Şırnak'ta ne ekilir? Buğday, arpa, pamuk, mercimek",
                "Tekirdağ" => "Tekirdağ'da ne ekilir? Ayçiçeği, buğday, arpa, üzüm",
                "Tokat" => "Tokat'ta ne ekilir? Domates, biber, buğday, şeker pancarı",
                "Trabzon" => "Trabzon'da ne ekilir? Çay, fındık, mısır, sebze",
                "Tunceli" => "Tunceli'de ne ekilir? Buğday, arpa, mercimek, nohut",
                "Uşak" => "Uşak'ta ne ekilir? Buğday, arpa, şeker pancarı, patates",
                "Van" => "Van'da ne ekilir? Buğday, arpa, patates, şeker pancarı",
                "Yalova" => "Yalova'da ne ekilir? Sebze, meyve, çiçekçilik",
                "Yozgat" => "Yozgat'ta ne ekilir? Buğday, arpa, şeker pancarı, nohut",
                "Zonguldak" => "Zonguldak'ta ne ekilir? Buğday, arpa, mısır, fındık",
                "Aksaray" => "Aksaray'da ne ekilir? Buğday, arpa, şeker pancarı, patates",
                "Bayburt" => "Bayburt'ta ne ekilir? Buğday, arpa, patates, şeker pancarı",
                "Karaman" => "Karaman'da ne ekilir? Buğday, arpa, şeker pancarı, patates",
                "Kırıkkale" => "Kırıkkale'de ne ekilir? Buğday, arpa, şeker pancarı, patates",
                "Batman" => "Batman'da ne ekilir? Buğday, arpa, mercimek, pamuk",
                "Bartın" => "Bartın'da ne ekilir? Buğday, arpa, mısır, fındık",
                "Ardahan" => "Ardahan'da ne ekilir? Buğday, arpa, patates, şeker pancarı",
                "Iğdır" => "Iğdır'da ne ekilir? Pamuk, buğday, arpa, şeker pancarı",
                "Karabük" => "Karabük'te ne ekilir? Buğday, arpa, mısır, fındık",
                "Kilis" => "Kilis'te ne ekilir? Zeytin, buğday, arpa, pamuk",
                "Osmaniye" => "Osmaniye'de ne ekilir? Yer fıstığı, buğday, arpa, pamuk",
                "Düzce" => "Düzce'de ne ekilir? Fındık, mısır, buğday, arpa"
            ];

            // Varsayılan yanıt
            $botResponse = "Üzgünüm, bu konuda bir bilgim yok. Daha fazla bilgi verebilir misiniz?";

            // Anahtar kelimeye göre yanıt bul
            foreach ($responses as $key => $response) {
                if (stripos($userMessage, $key) !== false) {
                    $botResponse = $response;
                    break;
                }
            }

            // Yanıtı geçmişe ekle
            $_SESSION['chat_history'][] = ['bot', $botResponse];
        }

        // Mesaj geçmişini göster
        foreach ($_SESSION['chat_history'] as $chat) {
            $class = $chat[0] === 'user' ? 'user' : 'bot';
            echo "<div class='message $class'>" . $chat[1] . "</div>";
        }
        ?>
    </div>

    <form method="POST">
        <input type="text" name="message" placeholder="Mesajınızı yazın..." required>
        <button type="submit">Gönder</button>
    </form>
</body>
</html>