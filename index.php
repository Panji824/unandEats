<?php
require 'function.php'; // Pastikan file ini mengatur koneksi database

// Cek apakah pengguna sudah login
$isLoggedIn = isset($_SESSION['log']) && $_SESSION['role'] === 'user';


?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>UnandEats</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <!-- Header Section -->
    <header>
      <a href="index.html" class="logo"
        ><i class="fas fa-utensils"></i>UnandEats</a
      >
      <nav class="navbar">
        <a class="active" href="#home">Home</a>
        <a href="#rekomendasi">Recommendation</a>
      </nav>
      <div class="icons">
        <i class="fas fa-bars" id="menu-bars"></i>
        <i class="fas fa-search" id="search-icon"></i>
        <a href="likes.php" class="fas fa-heart"></a>
        <?php
        if ($isLoggedIn) { // Check if user is logged in
            echo '<a href="logout.php" class="fas fa-user"></a>'; // Link to logout
        } else {
            echo '<a href="login.php" class="fas fa-user"></a>'; // Link to login
        }
        
        ?>
      </div>
    </header>

    <!-- Search Form -->
    <form action="" id="search-form">
      <input type="search" placeholder="search here..." id="search-box" />
      <label for="search-box" class="fas fa-search"></label>
      <i class="fas fa-times" id="close"></i>
    </form>

    <!-- Home Section -->
    <section class="home" id="home">
      <div class="swiper-container home-slider">
        <div class="swiper-wrapper">
          <div class="swiper-slide slide">
            <div class="content">
              <span>Discover the Taste of Perfection!</span>
              <h3>Rice Bowl</h3>
              <p>
                Savor every bite of our signature Rice Bowls, crafted to satisfy
                your cravings. A culinary experience awaits!
              </p>
              <a href="#" class="btn details-btn" data-index="0">Details</a>
            </div>
            <div class="image">
              <img src="images/1.png" alt="" />
            </div>
          </div>
          <div class="swiper-slide slide">
            <div class="content">
              <span>Spice Up Your Day!</span>
              <h3>Authentic Seblak Flavors</h3>
              <p>
                Indulge in the fiery and savory delight of Seblak, made to
                tantalize your taste buds!
              </p>
              <a href="#" class="btn details-btn" data-index="1">Details</a>
            </div>
            <div class="image">
              <img src="images/2.png" alt="" />
            </div>
          </div>
          <div class="swiper-slide slide">
            <div class="content">
              <span>Noodle Lovers, Assemble!</span>
              <h3>Authentic Noodle Creations</h3>
              <p>
                Experience the perfect harmony of flavors in every strand. Our
                noodles are crafted to satisfy your hunger and soul!
              </p>
              <a href="#" class="btn details-btn" data-index="2">Details</a>
            </div>
            <div class="image">
              <img src="images/3.png" alt="" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Modal untuk Menampilkan Detail Menu pada Home-->
    <div
      class="menu-details-modal"
      id="menu-details-modal"
      style="display: none"
    >
      <div class="modal-content">
        <!-- Tombol untuk menutup modal -->
        <button class="close-modal" id="close-menu-details">
          <i class="fas fa-times"></i>
        </button>

        <!-- Konten Modal -->
        <div class="modal-header">
          <h2 id="menu-title">Menu Name</h2>
        </div>
        <div class="modal-body">
          <img
            id="menu-image"
            src="images/default.png"
            alt="Menu Image"
            class="menu-image"
          />
          <p id="menu-description">
            Discover the flavors of this amazing dish! Perfect for any occasion
            and guaranteed to satisfy your taste buds.
          </p>
          <span id="menu-price" class="menu-price">Price: Rp 25.000</span>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn order-now" id="">Details</a>
        </div>
      </div>
    </div>

    <!-- Kantin Section -->
    <section class="kantin" id="kantin">
      <h3 class="sub-heading">List of Kantin</h3>
      <h1 class="heading">Popular Kantin at Unand</h1>
      <div class="box-container">
      <?php
    // Menghubungkan ke database
    include 'function.php';

    // Ambil data kantin dari database
    $query = "SELECT * FROM kantin";
    $result = mysqli_query($conn, $query);

    // Loop melalui setiap kantin dan tampilkan di HTML
    if ($result && mysqli_num_rows($result) > 0) {
        while ($kantin = mysqli_fetch_assoc($result)) {
            ?>
            <div class="box">
              <a href="#" class="fas fa-heart"></a>
              <a
                href="<?= htmlspecialchars($kantin['lokasi']); ?>"
                target="_blank"
                class="fas fa-location-arrow"
                title="View location on Google Maps"
              ></a>
              <img src="images/kantin<?= htmlspecialchars($kantin['id_kantin']); ?>.png" alt="Kantin <?= htmlspecialchars($kantin['nama_kantin']); ?>" />
              <h3><?= htmlspecialchars($kantin['nama_kantin']); ?></h3>
              <div class="stars">
                <?php
                // Tampilkan rating dengan bintang
                $rating = round($kantin['rating']);
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $rating) {
                        echo '<i class="fas fa-star"></i>';
                    } else {
                        echo '<i class="fas fa-star-half-alt"></i>';
                    }
                }
                ?>
              </div>
              <span></span>
              <a href="detail_kantin.php?id_kantin=<?= htmlspecialchars($kantin['id_kantin']); ?>" class="btn">Details</a>
            </div>
            <?php
        }
    } else {
        echo '<p>No kantin available.</p>';
    }
    ?>
      </div>
    </section>
        <!-- Cuisine Section -->
        <section class="cuisine" id="cuisine">
        <h3 class="sub-heading">List of Cuisines</h3>
        <h1 class="heading">Explore by Cuisine</h1>
    
        <?php
        // Ambil data kategori dari database
        $query_menu = "SELECT DISTINCT kategori FROM menu_makanan"; // Mengambil kategori yang unik
        $result_menu = mysqli_query($conn, $query_menu);

        if ($result_menu && mysqli_num_rows($result_menu) > 0): ?>
            <div class="box-container">
                <?php while ($kategori = mysqli_fetch_assoc($result_menu)): ?>
                    <div class="box" onclick="window.location.href='detail_menu.php?kategori=<?= htmlspecialchars($kategori['kategori']); ?>'">
                        <img  src="images/<?= htmlspecialchars($kategori['kategori']); ?>.png" alt="<?= htmlspecialchars($kategori['kategori']); ?>" />
                        <h3><?= htmlspecialchars($kategori['kategori']); ?></h3>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center">Tidak ada kategori menu yang tersedia.</p>
        <?php endif; ?>
    </section>
    <!-- Rekomendasi Start -->
    <section class="rekomendasi" id="rekomendasi">
      <h3 class="sub-heading">Our Recommendation</h3>
      <h1 class="heading">THE BEST CHOICE FOR YOU</h1>
      <div class="rekomendasi-container">
        <div class="rekomendasi-box">
          <img src="images/rekomendasi1.png" alt="Ayam Bakar" />
          <h3>Ayam Bakar</h3>
          <p>
            Ayam bakar dengan bumbu rempah khas yang meresap hingga ke tulang,
            nikmat di setiap gigitan.
          </p>
          <span>Rp 25.000</span>
          <a href="rekomendasi.html?menu=ayam-bakar" class="btn btn-ayam-bakar"
            >Details</a
          >
        </div>
        <div class="rekomendasi-box">
          <img src="images/rekomendasi2.png" alt="Sate" />
          <h3>Sate</h3>
          <p>
            Sate pilihan dengan bumbu kacang autentik, sempurna untuk melengkapi
            harimu.
          </p>
          <span>Rp 20.000</span>
          <a href="rekomendasi.html?menu=sate" class="btn btn-sate">Details</a>
        </div>
        <div class="rekomendasi-box">
          <img src="images/rekomendasi3.png" alt="Tahu Bakar" />
          <h3>Tahu Bakar</h3>
          <p>Tahu bakar yang gurih dan lezat dengan cita rasa khas pedesaan.</p>
          <span>Rp 15.000</span>
          <a href="rekomendasi.html?menu=tahu-bakar" class="btn btn-tahu-bakar"
            >Details</a
          >
        </div>
        <div class="rekomendasi-box">
          <img src="images/rekomendasi4.png" alt="Sate Tahu Nasi" />
          <h3>Sate Tahu Nasi</h3>
          <p>
            Kombinasi sate tahu dan nasi yang lezat, cocok untuk makan siang
            cepat tapi mengenyangkan.
          </p>
          <span>Rp 22.000</span>
          <a
            href="rekomendasi.html?menu=sate-tahu-nasi"
            class="btn btn-sate-tahu-nasi"
            >Details</a
          >
        </div>
        <div class="rekomendasi-box">
          <img src="images/rekomendasi5.png" alt="Nasi Goreng" />
          <h3>Nasi Goreng</h3>
          <p>
            Nasi goreng spesial dengan campuran bumbu rahasia, pasti menggugah
            selera.
          </p>
          <span>Rp 18.000</span>
          <a
            href="rekomendasi.html?menu=nasi-goreng"
            class="btn btn-nasi-goreng"
            >Details</a
          >
        </div>
        <div class="rekomendasi-box">
          <img src="images/rekomendasi6.png" alt="Mie Rebus" />
          <h3>Mie Rebus</h3>
          <p>
            Mie rebus hangat dengan topping melimpah, pilihan sempurna untuk
            malam dingin.
          </p>
          <span>Rp 16.000</span>
          <a href="rekomendasi.html?menu=mie-rebus" class="btn btn-mie-rebus"
            >Details</a
          >
        </div>
        <div class="rekomendasi-box">
          <img src="images/rekomendasi7.png" alt="Nasi Goreng Ayam" />
          <h3>Nasi Goreng Ayam</h3>
          <p>
            Nasi goreng ayam spesial dengan potongan ayam yang juicy dan penuh
            rasa.
          </p>
          <span>Rp 20.000</span>
          <a
            href="rekomendasi.html?menu=nasi-goreng-ayam"
            class="btn btn-nasi-goreng-ayam"
            >Details</a
          >
        </div>
        <div class="rekomendasi-box">
          <img src="images/rekomendasi8.png" alt="Nasi Goreng Jagung" />
          <h3>Nasi Goreng Jagung</h3>
          <p>
            Nasi goreng unik dengan manisnya jagung segar, kombinasi yang pas di
            lidah.
          </p>
          <span>Rp 19.000</span>
          <a
            href="rekomendasi.html?menu=nasi-goreng-jagung"
            class="btn btn-nasi-goreng-jagung"
            >Details</a
          >
        </div>
      </div>
    </section>

    <!-- modal rekomendasi -->
    <!-- Modal untuk Menampilkan Detail Menu -->
    <!-- modal rekomendasi -->

    <!-- About Section -->
    <section class="about">
      <a href="index.html" class="logo"
        ><i class="fas fa-utensils"></i>UnandEats</a
      >
      <p class="about-description">
        Kami adalah platform yang menghubungkan Anda dengan berbagai pilihan
        kantin terbaik. Temukan makanan lezat dan pengalaman kuliner yang tak
        terlupakan.
      </p>
    </section>

    <!-- cdn link -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- js link -->
    <script src="js/script.js"></script>
  </body>
</html>
