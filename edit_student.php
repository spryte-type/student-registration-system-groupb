<?php
require_once 'db.php';

$errors = [];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

// Handle the update submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name  = trim($_POST['full_name'] ?? '');
    $matric_no  = trim($_POST['matric_no'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $id         = (int)($_POST['id'] ?? 0);

    if ($full_name === '' || $matric_no === '' || $department === '' || $email === '') {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        // Prepared statement — prevents SQL injection on update
        $stmt = $conn->prepare(
            "UPDATE students SET full_name = ?, matric_no = ?, department = ?, email = ? WHERE id = ?"
        );
        $stmt->bind_param("ssssi", $full_name, $matric_no, $department, $email, $id);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Could not update student. Matric number may already exist.";
        }
        $stmt->close();
    }
}

// Fetch the current row to pre-fill the form
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

if (!$student) {
    header("Location: index.php");
    exit;
}

// If this is the first GET load (not a failed POST), use DB values as defaults
$full_name  = $_POST['full_name']  ?? $student['full_name'];
$matric_no  = $_POST['matric_no']  ?? $student['matric_no'];
$department = $_POST['department'] ?? $student['department'];
$email      = $_POST['email']      ?? $student['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
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
    <h3>Edit Student Record</h3>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $err): ?>
                <p><?= htmlspecialchars($err); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="edit_student.php" class="student-form">
        <input type="hidden" name="id" value="<?= (int)$student['id']; ?>">

        <label>Full Name</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($full_name); ?>" required>

        <label>Matric Number</label>
        <input type="text" name="matric_no" value="<?= htmlspecialchars($matric_no); ?>" required>

        <label>Department</label>
        <input type="text" name="department" value="<?= htmlspecialchars($department); ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email); ?>" required>

        <button type="submit">Save Changes</button>
        <a href="index.php" class="btn-reset">Cancel</a>
    </form>
</div>
</body>
</html>
