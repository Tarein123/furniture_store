<?php
require_once("db.php");
session_start();

// Show delete success message once
if (isset($_SESSION['delete_success'])) {
    $delete_success = $_SESSION['delete_success'];
    unset($_SESSION['delete_success']);
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    if (isset($_SESSION['user']) && $_SESSION['user']['user_id'] == $deleteId) {
        echo "<script>alert('You cannot delete your own account.');</script>";
    } else {
        try {
            $stmt = $conn->prepare("DELETE FROM user WHERE user_id = ?");
            $stmt->execute([$deleteId]);
            $_SESSION['delete_success'] = "User deleted successfully.";
            header("Location: userManage.php");
            exit;
        } catch (PDOException $e) {
            echo "Error deleting user: " . $e->getMessage();
        }
    }
}

// Fetch all users
try {
    $stmt = $conn->prepare("SELECT user_id, username, email, password, phone, address, created_at, profile_path FROM user");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching users: " . $e->getMessage();
    $users = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        .profile-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #dee2e6;
        }

        .table thead th {
            vertical-align: middle;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container-fluid">
        <div class="row mt-3" style="min-height: 100vh;">

            <?php require_once "sidebar.php"; ?>

            <div class="col-md-10 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-semibold">User Management</h3>
                </div>

                <?php if (!empty($delete_success)) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $delete_success ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (count($users) > 0) : ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>User ID</th>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?= $user['user_id'] ?></td>
                                        <td>
                                            <?php if ($user['profile_path']) : ?>
                                                <img src="user/<?= htmlspecialchars($user['profile_path']) ?>" width="50" height="50" style="object-fit: cover; border-radius: 50%;">
                                            <?php else : ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= htmlspecialchars($user['phone']) ?></td>
                                        <td><?= htmlspecialchars($user['address']) ?></td>
                                        <td><?= date("M d, Y", strtotime($user['created_at'])) ?></td>
                                        <td>
                                            <?php if (!isset($_SESSION['user']) || $_SESSION['user']['user_id'] != $user['user_id']) : ?>
                                                <a href="?delete_id=<?= $user['user_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </a>
                                            <?php else : ?>
                                                <span class="badge bg-secondary">Logged in</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <div class="alert alert-warning">No users found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>