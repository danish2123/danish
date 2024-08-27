<!DOCTYPE html>
<html>
<head>
    <title>Form Perkalian</title>
</head>
<body>
    <form action="" method="get">
        <input type="number" name="angka1" placeholder="Angka 1" required>
        <input type="number" name="angka2" placeholder="Angka 2" required>
        <button type="submit">Enter</button>
    </form>

    <h2>
    <?php
        if (isset($_GET['angka1']) && isset($_GET['angka2'])) {
            // Mengambil input dan sanitasi
            $no1 = filter_var($_GET['angka1'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $no2 = filter_var($_GET['angka2'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            
            // Validasi jika input bukan angka
            if (is_numeric($no1) && is_numeric($no2)) {
                $hasil = $no1 * $no2; // Mengubah operasi dari penjumlahan ke perkalian
                echo "Hasil dari $no1 * $no2 = $hasil";
            } else {
                echo "Input tidak valid.";
            }
        }
    ?>
    </h2>
</body>
</html>
