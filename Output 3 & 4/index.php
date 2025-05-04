<?php

include('db.php');


$errors = [];
$formData = ['age' => '', 'gender' => '', 'email' => '', 'address' => '', 'contact' => ''];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['age'] = trim($_POST['age']);
    $formData['gender'] = $_POST['gender'];
    $formData['email'] = trim($_POST['email']);
    $formData['address'] = trim($_POST['address']);
    $formData['contact'] = trim($_POST['contact']);

   
    if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email format.';
    if (!is_numeric($formData['age']) || $formData['age'] <= 0) $errors['age'] = 'Enter a valid age.';
    if (!in_array($formData['gender'], ['Male', 'Female', 'Other'])) $errors['gender'] = 'Invalid gender.';
    if (!preg_match('/^[0-9]{11}$/', $formData['contact'])) $errors['contact'] = 'Invalid contact number (11 digits only).';
    if (empty($formData['address'])) $errors['address'] = 'Address is required.';

  
    if (empty($errors)) {
   
$sql = "INSERT INTO registered_users (age, gender, email, address, contact) 
VALUES (?, ?, ?, ?, ?)";


$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $formData['age'], $formData['gender'], 
          $formData['email'], $formData['address'], $formData['contact']);

if ($stmt->execute()) {
echo "<div class='success-message'>Record added successfully!</div>";
} else {
echo "<div class='error-messages'>Error: " . $stmt->error . "</div>";
}
$stmt->close();

    }
}


$sql = "SELECT * FROM registered_users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Registration Form</h2>

        <form method="POST" action="index.php">
           
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" name="age" id="age" class="<?= isset($errors['age']) ? 'error' : '' ?>" value="<?= htmlspecialchars($formData['age']) ?>" required>
                <span class="error-message"><?= $errors['age'] ?? '' ?></span>
            </div>

        
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" id="gender" class="<?= isset($errors['gender']) ? 'error' : '' ?>" required>
                    <option value="Male" <?= $formData['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= $formData['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= $formData['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                </select>
                <span class="error-message"><?= $errors['gender'] ?? '' ?></span>
            </div>

          
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="<?= isset($errors['email']) ? 'error' : '' ?>" value="<?= htmlspecialchars($formData['email']) ?>" required>
                <span class="error-message"><?= $errors['email'] ?? '' ?></span>
            </div>

           
            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" id="address" class="<?= isset($errors['address']) ? 'error' : '' ?>" required><?= htmlspecialchars($formData['address']) ?></textarea>
                <span class="error-message"><?= $errors['address'] ?? '' ?></span>
            </div>

            
            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" name="contact" id="contact" class="<?= isset($errors['contact']) ? 'error' : '' ?>" value="<?= htmlspecialchars($formData['contact']) ?>" required>
                <span class="error-message"><?= $errors['contact'] ?? '' ?></span>
            </div>

            <button type="submit" class="btn">Submit</button>
        </form>

        <h3>Registered Users</h3>
        <table>
            <thead>
                <tr>                  
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php

$conn->close();
?>