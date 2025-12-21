<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


// 1. **Define variables from session**
// NOTE: I corrected 'user_name' to 'fullname' to match the variable set in login.php
$userId = $_SESSION['user_id'] ?? '';
$fullName = $_SESSION['fullname'] ?? ''; // Use 'fullname' as set in the login script
$loggedIn = $_SESSION['logged_in'] ?? FALSE;

// 2. **Authentication Check (Redirect to login if the user is not authenticated)**
// This logic is typically used on *restricted* pages (like a dashboard or profile).
// Since this is the home page, we only check if the user is logged in for the NAVBAR GREETING.
// We only need to implement a full redirect check on pages like 'room_detail.php' or 'booking.php'.

// Example of the redirect logic for a restricted page (e.g., dashboard.php):
/*
if (!$loggedIn) {
    header("Location: login.php");
    exit();
}
*/
include "db.php"; // database connection file


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aashish's E-commerce - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="index.css"> 
    <script src="https://cdn.tailwindcss.com"></script>

<style>
    html {
    scroll-behavior: smooth;
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
.btn { padding: 15px 20px; background-color: #b92c2cff; color: white; text-decoration: none; border-radius: 5px; }
..login-btn, .loggedin-btn { background-color: #ab2020ff; padding: 4px 10px ; border-radius: 5px; margin-top:20px; }

/* NOTE: The padding 18px 900px on the login/logout buttons seems extremely wide. I recommend reducing the 900px to something like 20px. */
.rooms-container { display:flex; flex-wrap:wrap; justify-content:center; padding:20px; background-color: #333; }
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
            box-shadow: 0 5px 10px rgba(45, 100, 255, 0.3);
        }
        .hero h1 {
    font-size: 3rem;
    margin: 0;
    color: #000000ff;
}

.hero p {
    font-size: 1.2rem;
    margin: 10px 0 20px;
    color: #000000ff;
}
.hero{
background-color:white;
}
/* 1. Hide the default file input button */
#fa-file-input {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}

.user-icon-link {
    text-decoration: none;
}

.user-icon {
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
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.user-icon:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.35);
}

/* 2. Style the custom 'button' (the label) */
.fa-upload-button {
  /* Button appearance */
  display: inline-flex;
  align-items: center;
  gap: 10px; /* Spacing for the icon */
  padding: 10px 22px;
  border-radius: 25px; /* Pill-shaped button for a different look */
  background-color: #cb3011ff; /* A vibrant purple color */
  color: white;
  font-family: Arial, sans-serif;
  font-size: 16px;
  font-weight: 600;

  cursor: pointer;
  
  /* Transition for hover effect */
  transition: background-color 0.3s ease, transform 0.1s ease, box-shadow 0.3s ease;
}

/* 3. Hover Effect */
.fa-upload-button:hover {
  background-color:#971c1cff;
}

/* 4. Active/Click State Effect */


/* 5. Font Awesome Icon Styling */
.fa-upload-button i {
  font-size: 1.1em; /* Slightly larger icon */
}
.file-upload-container{
    margin-right:30px;
}
/* 6. Display file name */
#fa-file-name-display {
  display: block;
  margin-top: 10px;
  font-family: Arial, sans-serif;
  color: #888;
  font-style: italic;
  font-size: 0.9em;
}
.btun{
    display:flex;
  justify-content:space-between;
    }
    .btun #lgn{

    }
</style>

</head>

<body id="hy">

<nav class="navbar">
    <div class="logo">
        <a href="index.php">QUICK BOOK</a>
    </div>
    

    <ul class="nav-links">
        <li><a href="index.php" id="homeline">Home</a></li>
        <li><a href="room.php #rooms-container">Available Rooms</a></li>
        <li><a href="#foooter">Contact</a></li>


    
     
    </ul>

<div class="btun">

    <div class="file-upload-container">
        <input type="file" id="fa-file-input" name="file-upload" accept=".jpg, .jpeg, .png, .pdf">

        <button class="custom-upload-button fa-upload-button" onclick="checkUpload()">
            <i class="fa-solid fa-cloud-arrow-up"></i> Upload
        </button>
    </div>

    <?php if ($loggedIn): ?>
        <!-- LOGGED IN USER -->
        <a href="dashboard.php" class="user-icon-link" title="Go to Dashboard">
            <div class="user-icon">
                <?php echo strtoupper(substr($_SESSION['fullname'], 0, 1)); ?>
            </div>
        </a>
    <?php else: ?>
        <!-- NOT LOGGED IN -->
        <a href="login.php" class="login-btn" id="lgn">
            <button class="attractive-btn" id="loginButton">Log In</button>
        </a>
    <?php endif; ?>

</div>

</nav>

<header class="hero">
    <div class="hero-text">
        <h1> Quick Book</h1>
        <p> Fastest room booking website. </p>
        <a href="room.php #rooms-container" class="btn" id="ii"> Book Now </a>
    </div>
</header>


<div class="rooms-container" id="rooms-container">


<?php
$sql = "SELECT * FROM rooms LIMIT 8";
$rooms = $conn->query($sql);

if ($rooms->num_rows > 0 ) {
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



<div class="footer-team">
    <h3>Meet Our Team</h3>

    <div class="team-flex">
        <!-- Member 1 -->
        <div class="team-card">
            <img src="uploads/team1.jpg" alt="Team Member">
            <div class="team-info">
                <h4>Member One</h4>
                <span>Frontend Developer</span>
                <p>Builds clean, responsive, and user-friendly interfaces.</p>
            </div>
        </div>

        <!-- Member 2 -->
        <div class="team-card">
            <img src="uploads/team2.jpg" alt="Team Member">
            <div class="team-info">
                <h4>Member Two</h4>
                <span>Backend Developer</span>
                <p>Handles server logic, APIs, and secure data flow.</p>
            </div>
        </div>

        <!-- Member 3 -->
        <div class="team-card">
            <img src="uploads/team3.jpg" alt="Team Member">
            <div class="team-info">
                <h4>Member Three</h4>
                <span>UI / UX Designer</span>
                <p>Designs smooth layouts and modern user experiences.</p>
            </div>
        </div>

        <!-- Member 4 -->
        <div class="team-card">
            <img src="uploads/team4.jpg" alt="Team Member">
            <div class="team-info">
                <h4>Member Four</h4>
                <span>Database Manager</span>
                <p>Manages data integrity and system performance.</p>
            </div>
        </div>
    </div>
</div>


<script>
function checkUpload() {
    let isLoggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;

    if (!isLoggedIn) {
        alert("Please log in before uploading.");
        window.location.href = "login.php";
    } else {
        window.location.href = "upload.php";
    }
}
</script>

</body>
</html>