<?php
session_start();
if (!isset($faculties)) {
    require_once('../Controller/faculty_controller.php');
    $controller = new FacultyController($conn);
    $faculties = $controller->getFaculties();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Management</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Faculty Form</h2>
            <form action="../Controller/faculty_controller.php" method="POST">
                <input type="hidden" name="id" value="<?= isset($faculty['id']) ? $faculty['id'] : '' ?>">

                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" value="<?= isset($faculty['first_name']) ? htmlspecialchars($faculty['first_name']) : '' ?>" required>

                <label for="middle_name">Middle Name:</label>
                <input type="text" name="middle_name" id="middle_name" value="<?= isset($faculty['middle_name']) ? htmlspecialchars($faculty['middle_name']) : '' ?>">

                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" value="<?= isset($faculty['last_name']) ? htmlspecialchars($faculty['last_name']) : '' ?>" required>

                <label for="age">Age:</label>
                <input type="number" name="age" id="age" min="18" max="100" value="<?= isset($faculty['age']) ? htmlspecialchars($faculty['age']) : '' ?>" required>

                <label for="gender">Gender:</label>
                <select name="gender" id="gender" required>
                    <option value="Male" <?= isset($faculty['gender']) && $faculty['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= isset($faculty['gender']) && $faculty['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= isset($faculty['gender']) && $faculty['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
                </select>

                <label for="address">Address:</label>
                <textarea name="address" id="address" required><?= isset($faculty['address']) ? htmlspecialchars($faculty['address']) : '' ?></textarea>

                <label for="position">Position:</label>
                <input type="text" name="position" id="position" value="<?= isset($faculty['position']) ? htmlspecialchars($faculty['position']) : '' ?>" required>

                <label for="salary">Salary:</label>
                <input type="number" name="salary" id="salary" step="0.01" min="0" value="<?= isset($faculty['salary']) ? htmlspecialchars($faculty['salary']) : '' ?>" required>

                <input type="hidden" name="action" value="<?= isset($faculty) ? 'update' : 'create' ?>">

                <button type="submit"><?= isset($faculty) ? 'Update' : 'Create' ?> Faculty</button>
            </form>
        </div>

        <h2>Faculty Management</h2>
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Position</th>
                    <th>Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($faculties)): ?>
                    <?php foreach ($faculties as $faculty): ?>
                        <tr>
                            <td><?= htmlspecialchars($faculty['first_name']) ?></td>
                            <td><?= htmlspecialchars($faculty['middle_name']) ?></td>
                            <td><?= htmlspecialchars($faculty['last_name']) ?></td>
                            <td><?= htmlspecialchars($faculty['age']) ?></td>
                            <td><?= htmlspecialchars($faculty['gender']) ?></td>
                            <td><?= htmlspecialchars($faculty['address']) ?></td>
                            <td><?= htmlspecialchars($faculty['position']) ?></td>
                            <td><?= htmlspecialchars($faculty['salary']) ?></td>
                            <td>
                                <a href="../Controller/faculty_controller.php?action=edit&id=<?= $faculty['id'] ?>">Edit</a> | 
                                <a href="../Controller/faculty_controller.php?action=delete&id=<?= $faculty['id'] ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align: center; color: gray;">No faculty records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>