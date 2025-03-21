<?php
session_start();
include("../layout/navbar.php");
include('../actions/verify_id.php');

?>

<?php
echo "Dashboard" . $_SESSION["success_message"];
?>




<?php
include("../layout/footer.php");
?>