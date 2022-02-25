<?php
define('TITLE', "Contact Us");
require '../env.php';
include '../layouts/header.php';
check_logged_in();
?>

<div>
  User Dashboard
</div>
<div>
  Welcome <?php echo $_SESSION['username']; ?>
</div>

<?php
include '../layouts/footer.php';
?>