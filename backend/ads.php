<?php
require './connect-db.php';
$where = '';
$is_datail = false;
if (isset($_GET['institution_id'])) {
    $institution_id = $_GET['institution_id'];
    $where = "WHERE institution_id = '$institution_id'";
    $is_datail = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    require './components/head.php'
    ?>
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src='./js/sweet-alert.js'></script>

</head>
<style>
    .img_data {
        width: 100px;
    }
</style>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        require './components/slide-bar.php'
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                require './components/nav.php'
                ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <!-- <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ผู้ใช้งาน</h6>
                        </div> -->
                        <div class="d-sm-flex p-3 align-items-center justify-content-between mb-4">
                            <h6 class="h3 mb-0 text-gray-800">โฆษณา</h1>
                                <a href="#" data-toggle="modal" data-target="#addModal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> เพิ่ม</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="50">#</th>
                                            <th width="120">รูป</th>
                                            <th width="150">ชื่อ</th>
                                            <th>รายละเอียด</th>
                                            <?php
                                            if (!$is_datail) {
                                                echo "<th>สถาบัน</th>";
                                            }
                                            ?>
                                            <th width="50"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT *,ms_ads.id as ads_id,institution.name as institution_name, ms_ads.name as ads_name FROM ms_ads INNER JOIN institution ON institution.id = ms_ads.institution_id $where";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                        ?>

                                                <tr>
                                                    <td><?= $row['ads_id'] ?></td>
                                                    <td><img class="img_data" src="<?= $row['img'] ?>" alt=""></td>
                                                    <td><a href="<?= $row['url'] ?>" target="_blank"><?= $row['ads_name'] ?></a></td>
                                                    <td><?= $row['description'] ?>
                                                    </td>

                                                    <?php
                                                    if (!$is_datail) {
                                                        echo "<td>" . $row['institution_name'] . "</td>";
                                                    }
                                                    ?>
                                                    <td>
                                                        <button class="btn btn-danger" onclick="SweetAlertOk('ต้องการลบ ?','warning','services/ads.php?id=<?= $row['ads_id'] ?>&delete=1')">ลบ</button>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <?php
            require './components/footer.php';
            ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <?php
    $sql = "SELECT * FROM `institution`";
    $result = mysqli_query($conn, $sql);
    ?>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="http://localhost:3001/ads" method="post" enctype="multipart/form-data" target="popup">
                        <div class="form-group">
                            <label for="name">name</label>
                            <input name="name" type="text" class="form-control" id="name" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="description">description</label>
                            <textarea name="description" class="form-control" id="description" placeholder=""></textarea>
                        </div>
                        <div class="form-group">
                            <label for="url">Url</label>
                            <input name="url" type="text" class="form-control" id="url" placeholder="www.test.com">
                        </div>
                        <?php
                        if ($is_datail) {
                        ?>
                            <input type="hidden" name="institution_id" value="<?= $_GET['institution_id'] ?>">
                        <?php
                        } else {
                        ?>
                            <div class="form-group">
                                <label for="institution_id">สถาบัน</label>
                                <select class="form-control" id="institution_id" name="institution_id" required>
                                    <option>เลือก</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="form-group">
                            <label for="img">Img</label>
                            <input name="file" type="file" class="form-control" id="img" placeholder="">
                        </div>

                        <button id="submit" type="submit" class="btn btn-primary">เพิ่ม</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script>
        $("#submit").click(function() {
            setTimeout(() => {

                location.reload();
            }, 50);
        });
    </script>
</body>


</html>