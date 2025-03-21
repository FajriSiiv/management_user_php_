<?php
session_start();
include("../layout/navbar.php") ?>


<form class="w-50 mx-auto pt-5" method="POST" action="../actions/signup_action.php">
  <h2 class="text-2xl fw-bold mb-5">Sign Up</h2>
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" name="username" class="form-control" id="username" />
    <div class="form-text">We'll never share your username with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="password" />
  </div>
  <div class="text-end">
    <button type="submit" class="btn btn-primary">Sign Up</button>
  </div>
  <?php if (isset($_SESSION['err_message'])): ?>
    <div class="text-center">
      <p class="text-error"><?php echo $_SESSION['err_message'];
      unset($_SESSION['err_message']); ?></p>
    </div>
  <?php endif; ?>

</form>


<?php include("../layout/footer.php") ?>