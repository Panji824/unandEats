<?php
require 'function.php'; // Pastikan file ini mengatur koneksi database

// Ambil kategori dari URL dan sanitasi
$kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';
$kategori = mysqli_real_escape_string($conn, $kategori);

// Query data kantin untuk referensi
$query_kantin = "SELECT * FROM kantin";
$result_kantin = mysqli_query($conn, $query_kantin);

$kantin_data = [];
if ($result_kantin) {
    while ($row = mysqli_fetch_assoc($result_kantin)) {
        $kantin_data[$row['id_kantin']] = $row['nama_kantin'];
    }
}

// Query data menu berdasarkan kategori
$query_menu = "SELECT * FROM menu_makanan WHERE kategori = ?";
$stmt = $conn->prepare($query_menu);
$stmt->bind_param("s", $kategori);
$stmt->execute();
$result_menu = $stmt->get_result();

// Cek apakah kategori ada
$kategori_display = $kategori ? htmlspecialchars($kategori) : 'Kategori Tidak Ditemukan';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $kategori_display; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
</head>
<body class="bg-gray-50 min-h-screen py-8 px-4">
    <div class="max-w-7xl mx-auto">
    <!-- Header -->
     <div class="bg-white rounded-lg shadow-md mb-8">
        <div class="p-6 flex justify-between items-center bg-emerald-600 rounded-t-lg">
            <h1 class="text-2xl font-bold text-white"><?= $kategori_display; ?></h1>
            <button onclick="history.back()" class="px-4 py-2 bg-emerald-700 text-white rounded-lg hover:bg-emerald-800 transition-colors">
                    Kembali
                </button>
        </div>
    </div>

       <!-- Grid Container -->
       <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Menu Card 1 -->
            <?php 
            if ($result_menu && $result_menu->num_rows > 0) {
                while ($row = $result_menu->fetch_assoc()) {
                    $nama_kantin = isset($kantin_data[$row['id_kantin']]) ? $kantin_data[$row['id_kantin']] : 'Kantin Tidak Diketahui';
                    

            echo "<div class='bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow'>";
            echo  "<div class='aspect-w-16 aspect-h-9 w-full'>";
            echo "<img alt='Image of " . htmlspecialchars($row['nama_menu']) . "' class='w-full h-48 object-cover' src= '" . htmlspecialchars($row['gambar_menu']) . "' />";
            echo "</div>";
            echo "<div class='p-4'>";
            echo "<h3 class='text-lg font-semibold text-gray-800'>" . htmlspecialchars($row['nama_menu']) ."</h3>";
            echo "<p class='text-emerald-600 font-bold mt-2'>Rp " . number_format($row['harga'], 0, ',', '.') . "</p>";
            echo "<p class='text-gray-600 mt-1'>" . htmlspecialchars($nama_kantin) . "</p>";
            echo "<a href='detail_kantin.php?id_kantin=" . urlencode($row['id_kantin']) . "' class='w-full mt-4 bg-emerald-600 text-white py-2 px-4 rounded-lg hover:bg-emerald-700 transition-colors'>Lihat Kantin";
            echo "</a>";
            echo "</div>";
            echo "</div>";
                }
            } else {
                echo "<p class='text-center'>Tidak ada menu makanan yang tersedia untuk kategori ini.</p>";
            }
            ?>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-600">
            <p>UnandEats - Temukan pengalaman kuliner terbaik Anda!</p>
        </div>
    </div>
</body>
</html>