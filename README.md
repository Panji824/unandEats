# UnandEats


## Kelompok 2 RPL
### Project Team
- **Project Manager**: Aditya Aulia Rahman
- **Architect**: Abil Rahman
- **Designer**: 
  - Ebit Basri Panca Coswara  
  - Elvi Sofia Zilda  
- **Developer**:
  - Panji Wirya Pastika (Back-End)  
  - Abdalul Fikri (Front-End)  

---

## Deskripsi Proyek
UnandEats adalah sebuah platform berbasis web yang bertujuan untuk memfasilitasi mahasiswa terutama maba dalam melakukan pencarian menu yang tersedia di seluruh kantin unand. Proyek ini dikembangkan menggunakan teknologi **PHP** dan database **MySQL**.

---

## Panduan Instalasi

1. **Kloning repository**:
   ```bash
   git clone <repository-url>
   cd unandeats
   ```

2. **Import Database**:
   - Buka **phpMyAdmin**.
   - Buat database baru, `kantin_db`.
   - Import file database yang tersedia di folder `database`.

3. **Konfigurasi Koneksi Database**:
   - Pastikan file konfigurasi database (pada file `function.php`) sudah sesuai:
     ```php
     $host = "localhost";
     $username = "root"; // Sesuaikan dengan username MySQL Anda
     $password = "";     // Sesuaikan dengan password MySQL Anda
     $database = "kantin_db"; // Nama database yang diimport
     ```

4. **Akses Web**:
   - Buka browser dan akses halaman utama: `index.php`.


---

## Metode Login

Platform ini mendukung dua metode login: **User** dan **Admin**.

### Contoh Akun:
#### Login User:
- **Email**: `user1@example.com`  
- **Password**: `userpass1`  

#### Login Admin:
- **Email**: `admin_bunda@example.com`  
- **Password**: `password123`  

---


---

## Teknologi yang Digunakan
- **Bahasa Pemrograman**: PHP, HTML, CSS, JavaScript
- **Database**: MySQL
- **Tools**: phpMyAdmin, XAMPP

---

## Kontak Tim Pengembang
Jika ada pertanyaan atau permasalahan, silakan hubungi anggota tim:
- **Aditya Aulia Rahman** (Project Manager)
- **Abil Rahman** (Architect)
- **Ebit Basri Panca Coswara**, **Elvi Sofia Zilda** (Designer)
- **Panji Wirya Pastika** (Back-End Developer)
- **Abdalul Fikri** (Front-End Developer)

---

**Terima kasih telah menggunakan UnandEats!**
