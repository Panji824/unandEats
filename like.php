<?php
session_start();
require 'function.php';

// Pastikan pengguna login
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'user') {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}

$id_user = $_SESSION['id_user'];

// Ambil data favorit dari database
$stmt = $conn->prepare("
    SELECT kantin.id_kantin, kantin.nama_kantin, kantin.deskripsi
    FROM favorit
    JOIN kantin ON favorit.id_kantin = kantin.id_kantin
    WHERE favorit.id_user = ?
");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantin Favorit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-white min-h-screen">
<div class="container mx-auto px-6 py-3" style="max-width: 750px;">
        <h1 class="text-3xl font-bold text-center text-green-700 mb-6">
            <i class="fas fa-heart mr-2"></i>Kantin Favorit Saya
        </h1>

        <a onclick="history.back()" class="px-4 py-2 bg-white text-green-700 font-medium rounded-lg shadow-md hover:bg-gray-200 focus:ring-4 focus:ring-green-300 focus:outline-none transition duration-300" href="javascript:history.back()">
            <i class="fas fa-arrow-left mr-2">
            </i>
            Kembali
        </a>
        <br>
        <br>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($row = $result->fetch_assoc()): ?>
              <div class="bg-white border border-green-100 rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
                <img src="images/kantin<?= htmlspecialchars($row['id_kantin']); ?>.png" alt="<?= htmlspecialchars($row['nama_kantin']); ?>  ">
                <div class="p-4">
                    <h2 class="text-xl font-bold text-green-700 mb-2"><?= htmlspecialchars($row['nama_kantin']); ?></h2>
                    <p class="text-gray-600"><?= htmlspecialchars($row['deskripsi']); ?></p>
                    <br>
                    <a href="detail_kantin.php?id_kantin=<?= htmlspecialchars($row['id_kantin']); ?>"  class="px-4 py-2 bg-green-500 text-white font-medium rounded-lg shadow-md hover:bg-green-600 focus:ring-4 focus:ring-green-300 focus:outline-none transition duration-300"
                    >detail</a>
                </div>
               

            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
