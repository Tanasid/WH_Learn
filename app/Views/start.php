<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= $title_page ?></title>

    <!-- Custom fonts for this template-->
    <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/assets/css/mngMenu.css" rel="stylesheet">
    <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- <link src="/assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet"></link> -->
    <link src="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!--Side Bar-->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion position-sticky" id="accordionSidebar">
            <!-- Your sidebar content here -->
            <?= view('page/sidebar') ?>
        </ul>

        <!--End Side Bar-->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <div class="">
                <?= view('page/topbar'); ?>
            </div>
            <!-- Main Content -->
            <div class="" id="content">

                <!-- Topbar -->
                <!-- End of Topbar -->

                <!-- Content -->
                <?= $content ?>
                <!-- End Content -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?= view('page/footer'); ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="/assets/js/menuPermission.js"></script>

    <!-- <script src="/assets/vendor/jquery/jquery.min.js"></script> -->
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->


    <!-- <script src="/assets/vendor/datatables/jquery.dataTables.min.js"></script> -->
    <!-- <script src="/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script> -->

    <!-- Page level custom scripts -->


    <!-- My js -->
    
    <?= $anotherJS ?>



</body>

</html>