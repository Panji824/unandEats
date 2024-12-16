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
?>



<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Fast Food
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
 </head>
 <body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="w-full max-w-4xl p-4">
   <h1 class="text-3xl font-bold text-center mb-6">
    Fast Food
   </h1>
   <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
   <?php 
if ($result_menu && mysqli_num_rows($result_menu) > 0) {
    while ($row = mysqli_fetch_assoc($result_menu)) {
        $nama_kantin = isset($kantin_data[$row['id_kantin']]) ? $kantin_data[$row['id_kantin']] : 'Kantin Tidak Diketahui';
        
        // Tampilkan data menu makanan yang sesuai dengan kategori
        echo "<div class='bg-white p-4 rounded-lg shadow-md flex flex-col items-center'>";
        echo "<img alt='" . htmlspecialchars($row['nama_menu']) . "' class='mb-2' height='50' src= '" . htmlspecialchars($row['gambar_menu']) . "' />";
        echo "<h2 class='text-lg font-bold'>" . htmlspecialchars($row['nama_menu']) . "</h2>";
        echo "<p class='text-red-500'>Rp " . number_format($row['harga'], 0, ',', '.') . "</p>";
        echo "<p class='text-gray-500'>" . htmlspecialchars($nama_kantin) . "</p>";
        echo "<a href='detail_kantin.php?id_kantin=" . urlencode($row['id_kantin']) . "' class='mt-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600'>Lihat Kantin</a>";
        echo "</div>";
    }
} else {
    echo "<p>Tidak ada menu makanan yang tersedia untuk kategori ini.</p>";
}
?>
   <div class="flex justify-center space-x-4">
    <button class="bg-gray-500 text-white px-4 py-2 rounded-lg" onclick="history.back()">
     Back
    </button>

   </div>
  </div>
 </body>
</html>