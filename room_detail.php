<?php
session_start();
include "db.php";

$roomId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$room = null;

if ($roomId > 0) {
    $stmt = $conn->prepare("SELECT id, room_name, location, phone, price, image FROM rooms WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $room = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

function safe($v) {
    return htmlspecialchars($v ?? "", ENT_QUOTES, "UTF-8");
}

/* Decide image path (uploads first; fallback to images; else default) */
$imgPath = "";
if ($room) {
    $img = $room["image"] ?? "";
    $uploads = "uploads/" . $img;
    $images  = "images/" . $img;

    if ($img && file_exists($uploads)) $imgPath = $uploads;
    elseif ($img && file_exists($images)) $imgPath = $images;
    else $imgPath = "images/default.jpg"; // create this file
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Room Details</title>
<link rel="stylesheet" href="index.css">
<style>
body { font-family: Arial, sans-serif; background-color: #f5f5f5; margin:0; padding:0; }
.room-detail-container { max-width:800px; margin:30px auto; background:white; padding:20px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.2); }
.room-detail-container img { width:100%; height:400px; object-fit:cover; border-radius:10px; }
.room-info { padding:15px; }
.room-info h2 { margin:0 0 10px 0; }
.room-info p { margin:5px 0; font-size:1em; }
.price { color:#4CAF50; font-weight:bold; font-size:1.2em; }
.back-btn, .book-btn { display:inline-block; margin-top:15px; padding:10px 20px; color:white; text-decoration:none; border-radius:5px; transition: background-color 0.2s; }
.back-btn { background-color:#2196F3; }
.back-btn:hover { background-color:#1976D2; }
.book-btn { background-color:#ff5722; }
.book-btn:hover { background-color:#e64a19; }

/* Navbar */
.navbar { display:flex; justify-content:space-between; align-items:center; padding:15px 50px; background-color:#333; color:white; }
.navbar .logo a { color:white; text-decoration:none; font-size:1.5em; font-weight:bold; }
.nav-links { display:flex; list-style:none; gap:10px; }
.nav-links li a { color:white; text-decoration:none; padding:0 15px; }

/* User icon */
.nav-user{display:flex;align-items:center;gap:10px;}
.user-link{display:flex;align-items:center;text-decoration:none;}
.avatar{
  width:42px;height:42px;border-radius:50%;
  background:linear-gradient(135deg,#b92c2c,#ff5a1f);
  color:#fff;display:flex;align-items:center;justify-content:center;
  font-weight:800;font-size:16px;
  box-shadow:0 6px 18px rgba(0,0,0,0.25);
}
.login-btn{
  background:#b92c2c;color:#fff;border:none;border-radius:8px;
  padding:10px 16px;cursor:pointer;
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

  <div class="nav-user">
    <?php if (!empty($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
      <a href="dashboard.php" class="user-link" title="Dashboard">
        <div class="avatar"><?php echo strtoupper(substr($_SESSION['fullname'] ?? 'U', 0, 1)); ?></div>
      </a>
    <?php else: ?>
      <a class="login-btn" href="login.php" style="text-decoration:none;display:inline-block;">Login</a>
    <?php endif; ?>
  </div>
</nav>

<div class="room-detail-container">
  <?php if ($room): ?>
    <img src="<?php echo safe($imgPath); ?>" alt="<?php echo safe($room['room_name']); ?>">

    <div class="room-info">
      <h2><?php echo safe($room['room_name']); ?></h2>

      <p><strong>Phone:</strong> <?php echo safe($room['phone']); ?></p>
      <p><strong>Location:</strong> <?php echo safe($room['location']); ?></p>
      <p class="price"><strong>Price:</strong> Rs. <?php echo safe($room['price']); ?></p>

      <a href="room.php" class="back-btn">Back to Rooms</a>

      <!-- You can change this later to your booking system -->
      <a href="book_room.php?id=<?php echo (int)$room['id']; ?>" class="book-btn">Book Now</a>
    </div>

  <?php else: ?>
    <p>Room not found.</p>
    <a href="room.php" class="back-btn">Back to Rooms</a>
  <?php endif; ?>
</div>

</body>
</html>
