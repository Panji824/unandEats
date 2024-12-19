<?php
session_start();
require 'function.php'; // Pastikan file ini mengatur koneksi database

// Cek apakah pengguna sudah login
// Cek apakah pengguna sudah login
$isLoggedIn = isset($_SESSION['log']) && $_SESSION['log'] === true && $_SESSION['role'] === 'user';
$id_kantin = isset($_GET['id_kantin']) ? intval($_GET['id_kantin']) : null;



// Jika pengguna belum login

// Ambil data kantin berdasarkan idKantin
$kantin = null;
if ($id_kantin) {
    $stmt = $conn->prepare("SELECT * FROM kantin WHERE id_kantin = ?");
    $stmt->bind_param("i", $id_kantin);
    $stmt->execute();
    $result = $stmt->get_result();
    $kantin = $result->fetch_assoc();
}




// Proses form ulasan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Mengambil data dari form
  $rating  = $_POST['rating'];
  $komentar = $_POST['komentar'];
  $id_user = $_SESSION['id_user'];

  // Menyiapkan dan mengikat
  $stmt = $conn->prepare("INSERT INTO ulasan_kantin (id_user, id_kantin, komentar, rating) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("iisi", $id_user, $id_kantin, $komentar, $rating);
  
  // Debug query
  error_log("Rating: $rating, Komentar: $komentar, ID User: $id_user, ID Kantin: $id_kantin");
  
  if ($stmt->execute()) {
      $message = "Rating dan ulasan berhasil disimpan!";
  } else {
      error_log("Error: " . $stmt->error);
      die("Error: " . $stmt->error);
  }
  // Menutup pernyataan
  $stmt->close();
}

// Ambil data menu makanan berdasarkan idKantin
if ($id_kantin) {
  $query_menu = "SELECT * FROM menu_makanan WHERE id_kantin = ?";
  $stmt_menu = $conn->prepare($query_menu);
  $stmt_menu->bind_param("i", $id_kantin);
  $stmt_menu->execute();
  $result_menu = $stmt_menu->get_result();
} else {
  die("ID kantin tidak valid.");
}

// Fetch semua data dari tabel users
$result_users = $conn->query("SELECT * FROM users");
$data_users = [];
if ($result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $data_users[$row['id_user']] = $row['username']; // Simpan dengan id_user sebagai key
    }
}

// Fetch semua data dari tabel ulasan_kantin
$result_ulasan = $conn->query("SELECT * FROM ulasan_kantin");
$data_ulasan = [];

if ($result_ulasan->num_rows > 0) {
    while ($row = $result_ulasan->fetch_assoc()) {
        // Tambahkan username dari data_users ke data ulasan
        $row['username'] = $data_users[$row['id_user']] ?? 'Unknown'; // Default jika id_user tidak ditemukan
        $data_ulasan[] = $row;
    }
}

foreach ($data_ulasan as $ulasan) { // Menggunakan $data_ulasan
    if ($ulasan['id_kantin'] == $id_kantin) {
        $filteredUlasan[] = $ulasan;
    }
}


