<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Form with Validation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="form-card">
        <h2>Registration Form</h2>
        
        <?php
        $errors = [];
        $formData = ['name' => '', 'age' => '', 'gender' => '', 'email' => '', 'address' => '', 'contact' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData['name'] = trim($_POST['name']);
            $formData['age'] = trim($_POST['age']);
            $formData['gender'] = $_POST['gender'];
            $formData['email'] = trim($_POST['email']);
            $formData['address'] = trim($_POST['address']);
            $formData['contact'] = trim($_POST['contact']);

            if (empty($formData['name'])) $errors['name'] = 'Name is required.';
            if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email format.';
            if (!is_numeric($formData['age']) || $formData['age'] <= 0) $errors['age'] = 'Enter a valid age.';
            if (!in_array($formData['gender'], ['Male', 'Female', 'Other'])) $errors['gender'] = 'Invalid gender.';
            if (!preg_match('/^[0-9]{11}$/', $formData['contact'])) $errors['contact'] = 'Invalid contact number (11 digits only).';
            if (empty($formData['address'])) $errors['address'] = 'Address is required.';

            if (empty($errors)) {
                header("Location: success.php");
                exit();
            }
        }
        ?>

        <form method="POST" action="index.php" novalidate>
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($formData['name']) ?>" 
                       class="<?= isset($errors['name']) ? 'invalid' : '' ?>" required>
                <div class="error"><?= $errors['name'] ?? '' ?></div>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" name="age" value="<?= htmlspecialchars($formData['age']) ?>" 
                       class="<?= isset($errors['age']) ? 'invalid' : '' ?>" required>
                <div class="error"><?= $errors['age'] ?? '' ?></div>
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="<?= isset($errors['gender']) ? 'invalid' : '' ?>" required>
                    <option value="Male" <?= $formData['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= $formData['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= $formData['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                </select>
                <div class="error"><?= $errors['gender'] ?? '' ?></div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($formData['email']) ?>" 
                       class="<?= isset($errors['email']) ? 'invalid' : '' ?>" required>
                <div class="error"><?= $errors['email'] ?? '' ?></div>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" required><?= htmlspecialchars($formData['address']) ?></textarea>
                <div class="error"><?= $errors['address'] ?? '' ?></div>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" name="contact" value="<?= htmlspecialchars($formData['contact']) ?>" 
                       class="<?= isset($errors['contact']) ? 'invalid' : '' ?>" required>
                <div class="error"><?= $errors['contact'] ?? '' ?></div>
            </div>

            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</div>

</body>
</html>