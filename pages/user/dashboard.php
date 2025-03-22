<?php
session_start();
include("../../layout/navbar.php");
include('../../actions/verify_id.php');

?>

<div class="mt-4">
  <h2>Dashbord User <?php echo $_SESSION['success_message'] ?></h2>

</div>




<?php
include("../../layout/footer.php");
?>