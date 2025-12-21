<?php
session_start();
// Start the session

// Database connection details (Same as signup.php)
$host = "localhost";
$user = "root";
$pass = "";
$db   = "aashish"; 

// Use the mysqli constructor for the connection object
$conn = new mysqli($host, $user, $pass, $db); 

// Check for connection error
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// ---- PROCESS LOGIN ---- //
$loginMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // 1. Basic Validation
    if (empty($email) || empty($password)) {
        $loginMessage = "<p class='text-red-700'>Email and password are required.</p>";
    } else {
        // 2. Query database for user by email using Prepared Statements
 // Should select id, fullname, email, and password
$stmt = $conn->prepare("SELECT id, fullname, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $hashedPassword = $user['password'];

            // 3. Verify password using password_verify()
            if (password_verify($password, $hashedPassword)) {
                
                // 4. Login successful: Set session variables and redirect
              // 4. Login successful: Set session variables and redirect
$_SESSION['user_id'] = $user['id'];
$_SESSION['fullname'] = $user['fullname'];
$_SESSION['email'] = $user['email']; // <-- ADD THIS LINE
$_SESSION['logged_in'] = TRUE;

                // Redirect to the index/dashboard page
                header("Location: index.php");

                exit();
                
            } else {
                // 5. Password verification failed
                $loginMessage = "<p class='text-red-700'>Invalid password.</p>";
            }
        } else {
            // User not found
            $loginMessage = "<p class='text-red-700'>No account found with that email address.</p>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #ffe9e0 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white shadow-2xl rounded-xl p-8 md:p-10 border border-gray-100/50">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Welcome Back!</h1>
            <p class="text-gray-500">Sign in to continue to your dashboard.</p>
        </div>

        <form action="login.php" method="POST" class="space-y-6">

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500">
            </div>

            <?php if ($loginMessage): ?>
                <div class="p-3 text-sm rounded-lg bg-gray-100">
                    <p class='text-red-700'><?= $loginMessage ?></p>
                </div>
            <?php endif; ?>

            <button type="submit"
                    class="w-full py-3 px-4 rounded-lg shadow-md text-white bg-red-600 hover:bg-red-700">
                Log In
            </button>
        </form>

        <div class="mt-6 text-center text-sm">
            <p class="text-gray-500">
                Don't have an account?
                <a href="signup.php" class="font-medium text-red-600 hover:underline">Sign Up</a>
            </p>
        </div>

    </div>

</body>
</html>