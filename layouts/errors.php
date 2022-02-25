<?php
if (isset($_SESSION['ERRORS'])) {
  $errors = $_SESSION['ERRORS'];
  foreach ($errors as $errkey => $error) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong><?php echo $error ?></strong>
      <button type="button" class="close float-end bg-transparent border-0" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
<?php
  }
}
?>