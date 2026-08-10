<?php
require_once 'db.php';

// Check if a search query was submitted via URL
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($search)) {
    // Prepared Statement for Safe Searching
    $stmt = $conn->prepare("SELECT * FROM students WHERE full_name LIKE ? OR matric_no LIKE ? ORDER BY id DESC");
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
} else {
    // Fetch all students if search box is empty
    $stmt = $conn->prepare("SELECT * FROM students ORDER BY id DESC");
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration System</title>
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
    <form method="GET" action="index.php" class="search-form">
        <input type="text" name="search" placeholder="Search by Name or Matric No..." value="<?= htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
        <a href="index.php" class="btn-reset">Reset</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th><th>Full Name</th><th>Matric No</th><th>Department</th><th>Email</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= htmlspecialchars($row['full_name']); ?></td>
                        <td><?= htmlspecialchars($row['matric_no']); ?></td>
                        <td><?= htmlspecialchars($row['department']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td>
                            <a href="edit_student.php?id=<?= $row['id']; ?>">Edit</a> |
                            <a href="delete_student.php?id=<?= $row['id']; ?>" onclick="return confirm('Delete record?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">No student records found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
