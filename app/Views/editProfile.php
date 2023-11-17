<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between my-3">
        <h1 class="h3 mb-2 text-gray-800">Edit Profile</h1>
    </div>
    <hr>

    <div class="container w-50">
        <form id="editProfileForm">
            <div class="mb-3">
                <label for="emp_code" class="form-label">Employee Code</label>
                <input type="text" class="form-control" id="emp_code" name="emp_code" readonly>
            </div>
            <div class="mb-3">
                <label for="su_firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="su_firstname" name="su_firstname">
            </div>
            <div class="mb-3">
                <label for="su_lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="su_lastname" name="su_lastname">
            </div>
            <div class="mb-3">
                <label for="su_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="su_email" name="su_email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="d-flex justify-content-between iconHover">
                    <input type="password" class="form-control w-75 mr-3" id="password" name="password" disabled>
                    <button type="button" class="btn btn-none border border-light-emphasis shadow-sm rounded" data-bs-toggle="modal" data-bs-target="#mdlNewPassword" id="newPasswordBtn">Edit Password</button>
                </div>
            </div>
            <div class="mb-3">
                <label for="mpc_id" class="form-label">Plant</label>
                <select class="form-select" id="selPlantAdd">
                </select>
            </div>
            <div class="mb-3">
                <label for="spg_id" class="form-label">Permissin Group</label>
                <select class="form-select" id="selPermis" disabled></select>
            </div>
            <div class="mb-3">
                <label for="status_flg" class="form-label">Status</label>
                <select class="form-select" id="status_flg" disabled>
                </select>
            </div>

            <button type="button" class="btn btn-success" id="editButton">Save Change</button>
        </form>
    </div>

</div>


<!-- Modal New Password -->
<div class="modal fade bg-dark" data-bs-keyboard="false" id="mdlNewPassword" tabindex="-1" aria-labelledby="mdlNewPassword" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-3 text-decoration-underline" style="color: #FF9EAA;" id="mdlEdit">New Password</h5>
                <button type="button" class="btn-close" id="mdlClose" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="inpEmpCode" class="form-label col-3 fs-4">New Password</label>
                        <input type="text" class="form-control" id="inpNewPassword" value="" require >
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="inpEmpPassword" class="form-label col-3 fs-4">Confirm Password</label>
                        <input type="text" class="form-control" id="inpConfirmPassword" value="" require>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-danger mr-5" id="mdlClose" data-bs-dismiss="modal">Close</button>
                        <a id="saveNewPassword" class="btn btn-success ml-5">Save New Password</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>