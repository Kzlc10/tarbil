<!DOCTYPE html>
<html>
<head>
    <style>
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
            background-color: #f1f1f1;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<h2>Ürün Seçimi ve Ton Miktarı</h2>

<form method="post">
    <label for="product">Ürün Seçin:</label>
    <select id="product" name="product_name">
        <option value="25,Çeltik">Çeltik</option>
        <option value="12,Buğday">Buğday</option>
        <option value="14,Mısır">Mısır</option>
        <option value="11,Haşhaş">Haşhaş</option>
        <option value="16,Pancar">Pancar</option>
        <option value="120,Sarımsak">Sarımsak</option>
        <option value="18,Pamuk">Pamuk</option>
        <option value="23,Zeytin">Zeytin</option>
        <option value="26,Portakal">Portakal</option>
        <option value="32,Domates">Domates</option>
        <option value="44,Biber">Biber</option>
        <option value="50,Salatalık">Salatalık</option>
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

</body>
</html>