// Menutup koneksi
mysqli_close($conn);
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>UnandEats - Canteen Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet"
    />
    <style>
      /* Custom scroll bar */
      ::-webkit-scrollbar {
        width: 8px;
      }
      ::-webkit-scrollbar-track {
        background: #f1f1f1;
      }
      ::-webkit-scrollbar-thumb {
        background: #4caf50;
        border-radius: 4px;
      }
      ::-webkit-scrollbar-thumb:hover {
        background: #45a049;
      }
    </style>
  </head>
  <body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
      <div
        class="max-w-2xl mx-auto bg-white shadow-2xl rounded-2xl overflow-hidden"
      >
        <div class="relative bg-green-600 text-white py-8 px-6">
          <button  href="index.html" onclick="history.back()"
            class="absolute top-4 left-4 text-white hover:bg-green-700 p-2 rounded-full transition duration-300"
          >
            <i class="fas fa-arrow-left text-2xl"></i>
          </button>

          <div class="flex flex-col items-center">
            <img
              src="https://storage.googleapis.com/a1aa/image/IUKf9i5Bp2XFZC1qWFFfJH3YZea5IpRPuA0jvgoLrc6tSh1nA.jpg"
              alt="Canteen Logo"
              class="w-24 h-24 object-cover rounded-full border-4 border-white mb-4 shadow-lg"
            />

            <h1 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($kantin['nama_kantin']); ?></h1>
            <p class="text-green-100 text-center mb-4"><?php echo htmlspecialchars($kantin['deskripsi']); ?></p>

            <div class="flex items-center space-x-4">
              <div class="flex items-center">
                <i class="fas fa-star text-yellow-300 mr-2"></i>
                <span class="font-semibold"><?php echo htmlspecialchars($kantin['rating']); ?>/5</span>
              </div>
              <a
                href="#"
                class="text-white underline hover:text-green-200 transition"
              >
                Lihat Lokasi Di Google Maps
              </a>
            </div>
          </div>
        </div>

        <div class="p-6">
          <h2 class="text-2xl font-bold text-center text-green-700 mb-6">
            Daftar Menu
          </h2>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Menu Item Template -->
            <?php if ($result_menu && mysqli_num_rows($result_menu) > 0): ?>
                <?php while ($makanan = mysqli_fetch_assoc($result_menu)): ?>
                <div class="bg-white border border-green-100 rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
                    <img
                        src="<?= htmlspecialchars($makanan['gambar_menu']); ?>"
                        class="w-full h-48 object-cover"
                    />
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-800">
                        <?= htmlspecialchars($makanan['nama_menu']); ?>
                        </h3>
                        <p class="text-green-600 font-bold text-xl">
                            Rp <?= number_format($makanan['harga'], 0, ',', '.'); ?>
                        </p>
                    </div>
                </div>
            <!-- End Menu Item -->
                <?php endwhile; ?>
                <?php else: ?>
                    <p>Tidak ada makanan tersedia untuk kantin ini.</p>
                <?php endif; ?>
            </div>

          <div class="mt-10">
            <h2 class="text-2xl font-bold text-center text-green-700 mb-6">
              Beri Rating Dan Ulasan
            </h2>

            <!-- Login Required Message -->
          <!-- Login Required Message -->
          <?php if ($isLoggedIn): ?>
            <form
                action="detail_kantin.php?id_kantin=<?= $id_kantin; ?>"
                method="post"
                class="space-y-6"
            >
                <input type="hidden" name="id_kantin" value="<?= $id_kantin; ?>" />

                <div>
                    <label for="rating" class="block text-gray-700 font-semibold mb-2">Rating Anda:</label>
                    <select name="rating" id="rating" class="w-full px-4 py-2 border rounded-lg">
                        <option value="5">5 - Sangat Bagus</option>
                        <option value="4">4 - Bagus</option>
                        <option value="3">3 - Cukup</option>
                        <option value="2">2 - Kurang</option>
                        <option value="1">1 - Sangat Kurang</option>
                    </select>
                </div>

                <div>
                    <label for="komentar" class="block text-gray-700 font-semibold mb-2">Ulasan Anda:</label>
                    <textarea name="komentar" id="komentar" rows="4" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg">Kirim Ulasan</button>
                </div>
            </form>
        <?php else: ?>
            <div class="bg-red-50 border p-4 text-center">
                <p class="text-red-600">
                    Anda harus <a href="login.php" class="font-bold underline">login</a> untuk memberikan ulasan.
                </p>
            </div>
        <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
    <div class="container mx-auto px-4 py-8">
      <div
        class="max-w-2xl mx-auto bg-white shadow-2xl rounded-2xl overflow-hidden"
      >
        <!-- Previous content remains the same -->

        <!-- New Reviews Section -->
        <div class="p-6 bg-gray-50 border-t border-gray-200">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-green-700">Ulasan Pengguna</h2>
            <button
              id="toggleReviewsBtn"
              class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-300"
            >
              Lihat Semua Ulasan
            </button>
          </div>
        
          
        
          <!-- Section untuk menampilkan ulasan -->
<div id="allReviewsSection" class="hidden space-y-4">
    <!-- Review Item Template -->
    <?php if (!empty($filteredUlasan)): ?>
        <?php foreach ($filteredUlasan as $ulasan): ?>
            <div class="bg-gray-100 p-4 rounded-lg">
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center">
                        <img
                            src="path/to/user/avatar.jpg"
                            alt="User Avatar"
                            class="w-10 h-10 rounded-full mr-3"
                        />
                        <p class="font-semibold text-gray-800"><?= htmlspecialchars($ulasan['username']); ?></p>
                    </div>
                    <div class="flex text-yellow-500">
                        <!-- Dynamic star rating -->
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= floor($ulasan['rating'])): ?>
                                <i class="fas fa-star"></i>
                            <?php elseif ($i - $ulasan['rating'] < 1): ?>
                                <i class="fas fa-star-half-alt"></i>
                            <?php else: ?>
                                <i class="far fa-star"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <span class="text-gray-600 ml-2"><?= htmlspecialchars($ulasan['created_at']); ?></span>
                    </div>
                </div>
                <p class="text-gray-700"><?= htmlspecialchars($ulasan['komentar']); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-gray-600">Belum ada ulasan untuk kantin ini.</p>
    <?php endif; ?>
</div>

    <script>
       // Toggle reviews section functionality
  const toggleReviewsBtn = document.getElementById("toggleReviewsBtn");
  const allReviewsSection = document.getElementById("allReviewsSection");

  toggleReviewsBtn.addEventListener("click", () => {
    // Toggle hidden class
    allReviewsSection.classList.toggle("hidden");

    // Change button text based on section visibility
    if (allReviewsSection.classList.contains("hidden")) {
      toggleReviewsBtn.textContent = "Lihat Semua Ulasan";
    } else {
      toggleReviewsBtn.textContent = "Sembunyikan Ulasan";
    }
  });
    </script>
  </body>
</html>