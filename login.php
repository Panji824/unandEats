<?php
session_start(); // Start the session
require 'function.php'; // Include your database connection

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; // This will be ignored in the login process

    // Check if the email exists in the admins table
    $cekAdmin = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email' AND password='$password'");
    
    if (mysqli_num_rows($cekAdmin) > 0) {
        $data = mysqli_fetch_assoc($cekAdmin);
        
        // Directly log in the admin without verifying the password
        $_SESSION['log'] = true;
        $_SESSION['role'] = 'admin';  // Set role to admin
        $_SESSION['id_admin'] = $data['id_admin']; // Store admin ID in session
        $_SESSION['id_kantin'] = $data['id_kantin']; // Set the kantin ID in the session
        header("Location: admin.php");  // Redirect to admin page
        exit();
    } else {
        // Check if the email exists in the users table
        $cekUser  = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");
        
        if (mysqli_num_rows($cekUser ) > 0) {
            $data = mysqli_fetch_assoc($cekUser );
            
            // Directly log in the user without verifying the password
            $_SESSION['log'] = true;
            $_SESSION['role'] = 'user';  // Set role to user
            $_SESSION['id_user'] = $data['id_user']; // Store user ID in session
            echo "<script>
            alert('Login berhasil');
            window.location.href = 'index.php';
        </script>";
        exit();
        } else {
            // Email not found in either table
            header("Location: login.php?error=Email not found");
            exit();
        }
    }
}

// Redirect to index if already logged in
if (isset($_SESSION['log'])) {
    if ($_SESSION['role'] == 'admin') {
        header('Location: admin.php');
    } else {
        header('Location: index.php');
    }
    exit();
}
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validasi jika semua field terisi
    if (empty($username) || empty($email) || empty($password)) {
        echo "<script>alert('Semua field harus diisi!');</script>";
    } else {
        // Cek apakah email sudah digunakan
        $cekEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($cekEmail) > 0) {
            echo "<script>alert('Email sudah terdaftar!');</script>";
        } else {
            // Simpan data ke database tanpa hashing password
            $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Registrasi berhasil! Silakan login.');</script>";
                header("Location: login.php");
                exit();
            } else {
                echo "<script>alert('Registrasi gagal: " . mysqli_error($conn) . "');</script>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login & Registrasi</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet"
    />
    <style>
      :root {
        --primary-color: #27ae60;
        --secondary-color: #358b49;
        --background-light: #666;
        --text-color: #333;
        --transition-speed: 0.3s;
      }

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: "Arial", sans-serif;
        background: linear-gradient(
          135deg,
          var(--primary-color),
          var(--secondary-color)
        );
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        overflow: hidden;
      }

      .container {
        background-color: white;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        width: 800px;
        max-width: 100%;
        min-height: 500px;
        position: relative;
      }

      .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
      }

      .sign-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
      }

      .sign-up-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
      }

      .container.right-panel-active .sign-in-container {
        transform: translateX(100%);
      }

      .container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
      }

      .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
      }

      .container.right-panel-active .overlay-container {
        transform: translateX(-100%);
      }

      .overlay {
        background: linear-gradient(
          to right,
          var(--secondary-color),
          var(--primary-color)
        );
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 0;
        color: white;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
      }

      .container.right-panel-active .overlay {
        transform: translateX(50%);
      }

      .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
      }

      .overlay-left {
        transform: translateX(-20%);
      }

      .overlay-right {
        right: 0;
        transform: translateX(0);
      }

      .container.right-panel-active .overlay-left {
        transform: translateX(0);
      }

      .container.right-panel-active .overlay-right {
        transform: translateX(20%);
      }

      form {
        background-color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        text-align: center;
      }

      .social {
        margin: 20px 0;
      }

      .social a {
        border: 1px solid #ddd;
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 0 5px;
        height: 40px;
        width: 40px;
        color: var(--text-color);
        transition: all var(--transition-speed) ease;
      }

      .social a:hover {
        color: var(--primary-color);
        border-color: var(--primary-color);
      }

      input {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
        border-radius: 8px;
      }

      button {
        border-radius: 20px;
        border: 1px solid var(--primary-color);
        background: linear-gradient(
          to right,
          var(--secondary-color),
          var(--primary-color)
        );
        color: white;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform var(--transition-speed) ease;
        margin-top: 20px;
        cursor: pointer;
      }

      button:hover {
        transform: scale(1.05);
      }

      button:active {
        transform: scale(0.95);
      }

      .ghost {
        background: transparent;
        border-color: white;
      }
      
    </style>
  </head>
  <body>
    <div class="container" id="container">
      <div class="form-container sign-up-container">
        <form method = "post">
          <h1>Buat Akun</h1>
          <div class="social">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-google-plus-g"></a>
            <a href="#" class="fab fa-linkedin-in"></a>
          </div>
          <span>atau gunakan email untuk registrasi</span>
          <input name = "username" type="text" placeholder="Nama" required />
          <input name = "email" type="email" placeholder="Email" required />
          <input name = "password" type="password" placeholder="Password" required />
          <button name="register" type="submit">Daftar</button>
        </form>
      </div>
      <div class="form-container sign-in-container">
        <form method = "post">
          <h1>Masuk</h1>
          <div class="social">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-google-plus-g"></a>
            <a href="#" class="fab fa-linkedin-in"></a>
          </div>
          <span>atau gunakan akun Anda</span>
          <input name= "email" type="email" placeholder="Email" required />
          <input name = "password" type="password" placeholder="Password" required />
          <a href="#">Lupa Password?</a>
          <button name = "login" type= "submit">Masuk</button>
        </form>
      </div>
      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h1>Selamat Datang Kembali!</h1>
            <p>
              Untuk tetap terhubung dengan kami, silakan login dengan akun Anda
            </p>
            <button class="ghost" id="signIn">Masuk</button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1>Halo, Teman!</h1>
            <p>Daftarkan diri Anda di UnandEats</p>
            <button class="ghost" id="signUp">Daftar</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      const signUpButton = document.getElementById("signUp");
      const signInButton = document.getElementById("signIn");
      const container = document.getElementById("container");

      signUpButton.addEventListener("click", () => {
        container.classList.add("right-panel-active");
      });

      signInButton.addEventListener("click", () => {
        container.classList.remove("right-panel-active");
      });
    </script>
  </body>
</html>
