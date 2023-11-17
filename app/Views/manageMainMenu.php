<div class="container-fluid bodyMainMenu">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between my-3">
        <h1 class="h3 mb-2 text-gray-800">Manage Main Menu</h1>
        <div class="mr-3">
            <button class="btn border-none col-md-12" style="background-color: #865DFF; color: #FFF;" id="saveMainMenu">Add Menu&nbsp;<i class="fas fa-icons"></i></button>
        </div>
    </div>
    <hr>
    <div class="row d-flex justify-content-between">
        <div class="col-md-6 mx-auto">
            <label class="fs-4" for="">Main Menu</label>
            <input type="text" class="form-control" id="inpMainMenuName" placeholder="Enter your name menu ...">
        </div>
        <div class="col-md-6 mx-auto">
            <label class="fs-4" for="">Main Menu Icon</label> <button class="btn btn-none" data-bs-toggle="modal" data-bs-target="#mdlICon"><i class="far fa-comment-dots fa-lg"></i></button>
            <input type="text" class="form-control" id="inpMainMenuIcon" data-bs-toggle="modal" data-bs-target="#mdlICon" placeholder="Icon name menu ..." disabled>
        </div>
    </div>

    <hr>
    <div class="card mx-auto" style="width: 90%;">
        <div class="card-header text-primary fs-5 fw-bold text-decoration-underline bg-white">
            Main Menu List
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover align-self-center w-100" id="tblMainMenu">
                <thead class="table-light"">
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">No.</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Main Menu Name</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Update Date</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Update By</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Status</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Action</th>
                </thead>
                <tbody id="tbody" class="">

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add MainMenu Icon -->
<div class="modal fade" data-bs-keyboard="false" id="mdlICon" tabindex="-1" aria-labelledby="mdlICon" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #F6F4EB;">
            <div class="modal-header">
                <h5 class="modal-title fs-3 text-decoration-underline ml-3" style="color: #865DFF;" id="mdlICon">Icon List</h5>
                <button type="button" class="btn-close" id="closeMdlEdit" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="" id="iconList">
                    <!----------- Pleace Icon Here !! ------------>
                    <?php echo view('page/icon.php'); ?>
                </div>
            </div>
            <div class="modal-footer">
                <h3 class="modal-title fs-5 text-decoration-underline d-flex justify-content-end" style="color: #865DFF;" id="mdlICon">Please Select Icon</h3>
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit MainMenu Icon -->
<div class="modal fade" data-bs-keyboard="false" id="mdlEditICon" tabindex="-1" aria-labelledby="mdlEditICon" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #F6F4EB;">
            <div class="modal-header">
                <h5 class="modal-title fs-3 text-decoration-underline ml-3" style="color: #865DFF;" id="mdlEditICon">Icon List Edit</h5>
                <button type="button" class="btn-close" id="closeMdlEditIcon" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="" id="iconListEdit">
                    <!----------- Pleace Icon Here !! ------------>
                    <?php echo view('page/icon.php'); ?>
                </div>
            </div>
            <div class="modal-footer">
                <h3 class="modal-title fs-5 text-decoration-underline d-flex justify-content-end" style="color: #865DFF;" id="mdlICon">Please Select Icon</h3>
            </div>
        </div>
    </div>
</div>


<!-- Confirmation UpdateStatus Modal -->
<div class="modal fade" id="mdlStatus" tabindex="-1" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status Flag (Main Menu)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="cancleUpdateFlg"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to update the status flag?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancleUpdateFlg">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmUpdate">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Mainmenu -->
<div class="modal fade bg-dark" data-bs-keyboard="false" id="mdlEditMainMenu" tabindex="-1" aria-labelledby="mdlEditMainMenu" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-3 text-decoration-underline" style="color: #ffc40c;">Edit Main Menu</h5>
                <button type="button" class="btn-close" id="closeMdlEditMainMenu" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="mdlFormEditMainMenu">
                <!-- Form -->
            </div>
        </div>
    </div>
</div>