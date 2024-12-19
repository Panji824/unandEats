<?php
require 'function.php';

// Pastikan idKantin ada di session
if (!isset($_SESSION['log']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['id_kantin']) || empty($_SESSION['id_kantin'])) {
    die("ID Kantin tidak ditemukan di session.");
}


// Ambil idKantin dari session admin
$id_kantin = $_SESSION['id_kantin']; 

// Variabel untuk feedback dan menu items
$menuItems = [];
$feedback = "";

// Proses penambahan menu makanan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_menu = trim($_POST['nama_menu']);
    $harga = trim($_POST['harga']);
    $deskripsi = trim($_POST['deskripsi']);
    $kategori = trim($_POST['kategori']); 
    $id_kantin = $_POST['id_kantin'];

    // Menangani file upload
    $target_dir = "images/menu"; // Pastikan folder ini ada dan dapat ditulis
    $file_name = basename($_FILES["gambar_menu"]["name"]);
    $file_name = preg_replace("/[^a-zA-Z0-9._-]/", "_", $file_name); // Sanitasi nama file

    // Membuat nama file baru berdasarkan format kategori(id_kantin)_increment
    $increment = 1;
    $new_file_name = "{$kategori}{$id_kantin}_{$increment}." . pathinfo($file_name, PATHINFO_EXTENSION);
    while (file_exists($target_dir . '/' . $new_file_name)) {
        $increment++;
        $new_file_name = "{$kategori}{$id_kantin}_{$increment}." . pathinfo($file_name, PATHINFO_EXTENSION);
    }
    $target_file = $target_dir . '/' . $new_file_name;

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file yang diupload adalah gambar


    if ($uploadOk) {
        if (move_uploaded_file($_FILES["gambar_menu"]["tmp_name"], $target_file)) {
            // Masukkan data menu ke database
            $stmt = $conn->prepare(
                "INSERT INTO menu_makanan (id_kantin, nama_menu, harga, deskripsi, kategori, gambar_menu) 
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("isssss", $id_kantin, $nama_menu, $harga, $deskripsi, $kategori, $target_file);

            if ($stmt->execute()) {
                $feedback = "Menu baru berhasil ditambahkan.";
            } else {
                $feedback = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $feedback = "Terjadi kesalahan saat mengupload file.";
        }
    }
}


$i = 1;

// Fungsi untuk mengupdate menu
if (isset($_POST['updateMenu'])) {
    $id_menu = $_POST['id_menu'];
    $nama_menu = trim(htmlspecialchars($_POST['nama_menu']));
    $harga= trim(htmlspecialchars($_POST['harga']));
    $deskripsi = trim(htmlspecialchars($_POST['deskripsi']));
    $kategori = trim(htmlspecialchars($_POST['kategori']));

    // Handle upload gambar
    $target_dir = "images/menu"; // Pastikan folder ini ada dan dapat ditulis
    $gambar_menu = $_FILES['gambar_menu']['name'];
    $tmpGambar = $_FILES['gambar_menu']['tmp_name'];
    $new_file_name = "";

    if ($gambarMenu) {
        $file_name = basename($gambar_menu);
        $file_name = preg_replace("/[^a-zA-Z0-9._-]/", "_", $file_name); // Sanitasi nama file
        
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_extension, $allowed_extensions)) {
            echo "<script>alert('Format file tidak didukung.');</script>";
            exit;
        }

        // Membuat nama file baru berdasarkan kategori dan increment
        $increment = 1;
        $new_file_name = "{$kategori}{$id_kantin}_{$increment}.{$file_extension}";
        while (file_exists($target_dir . '/' . $new_file_name)) {
            $increment++;
            $new_file_name = "{$kategori}{$id_kantin}_{$increment}.{$file_extension}";
        }
        $target_file = $target_dir . '/' . $new_file_name;

        if (move_uploaded_file($tmpGambar, $target_file)) {
            $query = $conn->prepare("UPDATE menu_makanan SET nama_menu=?, harga=?, deskripsi=?, kategori=?, gambar_menu=? WHERE id_menu=?");
            $query->bind_param("sssssi", $nama_menu, $harga, $deskripsi, $kategori, $new_file_name, $id_menu);
        } else {
            echo "<script>alert('Gagal mengupload gambar.');</script>";
            exit;
        }
    } else {
        $query = $conn->prepare("UPDATE menu_makanan SET nama_menu=?, harga=?, deskripsi=?, kategori=? WHERE id_menu=?");
        $query->bind_param("ssssi", $nama_menu, $harga, $deskripsi, $kategori, $id_menu);
    }

    $query->execute();
    header("Location: admin.php");
}

