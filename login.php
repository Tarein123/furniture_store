<?php
require_once "db.php";
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['customerLogin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $sql = "SELECT user_id, email, password, role, profile_path FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userInfo) {
            $message = "Username or password might be incorrect.";
        } else {
            if (password_verify($password, $userInfo['password'])) {
                // Set session variables
                $_SESSION['customerEmail'] = $userInfo['email'];
                $_SESSION['clogin'] = true;
                $_SESSION['profile'] = $userInfo['profile_path'];
                $_SESSION['userId'] = $userInfo['user_id'];
                $_SESSION['role'] = $userInfo['role'];
                // Redirect based on role
                if ($userInfo['role'] === 'admin') {
                    header("Location: dashboard.php");
                } else {
                    header("Location: user/index1.php");
                }
                exit();
            } else {
                $message = "Username or password might be incorrect.";
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body class="">
    <div class="container-fluid">
        <div class="row">
            <?php require_once "user/cnavbar.php" ?>
        </div>

        <div class="row">
            <div class="col-md-4 mx-auto py-5">
                <form class="form bg-light" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <fieldset class="border border-1">
                        <legend> Login Here</legend>
                        <?php if (isset($message)) {
                            echo "<p class='alert alert-danger'>$message </p>";
                        }
                        ?>
                        <div class="mb-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill my-2" name="customerLogin">Login</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

</body>

</html>