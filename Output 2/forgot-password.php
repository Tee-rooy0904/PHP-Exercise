<?php require_once 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>Forgot Password</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <button type="submit" class="btn btn-primary">Reset Password</button>
                <div class="mt-3 text-center">
                    <a href="login.php">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>