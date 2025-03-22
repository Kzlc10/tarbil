<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-image: url('para1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }

        select, input[type="number"], input[type="submit"] {
            width: 100%;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            background-color: #f1f1f1;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .result {
            margin-top: 20px;
            padding: 16px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 4px;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Ürün Seçimi ve Ton Miktarı</h2>

    <form method="post">
        <label for="product">Ürün Seçin (Ton Başına Fiyatı):</label>
        <select id="product" name="product_name">
            <option value="25,Çeltik">Çeltik (25 TL/ton)</option>
            <option value="12,Buğday">Buğday (12 TL/ton)</option>
            <option value="14,Mısır">Mısır (14 TL/ton)</option>
            <option value="11,Haşhaş">Haşhaş (11 TL/ton)</option>
            <option value="16,Pancar">Pancar (16 TL/ton)</option>
            <option value="120,Sarımsak">Sarımsak (120 TL/ton)</option>
            <option value="18,Pamuk">Pamuk (18 TL/ton)</option>
            <option value="23,Zeytin">Zeytin (23 TL/ton)</option>
            <option value="26,Portakal">Portakal (26 TL/ton)</option>
            <option value="32,Domates">Domates (32 TL/ton)</option>
            <option value="44,Biber">Biber (44 TL/ton)</option>
            <option value="50,Salatalık">Salatalık (50 TL/ton)</option>
        </select>

        <label for="tons">Ton Miktarı:</label>
        <input type="number" id="tons" name="tons" min="0" step="0.01" required>

        <label for="yield">Randıman (%):</label>
        <input type="number" id="yield" name="yield" min="0" step="0.01" required>

        <input type="submit" value="Fiyatı Hesapla" name="calculate">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['calculate'])) {
        // Kullanıcıdan gelen verileri al
        list($product_value, $product_name) = explode(',', $_POST['product_name']);
        $tons = floatval($_POST['tons']);
        $yield = floatval($_POST['yield']);

        // Fiyatı hesapla
        $price = $product_value * $tons * $yield;

        // Sonucu göster
        echo "<div class='result'>";
        echo "<h3>Hesaplanan Fiyat</h3>";
        echo "<p>Seçilen Ürün: " . htmlspecialchars($product_name) . "</p>";
        echo "<p>Ton Miktarı: " . htmlspecialchars($tons) . "</p>";
        echo "<p>Randıman: " . htmlspecialchars($yield) . "%</p>";
        echo "<p>Hesaplanan Fiyat: " . number_format($price, 2) . " TL</p>";
        echo "</div>";
    }
    ?>
</div>

</body>
</html>