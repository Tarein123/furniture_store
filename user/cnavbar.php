<?php
require_once "db.php";

$profile = null;

if (isset($_SESSION['customerEmail'])) {
  $email = $_SESSION['customerEmail'];
  $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
  $stmt->execute([$email]);
  $profile = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- MAIN NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container-fluid px-4">
    <a class="navbar-brand fw-bold fs-3 text-success" href="#">Furn</a>

    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-3 text-center">
        <li class="nav-item"><a class="nav-link" href="index1.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="viewtest.php">Shop</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
      </ul>

      <form class="d-flex me-3" method="get" action="viewItem.php">
        <input class="form-control me-2" type="search" name="wSearch" placeholder="Search..." style="width: 400px;" />
        <button class="btn btn-outline-success" type="submit" name="bSearch">🔍</button>
      </form>

      <?php if ($profile): ?>
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?= htmlspecialchars($profile['profile_path'] ?? 'profile/default.png') ?>" alt="Profile" width="40" height="40" class="rounded-circle border object-fit-cover" style="object-fit: cover;">
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 p-3" aria-labelledby="profileDropdown" style="min-width: 260px;">

            <!-- Profile Header -->
            <li class="text-center mb-3">
              <img src="<?= htmlspecialchars($profile['profile_path'] ?? 'profile/default.png') ?>" alt="Profile" class="rounded-circle border" width="70" height="70" style="object-fit: cover;">
              <div class="mt-2">
                <strong><?= htmlspecialchars($profile['username']) ?></strong><br>
                <small class="text-muted"><?= htmlspecialchars($profile['email']) ?></small>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <!-- Info Rows -->
            <li class="px-2"><strong>📞 Phone:</strong> <?= htmlspecialchars($profile['phone']) ?></li>
            <li class="px-2"><strong>🔒 Password:</strong> ••••••••</li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <!-- Action Links -->
            <li><a href="orderHistory.php" class="dropdown-item"><i class="bi bi-receipt"></i> Order History</a></li>
            <li><a href="customerLogout.php" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
          </ul>
        </div>
      <?php endif; ?>

    </div>
  </div>
</nav>

<style>
  .dropdown-menu li {
    font-size: 14px;
  }

  .dropdown-menu .dropdown-item:hover {
    background-color: #f8f9fa;
  }
</style>

<!-- Bootstrap CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>