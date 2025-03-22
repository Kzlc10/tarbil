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
    <select id="product" name="product">
        <option value="25">Çeltik</option>
        <option value="12">Buğday</option>
        <option value="14">Mısır</option>
        <option value="11">Haşhaş</option>
        <option value="16">Pancar</option>
        <option value="120">Sarımsak</option>
        <option value="18">Pamuk</option>
        <option value="23">Zeytin</option>
        <option value="26">Portakal</option>
        <option value="32">Domates</option>
        <option value="44">Biber</option>
        <option value="50">Salatalık</option>
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
    $product = floatval($_POST['product']);
    $tons = floatval($_POST['tons']);
    $yield = floatval($_POST['yield']);

    // Fiyatı hesapla
    $price = $product * $tons * ($yield / 100);

    // Sonucu göster
    echo "<div class='result'>";
    echo "<h3>Hesaplanan Fiyat</h3>";
    echo "<p>Seçilen Ürün: " . htmlspecialchars($_POST['product']) . "</p>";
    echo "<p>Ton Miktarı: " . htmlspecialchars($tons) . "</p>";
    echo "<p>Randıman: " . htmlspecialchars($yield) . "%</p>";
    echo "<p>Hesaplanan Fiyat: " . number_format($price, 2) . " TL</p>";
    echo "</div>";
}
?>

</body>
</html>