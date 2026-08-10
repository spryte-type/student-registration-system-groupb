<?php
require_once 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name  = trim($_POST['full_name'] ?? '');
    $matric_no  = trim($_POST['matric_no'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $email      = trim($_POST['email'] ?? '');

    if ($full_name === '' || $matric_no === '' || $department === '' || $email === '') {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        // Prepared statement — prevents SQL injection on insert
        $stmt = $conn->prepare(
            "INSERT INTO students (full_name, matric_no, department, email) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $full_name, $matric_no, $department, $email);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            // Most likely cause: duplicate matric_no (UNIQUE constraint)
            $errors[] = "Could not save student. Matric number may already exist.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register New Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h2>FUTMINNA Student Portal</h2>
    <nav>
        <a href="index.php">View Students</a>
        <a href="add_student.php">+ Register New Student</a>
    </nav>
</header>

<div class="container">
    <h3>Register New Student</h3>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $err): ?>
                <p><?= htmlspecialchars($err); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="add_student.php" class="student-form">
        <label>Full Name</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($_POST['full_name'] ?? ''); ?>" required>

        <label>Matric Number</label>
        <input type="text" name="matric_no" value="<?= htmlspecialchars($_POST['matric_no'] ?? ''); ?>" required>

        <label>Department</label>
        <input type="text" name="department" value="<?= htmlspecialchars($_POST['department'] ?? ''); ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>" required>

        <button type="submit">Register Student</button>
        <a href="index.php" class="btn-reset">Cancel</a>
    </form>
</div>
</body>
</html>