// Fungsi untuk menghapus menu
if (isset($_POST['deleteMenu'])) {
    $id_menu = $_POST['id_menu'];

    // Menghapus file gambar jika ada
    $getImageQuery = $conn->prepare("SELECT gambar_menu FROM menu_makanan WHERE id_menu=?");
    $getImageQuery->bind_param("i", $id_menu);
    $getImageQuery->execute();
    $result = $getImageQuery->get_result();
    $data = $result->fetch_assoc();

    if ($data && $data['gambar_menu']) {
        $image_path = "images/menu/" . $data['gambar_menu'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    $query = $conn->prepare("DELETE FROM menu_makanan WHERE id_menu=?");
    $query->bind_param("i", $id_menu);
    $query->execute();
    header("Location: admin.php");
}


// Ambil daftar menu untuk kantin yang sesuai
$stmt = $conn->prepare("SELECT * FROM menu_makanan WHERE id_kantin = ?");
$stmt->bind_param("i", $id_kantin);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Pastikan Bootstrap JS dimasukkan untuk modal -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-4xl mx-auto p-4">
    <h1 class="text-4xl font-bold text-green-700 mb-6 text-center">Kelola Menu Kantin</h1>

    <!-- Feedback message -->
    <?php if ($feedback): ?>
        <div class="mb-6 p-4 text-white bg-blue-500 rounded"> 
            <?php echo htmlspecialchars($feedback); ?>
        </div>
    <?php endif; ?>

    <!-- Form Tambah Menu -->
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <h2 class="text-2xl font-bold mb-4 text-green-700">Tambah Menu Baru</h2>
        <form action="admin.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_kantin" value="<?php echo htmlspecialchars($id_kantin); ?>">

        
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="nama_menu">Nama Makanan</label>
                <input type="text" name="nama_menu" id="nama_menu" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="harga">Harga</label>
                <input type="number" name="harga" id="harga" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="w-full p-2 border border-gray-300 rounded" rows="3" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="kategori">Kategori Menu</label>
                <select name="kategori" id="kategori" class="w-full p-2 border border-gray-300 rounded" required>
                    <option value="fastfood">FastFood</option>
                    <option value="minuman">Drink</option>
                    <option value="ayam">Ayam</option>
                    <option value="ikan">Ikan</option>
                    <option value="japanese">Japanese</option>
                    <option value="korean">Korean</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="gambar_menu">Gambar</label>
                <input type="file" name="gambar_menu" id="gambar_menu" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambah</button>
        </form>
        <br>
        <a href="logout.php"><button  class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">logout</button></a>
    </div>

    <!-- Daftar Menu -->
    <h2 class="text-3xl font-bold mb-6 text-green-700">Daftar Menu</h2>
    <table id="datatablesSimple">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Menu</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Kategori</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while($data = mysqli_fetch_array($result)) {
            $id_menu = $data['id_menu'];
            $nama_menu = $data['nama_menu'];
            $harga = $data['harga'];
            $deskripsi = $data['deskripsi'];
            $kategori = $data['kategori'];
            $gambar_menu = $data['gambar_menu'];
        ?>
        <tr>
            <td><?= $i++; ?></td>
            <td><?= $nama_menu; ?></td>
            <td><?= $deskripsi; ?></td>
            <td>Rp <?= number_format($harga, 0, ',', '.'); ?></td>
            <td><?= $kategori; ?></td>
            <td><img  
                                 class="w-16 h-16 rounded mr-4" 
                                 height="100" 
                                 src="<?=htmlspecialchars($gambar_menu) ?> "
                                 width="100" 
                                 loading="lazy">
            </td>
            <td>
                <!-- Tombol Edit -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal<?= $id_menu; ?>">
                    Edit
                </button>

                <!-- Tombol Delete -->
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?= $id_menu; ?>">
                    Hapus
                </button>
            </td>
        </tr>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal<?= $id_menu; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $id_menu; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel<?= $id_menu; ?>">Edit Menu</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_menu" value="<?= $id_menu; ?>">
                            <div class="mb-3">
                                <label for="nama_menu" class="form-label">Nama Menu</label>
                                <input type="text" name="nama_menu" value="<?= $nama_menu; ?>" placeholder="Nama menu" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Menu</label>
                                <input type="text" name="deskripsi" value="<?= $deskripsi; ?>" placeholder="Deskripsi menu" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" name="harga" value="<?= $harga; ?>" placeholder="Harga menu" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <input type="text" name="kategori" value="<?= $kategori; ?>" placeholder="Kategori menu" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="gambar_menu" class="form-label">Gambar Menu</label>
                                <input type="file" name="gambar_menu" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" name="updateMenu">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Delete -->
        <div class="modal fade" id="deleteModal<?= $id_menu; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $id_menu; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel<?= $id_menu; ?>">Hapus Menu</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus menu "<?= $nama_menu; ?>"?
                            <input type="hidden" name="id_menu" value="<?= $id_menu; ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger" name="deleteMenu">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>
    </tbody>
</table>

</div>

</body>
</html>
