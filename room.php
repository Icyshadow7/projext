
<?php
session_start();
include "db.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Available Rooms</title>
<link rel="stylesheet" href="index.css">
<style>
body { font-family: Arial, sans-serif; background-color: #f5f5f5; margin:0; padding:0; }
header { background-color: #4CAF50; color:white; text-align:center; padding:20px 0; }
.rooms-container { display:flex; flex-wrap:wrap; justify-content:center; padding:20px; }
.room-card { background:white; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.2); margin:15px; width:320px; overflow:hidden; transition:transform 0.2s; }
.room-card:hover { transform:scale(1.05); }
.room-card img { width:100%; height:200px; object-fit:cover; }
.room-info { padding:15px; }
.room-info h3 { margin:0 0 10px 0; }
.room-info p { margin:5px 0; }
.room-info .price { color:#4CAF50; font-weight:bold; }
.view-btn { display:inline-block; margin-top:10px; padding:10px 20px; background-color:#2196F3; color:white; text-decoration:none; border-radius:5px; transition:background-color 0.2s; }
.view-btn:hover { background-color:#1976D2; }
.hero {
    margin-top: 30px;
      margin-bottom: 30px;
    overflow: hidden;
    overflow-x: hidden;
    text-align: center;
    height: 200px;
    background-image: url('images/hover3.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    color: #000000;
    padding: 100px 20px;
    transition: all 2.5s;
animation: zoom 13s linear  alternate infinite;
}
@keyframes zoom{
    100%{
        
        background-image: url('images/hover1.avif');
    
        background-repeat: no-repeat;
        background-position: center;

        /* max-width: 100%; */
    }
    70%{
         
        background-image: url('images/hover2.avif');
        background-position: center;
        background-repeat: no-repeat;
      
    }
      40%{
         
        background-image: url('images/hover1.avif');
        background-position: center;
        background-repeat: no-repeat;
      
    }
       0%{
         
        background-image: url('images/hover3.avif');
        background-position: center;
        background-repeat: no-repeat;
      
    }
   
}


/* --- STYLES FOR CORE COMPONENTS (Kept from original) --- */
body { margin: 0; font-family: sans-serif; }
.navbar { display: flex; justify-content: space-between; align-items: center; padding: 15px 50px; background-color: #333; color: white; }
.navbar .logo a { color: white; text-decoration: none; font-size: 1.5em; font-weight: bold; }
.nav-links { display: flex; list-style: none; }
.nav-links ul li a{text-algin:center;
algin-item:center;}
.nav-links li a { color: white; text-decoration: none; padding: 0 15px;  }
.hero { background: url('your_hero_image.jpg') no-repeat center center/cover; height: 400px; display: flex; justify-content: center; align-items: center; text-align: center; color: white; }
.hero-text h1 { font-size: 3em; }
.hero-text p { font-size: 1.2em; margin-bottom: 20px; }
.btn { padding: 20px 30px; background-color: #b92c2cff; color: white; text-decoration: none; border-radius: 5px; }
..login-btn, .loggedin-btn { background-color: #ab2020ff; padding: 18px ; border-radius: 5px; }

/* NOTE: The padding 18px 900px on the login/logout buttons seems extremely wide. I recommend reducing the 900px to something like 20px. */
.rooms-container { display:flex; flex-wrap:wrap; justify-content:center; padding:20px; background-color: bisque; }
.room-card { background:rgb(241, 232, 232); border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.2); margin:15px; width:320px; overflow:hidden; transition:transform 0.2s; }
.room-card img { width:100%; height:200px; object-fit:cover; transition: all 1.4s; }
.room-card:hover img { transform: scale(1.1); }
.room-info { padding:15px; }
.view-btn { display:inline-block; margin-top:10px; padding:5px 20px; background-color:#b92c2cff; color:white; text-decoration:none; border-radius:5px; }
.view-btn:hover{
    background-color:#ab2020ff;
}
.footer-bottom { background-color: #333; color: white; text-align: center; padding: 15px 0;}

.attractive-btn {
            /* Text & Sizing */
            padding: 10px 35px;
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            
            /* Shape & Border */
            border: none;
            border-radius: 50px; /* Highly rounded for a modern look */
            cursor: pointer;
            
            /* Gradient Background */
            background-image: linear-gradient(135deg, #cb3011ff 100%);
            
            /* Shadow & Transition */
           
        }

        /* --- Hover Effect (The Plasma Glow) --- */
        .attractive-btn:hover {
            /* Shift the gradient slightly */
            background-image: linear-gradient(135deg, #971c1cff 100%);
            
            /* Lift the button and strengthen the shadow */
            
         
        }

        /* --- Active Effect (The Press) --- */
        .attractive-btn:active {
            transform: translateY(0);
            box-shadow: 0 5px 10px rgba(255, 88, 41, 0.3);
        }
        /* USER NAV */
.nav-user {
    position: relative;
}

/* Avatar */
.user-box {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    position: relative;
}

.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #b92c2c;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.username {
    color: white;
    font-size: 14px;
}

/* Dropdown */
.dropdown {
    position: absolute;
    top: 55px;
    right: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    display: none;
    min-width: 140px;
    z-index: 1000;
}


/* Login Button */
.login-btn {
    background: #b92c2c;
    color: white;
    padding: 10px 18px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

/* MODAL */
.login-modal {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 2000;
}

.login-box {
    background: white;
    padding: 25px;
    border-radius: 12px;
    width: 300px;
    position: relative;
    text-align: center;
}

.login-box h2 {
    margin-bottom: 15px;
}

.login-box input {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

.login-box button {
    width: 100%;
    padding: 10px;
    background: #b92c2c;
    color: white;
    border: none;
    border-radius: 6px;
}

.close {
    position: absolute;
    top: 8px;
    right: 12px;
    cursor: pointer;
    font-size: 20px;
}
.user-link {
    text-decoration: none;
    display: flex;
    align-items: center;
}

/* Avatar icon */
.avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, #b92c2c, #ff5a1f);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 16px;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(0,0,0,0.25);
}





</style>



</head>
<body>

<nav class="navbar">
    <div class="logo">
        <a href="index.php">QUICK BOOK</a>
    </div>

    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="room.php">Available Rooms</a></li>
        <li><a href="#foooter">Contact</a></li>
    </ul>

    <!-- RIGHT SIDE (LOGIN / USER) -->
   <div class="nav-user">
<?php if (!empty($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
    <!-- USER LOGGED IN (ICON ONLY) -->
    <div class="user-box">

        <!-- CLICKABLE USER ICON -->
        <a href="dashboard.php" class="user-link" title="Dashboard">
            <div class="avatar">
                <?php echo strtoupper(substr($_SESSION['fullname'], 0, 1)); ?>
            </div>
        </a>

        <!-- DROPDOWN -->
        <div class="dropdown">
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>

    </div>
<?php else: ?>
    <!-- NOT LOGGED IN -->
    <button class="login-btn" onclick="openLogin()">Login</button>
<?php endif; ?>
</div>


    <!-- LOGIN MODAL -->
<div id="loginModal" class="login-modal">
    <div class="login-box">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <span class="close" onclick="closeLogin()">×</span>
    </div>
</div>

</nav>

<div class="rooms-container" id="rooms-container">
    <!-- Room cards will be added dynamically -->
</div>


<div class="rooms-container" id="rooms-container">


<?php
$sql = "SELECT * FROM rooms";
$rooms = $conn->query($sql);

if ($rooms->num_rows > 0) {
    while ($row = $rooms->fetch_assoc()) {
?>

        <div class="room-card">
     <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['room_name']); ?>">

            <div class="room-info">
                <h3><?php echo $row['room_name']; ?></h3>
                <p><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
                <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
                <p class="price"><strong>Price:</strong> Rs. <?php echo $row['price']; ?></p>
                <a href="room_detail.php?id=<?php echo $row['id']; ?>" class="view-btn">View Details</a>
            </div>
        </div>

<?php
    }
} else {
    echo "No rooms found.";
}

$conn->close();
?>
</div>


    <main>
        <section class="section-story">
            <h2>Our Story</h2>
            <p>Welcome to <strong>RoamEasy</strong>, where finding the perfect place to stay is as effortless as clicking a button. We started RoamEasy because we were tired of the complexity, hidden fees, and endless searching that often comes with booking accommodation. Our founders, a team of passionate travelers and tech innovators, envisioned a platform that prioritized <strong>simplicity, transparency, and reliable choices</strong>. Since our launch in 2020, we've helped millions of travelers find their ideal room, from cozy B&Bs to luxurious penthouse suites.</p>
        </section>

        <section class="section-mission">
            <h2>Our Mission: Travel Without the Trepidation</h2>
            <p>Our mission is simple: <strong>To empower your journey by connecting you with the best accommodation options, easily and transparently.</strong></p>
            <ul>
                <li><strong>🔍 Clarity:</strong> We provide clear, accurate photos, detailed descriptions, and verified user reviews, ensuring you know exactly what you're booking.</li>
                <li><strong>💸 Value:</strong> We work tirelessly to secure competitive prices and present them without hidden service charges. The price you see is the price you pay.</li>
                <li><strong>❤️ Community:</strong> We partner with local hosts and established hotels, supporting a diverse global community of accommodation providers.</li>
            </ul>
        </section>

        <section class="section-features">
            <h2>Why Choose RoamEasy?</h2>
            <table>
                <thead>
                    <tr>
                        <th>Feature</th>
                        <th>What It Means For You</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Verified Stays</strong></td>
                        <td>Every room is checked for legitimacy and quality standards. <strong>No more booking surprises!</strong></td>
                    </tr>
                    <tr>
                        <td><strong>24/7 Support</strong></td>
                        <td>Our dedicated team is available around the clock to assist you, no matter your time zone.</td>
                    </tr>
                    <tr>
                        <td><strong>Best Price Guarantee</strong></td>
                        <td>We are committed to offering you the most competitive price on the market.</td>
                    </tr>
                    <tr>
                        <td><strong>Flexible Cancellation</strong></td>
                        <td>Life happens. We offer a variety of options that let you book with confidence and flexibility.</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="section-difference">
            <h2>The RoamEasy Difference</h2>
            <p>We believe that travel planning should be exciting, not exhausting. We are constantly enhancing our platform with user-friendly features like **intelligent filtering, neighborhood guides, and a personalized recommendation engine** to make your next booking the best one yet.</p>
            <p>We're more than just a booking site; we're your trusted partner in travel.</p>
        </section>
    </main>

    <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h3>Social</h3>
         <a href="https://www.instagram.com/binary_elite/" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
      <a href="https://www.facebook.com/Maharjan4" target="_blank"><i class="fab fa-facebook"></i> Facebook</a>
      <a href="https://github.com/Icyshadow7" target="_blank"><i class="fab fa-github"></i> GitHub</a>
     
      </div>
      <div class="footer-section">
        <h3>Contact</h3>
        <a href="">Email : aashishmaharjan48@gmail.com</a>
        <a href="#">Phone no : 9841******</a>
        
      </div>
     
    </div>
    <div class="footer-bottom"id="foooter">
      © 2025 Mrzn's. All rights reserved.
    </div>
  </footer>
<script>

function openLogin() {
    document.getElementById("loginModal").style.display = "flex";
}

function closeLogin() {
    document.getElementById("loginModal").style.display = "none";
}



    </script>
</body>
</html>
