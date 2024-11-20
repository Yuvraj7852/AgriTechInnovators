<?php
include 'db_connect.php';
session_start();

// Handle Registration
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this email.";
    }
}
?>
<?php
include 'db_connect.php';
session_start();

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
}

// Fetch internships
$internships = $conn->query("SELECT * FROM internships");

// Add Internship
if (isset($_POST['add_internship'])) {
    $company = $_POST['company'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];

    $sql = "INSERT INTO internships (company, title, description, duration) VALUES ('$company', '$title', '$description', '$duration')";
    if ($conn->query($sql) === TRUE) {
        echo "Internship added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <h2>Internships</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Company</th>
            <th>Title</th>
            <th>Description</th>
            <th>Duration</th>
        </tr>
        <?php while ($row = $internships->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['company']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['duration']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Add Internship</h2>
    <form method="POST">
        <input type="text" name="company" placeholder="Company" required>
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description"></textarea>
        <input type="text" name="duration" placeholder="Duration" required>
        <button type="submit" name="add_internship">Add Internship</button>
    </form>
</body>
</html>