<?php
session_start();

$isLoggedIn = isset($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerobok Rezeki</title>
    <link rel="shortcut icon" href="logouitm.png" type="image/svg+xml">
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/moon.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
<div class="logo-container">
        <img src="image/logo.jpeg" alt="Logo">
        <h2 class="logo">Bakul Rezeki</h2>
    </div>

    
    <div class="header-controls">
        <div class="dropdown">
            <button class="dropbtn">Account</button>
            <div class="dropdown-content">
                <?php if ($isLoggedIn): ?>
                    <a href="logout.php" class="register-btn">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php" class="register-btn">Register</a>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <input type="checkbox" class="checkbox" id="checkbox">
            <label for="checkbox" class="checkbox-label">
                <i class="gg-moon"></i>
                <i class="fa fa-sun-o" style="font-size:20px"></i>
                <span class="ball"></span>
            </label>
        </div>
    </div>
</header>

    <section class="hero">
        <video class="hero-video" autoplay muted loop>
            <source src="video/bg.mp4" type="video/mp4" />
        </video>
        <div class="hero-content">
            <h1>Welcome to the Bakul Rezeki System</h1>
            <p>UiTM Student Wellfare, We Care</p>
        </div>
    </section>

    <audio id="background-music" autoplay loop>
    <source src="audio/song.mp3" type="audio/mp3">
    Your browser does not support the audio element.
</audio>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var audio = document.getElementById("background-music");

        var playPromise = audio.play();
        
        if (playPromise !== undefined) {
            playPromise.then(() => {
                console.log("Music playing.");
            }).catch(() => {
                console.log("Autoplay blocked. Enabling on first user interaction.");
                document.addEventListener("click", () => {
                    audio.play();
                }, { once: true });
            });
        }
    });
</script>




    <section class="about" id="about">

        <h1 class="heading"> <span>News</span></h1>
        <div class="slider">
          <div class="slides">
            <input type="radio" name="radio-btn" id="radio1">
            <input type="radio" name="radio-btn" id="radio2">
            <input type="radio" name="radio-btn" id="radio3">

            <div class="slide first">
              <img src="image/nasi.jpeg" alt="">
            </div>
            <div class="slide">
              <img src="image/bihun.jpeg" alt="">
            </div>
            <div class="slide">
              <img src="image/gerobokrezeki.png" alt="">
            </div>

            <div class="navigation-auto">
              <div class="auto-btn1"></div>
              <div class="auto-btn2"></div>
              <div class="auto-btn3"></div>
            </div>
          </div>

          <div class="navigation-manual">
            <label for="radio1" class="manual-btn"></label>
            <label for="radio2" class="manual-btn"></label>
            <label for="radio3" class="manual-btn"></label>
          </div>
        </div>
    
        <script type="text/javascript">
        var counter = 1;
        setInterval(function(){
          document.getElementById('radio' + counter).checked = true;
          counter++;
          if(counter > 3){
            counter = 1;
          }
        }, 5000);
        </script>
    </section>
    

    <footer>
      <div class="container">
        <div class="footer-content">
          <p>&copy; COPYRIGHT UNIVERSITI TEKNOLOGI MARA 2025. All rights reserved.</p>
          <div class="social-icons">
            <a href="https://www.instagram.com/uitm.official/"><i class="fab fa-instagram" aria-hidden="true"></i></i></a>
            <a href="https://www.facebook.com/uitmrasmi/"><i class="fab fa-facebook-square" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </footer>
    
    </script>
    <script src="java/checkbox.js"></script>
</body>
</html>