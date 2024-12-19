<?php
require 'function.php'; // Pastikan file koneksi database tersedia


if (!isset($_SESSION['log']) || $_SESSION['role'] != 'super_admin') {
    header("Location: login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form dan lakukan validasi
    $id_kantin = isset($_POST['canteen']) ? intval($_POST['canteen']) : null;
    $menu_name = isset($_POST['menu_name']) ? trim($_POST['menu_name']) : null;
    $description = isset($_POST['description']) ? trim($_POST['description']) : null;

    // Validasi input
    if (empty($id_kantin) || empty($menu_name) || empty($description)) {
        $error_message = "Semua kolom wajib diisi!";
    } else {
        // Query untuk menambahkan menu ke tabel `menu_makanan`
        $query = "INSERT INTO menu_makanan (id_kantin, nama_menu, deskripsi) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $id_kantin, $menu_name, $description);

        if ($stmt->execute()) {
            $success_message = "Menu berhasil ditambahkan!";
        } else {
            $error_message = "Terjadi kesalahan saat menambahkan menu.";
        }
        $stmt->close();
    }
}

// Ambil data kantin untuk dropdown
$query_kantin = "SELECT id_kantin, nama_kantin FROM kantin";
$result_kantin = mysqli_query($conn, $query_kantin);
$kantins = [];
if ($result_kantin) {
    while ($row = mysqli_fetch_assoc($result_kantin)) {
        $kantins[] = $row;
    }
}

mysqli_close($conn);
?>
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-xl font-bold mb-4">Add Menu to Display</h2>

    <!-- Pesan Error atau Sukses -->
    <?php if (!empty($error_message)): ?>
        <div class="mb-4 p-4 bg-red-200 text-red-800 rounded-lg">
            <?= htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($success_message)): ?>
        <div class="mb-4 p-4 bg-green-200 text-green-800 rounded-lg">
            <?= htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-4">
            <label for="canteen" class="block text-gray-700 font-medium mb-2">Select Canteen</label>
            <select id="canteen" name="canteen" class="block w-full bg-gray-100 border border-gray-300 rounded-lg p-2" required>
                <option value="">Select Canteen</option>
                <?php foreach ($kantins as $kantin): ?>
                    <option value="<?= htmlspecialchars($kantin['id_kantin']); ?>">
                        <?= htmlspecialchars($kantin['nama_kantin']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="menu_name" class="block text-gray-700 font-medium mb-2">Menu Name</label>
            <input type="text" id="menu_name" name="menu_name" class="block w-full bg-gray-100 border border-gray-300 rounded-lg p-2" placeholder="Enter menu name" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea id="description" name="description" class="block w-full bg-gray-100 border border-gray-300 rounded-lg p-2" placeholder="Enter menu description" required></textarea>
        </div>
        <button type="submit" class="bg-moss-green text-white px-4 py-2 rounded-lg hover:bg-green-700">Add Menu</button>
    </form>
</div>
