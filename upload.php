<?php
session_start();
include "db.php"; // must create $conn

$feedback_message = '';
$feedback_class = 'hidden';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Input values
    $roomName     = trim($_POST['name'] ?? '');
    $roomLocation = trim($_POST['location'] ?? '');
    $roomPhone    = trim($_POST['phone'] ?? '');
    $roomPriceRaw = $_POST['price'] ?? '';

    $roomPrice = filter_var($roomPriceRaw, FILTER_VALIDATE_FLOAT);

    // File upload
    $uploadedFile = $_FILES['image'] ?? null;
    $uploadError = false;
    $newFileName = '';

    if ($uploadedFile && $uploadedFile['error'] === UPLOAD_ERR_OK) {

        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $fileExtension = strtolower(pathinfo($uploadedFile['name'], PATHINFO_EXTENSION));
        $allowedExt = ["jpg", "jpeg", "png", "webp"];

        if (!in_array($fileExtension, $allowedExt)) {
            $uploadError = true;
            $feedback_message = "Error: Only JPG, JPEG, PNG, WEBP images are allowed.";
        } else {
            $newFileName = uniqid("room_", true) . "." . $fileExtension;
            $target_file = $target_dir . $newFileName;

            if (!move_uploaded_file($uploadedFile['tmp_name'], $target_file)) {
                $uploadError = true;
                $feedback_message = "Error: Could not save uploaded file. Check folder permissions.";
            }
        }

    } else {
        $uploadError = true;
        $feedback_message = "Error: Image file is required.";
    }

    // FINAL VALIDATION
    if ($roomName === '' || $roomLocation === '' || $roomPhone === '' || $roomPrice === false || $uploadError) {

        if (!$feedback_message) {
            $feedback_message = "Please fill all required fields correctly.";
        }
        $feedback_class = 'bg-red-100 text-red-700 p-3 rounded-md';

    } else {

        // ✅ INSERT INTO DATABASE (rooms table)
        // IMPORTANT: these column names must match your rooms table!
        $stmt = $conn->prepare("INSERT INTO rooms (room_name, location, phone, price, image) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            $feedback_message = "Database prepare error: " . $conn->error;
            $feedback_class = 'bg-red-100 text-red-700 p-3 rounded-md';
        } else {
            $stmt->bind_param("sssds", $roomName, $roomLocation, $roomPhone, $roomPrice, $newFileName);

            if ($stmt->execute()) {
                $newId = $stmt->insert_id;

                $feedback_message = "
                    <div class='p-4 bg-green-100 border border-green-300 rounded'>
                        <h2 class='font-bold text-green-700'>SUCCESS! Room added to database.</h2>
                        <p><b>ID:</b> $newId</p>
                        <p><b>Name:</b> " . htmlspecialchars($roomName) . "</p>
                        <p><b>Price:</b> Rs. " . htmlspecialchars($roomPrice) . "</p>
                        <p><b>Location:</b> " . htmlspecialchars($roomLocation) . "</p>
                        <p><b>Phone:</b> " . htmlspecialchars($roomPhone) . "</p>
                        <p><b>Saved Image:</b> " . htmlspecialchars($newFileName) . "</p>
                        <img src='uploads/$newFileName' class='mt-3 w-48 rounded shadow'>
                    </div>
                ";
                $feedback_class = '';
            } else {
                // If DB insert fails, remove uploaded file to keep folder clean
                @unlink("uploads/" . $newFileName);

                $feedback_message = "Database insert error: " . $stmt->error;
                $feedback_class = 'bg-red-100 text-red-700 p-3 rounded-md';
            }

            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Room</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<div class="max-w-xl mx-auto">

    <?php if (!empty($feedback_message)): ?>
        <div class="<?= $feedback_class ?> mb-6">
            <?= $feedback_message ?>
        </div>
    <?php endif; ?>

    <form action="upload.php" method="POST" enctype="multipart/form-data"
          class="bg-white p-6 rounded-lg shadow">

        <h2 class="text-2xl font-bold mb-4 text-center">Upload Room</h2>

        <label>Room Name</label>
        <input type="text" name="name" class="w-full border p-2 rounded mb-3" required>

        <label>Price</label>
        <input type="number" name="price" class="w-full border p-2 rounded mb-3" required>

        <label>Location</label>
        <input type="text" name="location" class="w-full border p-2 rounded mb-3" required>

        <label>Phone</label>
        <input type="text" name="phone" class="w-full border p-2 rounded mb-3" required>

        <label>Room Image</label>
        <input type="file" name="image" class="w-full border p-2 rounded mb-4" accept="image/*" required>

        <div class="flex justify-between mt-4 gap-3">
            <a href="index.php"
               class="w-1/2 text-center bg-[#d02a1bff] text-white py-3 rounded-lg font-semibold
                      transition-all duration-200 shadow-md hover:shadow-lg hover:bg-[#a21313ff] hover:scale-[1.02]">
                Back to Home
            </a>

            <button type="submit"
                class="w-1/2 bg-[#d02a1bff] text-white py-3 rounded-lg font-bold
                       transition-all duration-200 shadow-md hover:shadow-lg hover:bg-[#a21313ff] hover:scale-[1.02]">
                Upload Listing
            </button>
        </div>

    </form>
</div>

</body>
</html>
