// Mengelola Menu Navbar
const menu = document.querySelector("#menu-bars");
const navbar = document.querySelector(".navbar");

menu.onclick = () => {
  menu.classList.toggle("fa-times");
  navbar.classList.toggle("active");
};

window.onscroll = () => {
  menu.classList.remove("fa-times");
  navbar.classList.remove("active");
};

// Mengelola Search Form
const searchIcon = document.querySelector("#search-icon");
const searchForm = document.querySelector("#search-form");
const closeIcon = document.querySelector("#close");

searchIcon.onclick = () => searchForm.classList.toggle("active");
closeIcon.onclick = () => searchForm.classList.remove("active");

// Inisialisasi Swiper Slider
const swiper = new Swiper(".home-slider", {
  spaceBetween: 30,
  centeredSlides: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  loop: true,
});

// Navigasi Scroll dan Highlight Aktif
document.addEventListener("DOMContentLoaded", () => {
  const navbarLinks = document.querySelectorAll(".navbar a");
  const sections = document.querySelectorAll("section");

  const changeActiveLink = () => {
    let currentSection = sections[0];

    sections.forEach((section) => {
      const rect = section.getBoundingClientRect();
      if (rect.top <= window.innerHeight / 2 && rect.bottom > window.innerHeight / 2) {
        currentSection = section;
      }
    });

    navbarLinks.forEach((link) => link.classList.remove("active"));
    const activeLink = document.querySelector(`.navbar a[href="#${currentSection.id}"]`);
    if (activeLink) activeLink.classList.add("active");
  };

  window.addEventListener("scroll", changeActiveLink);

  navbarLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const targetId = link.getAttribute("href").substring(1);
      document.getElementById(targetId).scrollIntoView({
        behavior: "smooth",
      });
    });
  });
});

// Mengelola Form Login/Registrasi
const userIcon = document.querySelector(".fas.fa-user");
const authSection = document.getElementById("auth");
const closeAuth = document.getElementById("close-auth");

userIcon.addEventListener("click", () => {
  authSection.style.display = "flex";
});

closeAuth.addEventListener("click", () => {
  authSection.style.display = "none";
});

// Mengelola Detail Kantin
const detailsSection = document.getElementById("kantin-details");
const closeDetails = document.getElementById("close-details");

// Data Kantin
const kantinData = {
  "Kantin Bunda": {
    rating: "4.5/5",
    reviews: "Sangat enak! Pelayanan cepat dan ramah.",
    menu: ["Nasi Goreng", "Ayam Penyet", "Mie Goreng"],
    address: "https://www.google.com/maps/place/Kantin+A",
  },
  "Kantin Nice": {
    rating: "4.0/5",
    reviews: "Makanan lezat, harga terjangkau.",
    menu: ["Sate Ayam", "Rendang", "Es Teh"],
    address: "https://www.google.com/maps/place/Kantin+B",
  },
};

// Menangani Klik Tombol "Details"
document.querySelectorAll(".btn").forEach((button) => {
  button.addEventListener("click", (event) => {
    event.preventDefault(); // Mencegah aksi default (menghindari scroll ke bagian atas)
    const kantinName = event.target.closest(".box").querySelector("h3").innerText;
    showKantinDetails(kantinName);
  });
});

// Menampilkan Detail Kantin
function showKantinDetails(kantinName) {
  const kantin = kantinData[kantinName];
  if (kantin) {
    document.getElementById("kantin-name").innerText = kantinName;
    document.getElementById("kantin-rating").innerText = kantin.rating;
    document.getElementById("kantin-reviews").innerText = kantin.reviews;

    const menuContainer = document.getElementById("kantin-menu");
    menuContainer.innerHTML = "";
    kantin.menu.forEach((item) => {
      const menuItem = document.createElement("div");
      menuItem.className = "menu-item";
      menuItem.innerText = item;
      menuContainer.appendChild(menuItem);
    });

    document.getElementById("kantin-address").href = kantin.address;
    detailsSection.style.display = "flex";
  }
}

// Menutup Detail Kantin
closeDetails.addEventListener("click", () => {
  detailsSection.style.display = "none";
});

document.addEventListener("DOMContentLoaded", function () {
  const detailsButton = document.getElementById("details-button"); // Ganti dengan ID tombol yang sesuai
  const kantinDetails = document.querySelector(".kantin-details"); // Ganti dengan selector yang sesuai

  detailsButton.addEventListener("click", function (event) {
    event.preventDefault(); // Mencegah aksi default
    kantinDetails.style.display = "flex"; // Tampilkan detail kantin
  });

  // Optional: Close the details when clicking outside of the details container
  kantinDetails.addEventListener("click", function (event) {
    if (event.target === kantinDetails) {
      kantinDetails.style.display = "none"; // Sembunyikan detail kantin
    }
  });
});

