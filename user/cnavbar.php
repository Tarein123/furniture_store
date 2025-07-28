<!-- MAIN NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container-fluid px-4">
    <a class="navbar-brand fw-bold fs-3 text-success" href="#">Furn</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-3">
        <li class="nav-item"><a class="nav-link" href="../index1.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="user/viewtest.php">Shop</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
        <li class="nav-item"><a class="nav-link" href="#">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
      </ul>

      <form class="d-flex me-3" method="get" action="viewItem.php">
        <input class="form-control me-2" type="search" name="wSearch" placeholder="Search..." />
        <button class="btn btn-outline-success" type="submit" name="bSearch">
          🔍
        </button>
      </form>

      <a class="btn btn-outline-danger" href="customerLogout.php">Logout</a>
    </div>
  </div>
</nav>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">