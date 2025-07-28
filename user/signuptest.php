<?php
require_once "db.php";
if (!isset($_SESSION)) {
    session_start();
}

$cities = array("Yangon", "Mandalay", "Magway", "Myitkyina", "Malamyine");

if (isset($_POST['signUp'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $profile = $_FILES['profile'];

    $filepath = "profile/" . basename($profile['name']);
    $fileType = mime_content_type($profile['tmp_name']);

    // Helper: check password strength
    function isPasswordStrong($password)
    {
        return preg_match('/[A-Z]/', $password) &&
            preg_match('/\d/', $password) &&
            preg_match('/[^a-zA-Z0-9]/', $password);
    }

    // Validation logic
    if ($password !== $cpassword) {
        $errMessage = "Password and Confirm Password do not match.";
    } elseif (strlen($password) < 8) {
        $errMessage = "Password must be at least 8 characters.";
    } elseif (!isPasswordStrong($password)) {
        $errMessage = "Password must include at least one uppercase letter, one digit, and one special character.";
    } elseif (!in_array($fileType, ['image/jpeg', 'image/png', 'image/jpg'])) {
        $errMessage = "Only JPG, JPEG, and PNG profile images are allowed.";
    } else {
        // Check for duplicate email
        $check = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            $errMessage = "Email already exists. Please use another.";
        } else {
            try {
                $hashCode = password_hash($password, PASSWORD_BCRYPT);
                $uploadSuccess = move_uploaded_file($profile['tmp_name'], $filepath);
                if ($uploadSuccess) {
                    $sql = "INSERT INTO user 
                            (user_id, username, email, password, phone, address, profile_path) 
                            VALUES (NULL, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$username, $email, $hashCode, $phone, $address, $filepath]);

                    $_SESSION['customerEmail'] = $email;
                    $_SESSION['customerSignupSuccess'] = "Signup Success!! You can login here!";
                    header("Location: customerLogin.php");
                    exit();
                } else {
                    $errMessage = "Profile upload failed.";
                }
            } catch (PDOException $e) {
                $errMessage = "Database error: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Signup</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 mx-auto py-3 mt-3">
                <h3 class="text-start">Sign Up</h3>
                <form action="signuptest.php" method="post" enctype="multipart/form-data">
                    <?php if (isset($errMessage)): ?>
                        <p class="alert alert-danger"><?= $errMessage ?></p>
                    <?php endif; ?>

                    <div class="mb-1">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-1">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-1">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-1">
                        <label for="cpassword" class="form-label">Confirm Password</label>
                        <input type="password" name="cpassword" class="form-control" required>
                    </div>

                    <div class="mb-1">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" name="phone" class="form-control" required>
                    </div>

                    <div class="mb-1">
                        <label for="address" class="form-label">City</label>
                        <select name="address" class="form-select" required>
                            <option value="">Choose City</option>
                            <?php foreach ($cities as $address): ?>
                                <option value="<?= $address ?>"><?= $address ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-1">
                        <label for="profile" class="form-label">Choose Profile Image</label>
                        <input type="file" name="profile" class="form-control" required>
                    </div>

                    <div class="mb-1">
                        <button type="submit" name="signUp" class="btn btn-primary">Signup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>