const cuisineData = {
  "Fast Food": [
    { name: "Burger", kantin: "Kantin A" },
    { name: "Fries", kantin: "Kantin B" },
    { name: "Hot Dog", kantin: "Kantin C" },
  ],
  Korean: [
    { name: "Kimchi", kantin: "Kantin D" },
    { name: "Bibimbap", kantin: "Kantin E" },
  ],
  Japanese: [
    { name: "Sushi", kantin: "Kantin F" },
    { name: "Ramen", kantin: "Kantin A" },
  ],
  // Tambahkan jenis cuisine dan menu lainnya sesuai kebutuhan
};

// Data untuk menu berdasarkan jenis cuisine
const cuisineMenuData = {
  "Fast Food": [
    { name: "Burger", price: "Rp 15.000", kantin: "Kantin Bunda" },
    { name: "Fries", price: "Rp 10.000", kantin: "Kantin Bunda" },
    { name: "Hot Dog", price: "Rp 12.000", kantin: "Kantin Nice" },
  ],
  Korean: [
    { name: "Kimchi", price: "Rp 20.000", kantin: "Kantin Bunda" },
    { name: "Bibimbap", price: "Rp 25.000", kantin: "Kantin Nice" },
  ],
  Japanese: [
    { name: "Sushi", price: "Rp 30.000", kantin: "Kantin Nice" },
    { name: "Ramen", price: "Rp 28.000", kantin: "Kantin Bunda" },
  ],
  // Tambahkan jenis cuisine dan menu lainnya sesuai kebutuhan
};

// Menangani Klik pada List of Cuisine
document.querySelectorAll(".cuisine .box").forEach((box) => {
  box.addEventListener("click", (event) => {
    const cuisineName = box.querySelector("h3").innerText;
    showCuisineDetails(cuisineName);
  });
});

// Menampilkan Detail Cuisine
function showCuisineDetails(cuisineName) {
  const menuContainer = document.getElementById("cuisine-menu");
  menuContainer.innerHTML = ""; // Kosongkan kontainer menu sebelumnya

  const menuItems = cuisineMenuData[cuisineName];
  if (menuItems) {
    menuItems.forEach((item) => {
      const menuItem = document.createElement("div");
      menuItem.className = "menu-item";
      menuItem.innerText = `${item.name} - ${item.price} dari ${item.kantin}`; // Menampilkan nama menu, harga, dan kantin
      menuContainer.appendChild(menuItem);
    });
  }

  document.getElementById("cuisine-name").innerText = cuisineName; // Tampilkan nama cuisine
  document.getElementById("cuisine-details").style.display = "flex"; // Tampilkan detail cuisine
}

// Menutup Detail Cuisine
document.getElementById("close-cuisine-details").addEventListener("click", () => {
  document.getElementById("cuisine-details").style.display = "none"; // Sembunyikan detail cuisine
});

// Data untuk rekomendasi menu
const recommendationData = [
  {
    name: "Ayam Bakar",
    price: "Rp 25.000",
    kantin: "Kantin Bunda",
    rating: 4.5,
    reviews: "Ayam bakar dengan bumbu rempah khas yang meresap hingga ke tulang, nikmat di setiap gigitan.",
  },
  {
    name: "Sate",
    price: "Rp 20.000",
    kantin: "Kantin Nice",
    rating: 4.0,
    reviews: "Sate pilihan dengan bumbu kacang autentik, sempurna untuk melengkapi harimu.",
  },
  // Tambahkan menu rekomendasi lainnya sesuai kebutuhan
];

// // Menangani Klik pada Rekomendasi
document.querySelectorAll(".rekomendasi-box .btn").forEach((button, index) => {
  button.addEventListener("click", (event) => {
    event.preventDefault(); // Mencegah aksi default
    showRecommendationDetails(index);
  });
});

// Menampilkan Detail Rekomendasi
function showRecommendationDetails(index) {
  const recommendation = recommendationData[index];
  document.getElementById("recommendation-name").innerText = recommendation.name;
  document.getElementById("recommendation-kantin").innerText = `Dari: ${recommendation.kantin}`;
  document.getElementById("recommendation-rating").innerText = `${recommendation.rating}/5`;

  // Menampilkan rating bintang
  const starsContainer = document.getElementById("recommendation-stars");
  starsContainer.innerHTML = ""; // Kosongkan sebelumnya
  for (let i = 0; i < Math.floor(recommendation.rating); i++) {
    starsContainer.innerHTML += '<i class="fas fa-star" style="color: gold;"></i>'; // Bintang penuh
  }
  if (recommendation.rating % 1 !== 0) {
    starsContainer.innerHTML += '<i class="fas fa-star-half-alt" style="color: gold;"></i>'; // Bintang setengah
  }

  document.getElementById("recommendation-reviews").innerText = recommendation.reviews;

  document.getElementById("recommendation-details").style.display = "flex"; // Tampilkan detail rekomendasi
}

// Menutup Detail Rekomendasi
document.getElementById("close-recommendation-details").addEventListener("click", () => {
  document.getElementById("recommendation-details").style.display = "none"; // Sembunyikan detail rekomendasi
});
