<?php
include '../db.php'; // Include database connection
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Fetch user details for editing
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found!";
        exit;
    }
} else {
    header("Location: manage_users.php");
    exit;
}

// Handle the form submission to update user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    $stmt = $pdo->prepare("UPDATE Users SET name = ?, email = ?, phone = ?, address = ?, role = ? WHERE user_id = ?");
    $stmt->execute([$name, $email, $phone, $address, $role, $user_id]);

    header("Location: manage_users.php"); // Redirect after successful update
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required><br>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required><br>

        <label>Role:</label>
        <select name="role" required>
            <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
            <option value="user" <?php if ($user['role'] === 'customer') echo 'selected'; ?>>Customer</option>
        </select><br>

        <button type="submit">Update User</button>
    </form>
</body>
</html>
