<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include_once("template/header.php");
?>

<div class="main-panel m-4">
    <h1>index</h1>
</div>

<?php include_once("template/footer.php");
?>