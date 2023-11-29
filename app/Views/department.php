<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between my-3">
        <h1 class="h3 mb-2 text-gray-800">Department</h1>
    </div>
    <hr>
    <div class="row d-flex justify-content-between">
        <div class="col-md-12 mx-auto">
            <label class="fs-4" for="">Department Name</label>
            <div class="d-flex iconHover">
                <input type="text" class="form-control mr-md-5 col-md-6" id="inpAddDepartment" placeholder="Please enter your Department Name ...">
                <button class="btn btn-none border border-light-emphasis shadow-sm rounded" id="btnAdd">Add Department</button>
            </div>
        </div>
    </div>

    <div class="card mt-5 mx-auto" style="width: 90%;">
        <div class="card-header text-primary fs-5 fw-bold text-decoration-underline bg-white">
            Department List
        </div>

        <div class="card-body">
            <table class="table table-striped table-hover align-self-center w-100" id="tblDepartment">
                <thead class="table-light"">
                    <th class=" text-center text-dark" style="--bs-text-opacity: .8;">No.</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Department Name</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Status</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Action</th>
                </thead>
                <tbody id="tbody" class="">

                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Edit Department Modal -->
<div class="modal fade bg-dark" data-bs-keyboard="false" id="mdlEditDepartment" tabindex="-1" aria-labelledby="mdlEditDepartment" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-3 text-decoration-underline" style="color: #ffc40c;">Edit Department</h5>
                <button type="button" class="btn-close" id="closeMdlEditDepartment" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="mdlFormEditDepartment">
                <!-- Form -->

            </div>
        </div>
    </div>
</div>

<!-- Confirmation UpdateStatus Modal -->
<div class="modal fade" id="mdlStatus" tabindex="-1" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status Flag (Department)</h5>
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