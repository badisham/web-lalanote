<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src='../js/sweet-alert.js'></script>

<?php
require '../connect-db.php';
if (isset($_GET['id']) && isset($_GET['delete'])) {
    $result = mysqli_query($conn, "DELETE FROM ms_reward WHERE id ='" . $_GET['id'] . "' ");
    echo "<script>history.go(-1)</script>";
}
?>