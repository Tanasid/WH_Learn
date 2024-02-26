
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between my-3">
        <h1 class="h3 mb-2 text-gray-800">Manage Account</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#callMdlAdd">Add Account <i class="fas fa-user-check ml-2"></i></button>
    </div>
    <hr>
    <div class="card mx-auto shadow-sm" style="width: 90%;">
        <div class="card-header text-primary fs-5 fw-bold text-decoration-underline bg-white">
            Account List
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover align-self-center w-100" id="tblManageAccount">
                <thead class="table-light">
                    <tr>
                        <th class="text-center text-dark" style="--bs-text-opacity: .8;">No.</th>
                        <th class="text-center text-dark" style="--bs-text-opacity: .8;">Emp Code</th>
                        <th class="text-center text-dark" style="--bs-text-opacity: .8;">Group</th>
                        <th class="text-center text-dark" style="--bs-text-opacity: .8;">Department</th>
                        <th class="text-center text-dark" style="--bs-text-opacity: .8;">Name</th>
                        <th class="text-center text-dark" style="--bs-text-opacity: .8;">Email</th>
                        <th class="text-center text-dark" style="--bs-text-opacity: .8;">Status</th>
                        <th class="text-center text-dark" style="--bs-text-opacity: .8;">Action</th>
                    </tr>
                <tbody id="tbody" class="">

                </tbody>
                </thead>
            </table>
        </div>
    </div>

</div>

<!-- Modal Add Account -->
<div class="modal fade" id="callMdlAdd" tabindex="-1" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-3 text-primary text-decoration-underline">Add Account</h5>
                <button type="button" id="closeAddAcc" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form -->
                <form id="formAddAcc">
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="inpEmpCode" class="form-label col-3 fs-4">Employee Code</label>
                        <input type="text" class="form-control" id="inpEmpCode">
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="inpEmpPassword" class="form-label col-3 fs-4">Password</label>
                        <input type="password" class="form-control" id="inpEmpPassword">
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="selPermissionAdd" class="form-label col-3 fs-4">Permission Group</label>
                        <select class="form-select" id="selPermissionAdd"></select>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="selDeptAdd" class="form-label col-3 fs-4">Department</label>
                        <select class="form-select" id="selDeptAdd"></select>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="inpFirstName" class="form-label col-3 fs-4">First Name</label>
                        <input type="text" class="form-control" id="inpFirstName">
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="inpLastName" class="form-label col-3 fs-4">Last Name</label>
                        <input type="text" class="form-control" id="inpLastName">
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="inpEmail" class="form-label col-3 fs-4">Email</label>
                        <input type="email" class="form-control" id="inpEmail">
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="selPlantAdd" class="form-label col-3 fs-4">Plant</label>
                        <select class="form-select" id="selPlantAdd"></select>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-danger mr-5" id="closeAddAcc" data-bs-dismiss="modal">Close</button>
                        <a id="saveChanges" class="btn btn-success ml-5">Save Changes</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Confirmation UpdateStatus Modal -->
<div class="modal fade" id="mdlStatus" tabindex="-1" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status Flag (Users)</h5>
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

<!-- Modal Edit Account -->
<div class="modal fade" data-bs-keyboard="false" id="mdlEdit" tabindex="-1" aria-labelledby="mdlEdit" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-3 text-decoration-underline" style="color: #ffc40c;" id="mdlEdit">Edit Account</h5>
                <button type="button" class="btn-close" id="closeMdlEdit" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="mdlFormEdit">
                <!-- Form -->

            </div>
        </div>
    </div>
</div>