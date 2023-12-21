<div class="container-fluid">

    <div class="row d-flex justify-content-between my-3">
        <div class="col-md-12 mx-auto">
            <label class="h3 mb-2 text-gray-800" for="">Info Subject</label>
            <div class="d-flex">
                <select type="text" class="form-select mr-md-5 col-md-6" id="selDepartment"></select>
                <button class="btn btn-primary px-4 rounded" id="btnSearch">Search</button>
                <!-- <button class="btn btn-warning px-4 rounded ml-5" id="" data-bs-toggle="modal" data-bs-target="#mdlEditPermisGroup">Edit</button> -->
            </div>
        </div>
    </div>
    <hr>

    <div class="row d-flex justify-content-between">
        <div class="col-md-6" style="display:none;" id="search_box">
            <label class="fs-4" for="selSubject">Subject</label>
            <div class="d-flex iconHover"">
                <select type="text" class="form-select" id="selSubject">
                <option value="">Please Select Subject ...</option>
                </select>
                <button class="btn btn-none border border-light-emphasis shadow-sm rounded ml-3" id="btnAdd">Add</button>
            </div>
        </div>
    </div>

    <div class="card mt-5 mx-auto" id="form_table" style="display:none; width: 90%;">
        <div class="card-header text-primary fs-5 fw-bold text-decoration-underline bg-white">
            Info Subject List
        </div>

        <div class="card-body">
            <table class="table table-striped table-hover align-self-center w-100" id="tblSubject">
                <thead class="table-light"">
                    <th class=" text-center text-dark" style="--bs-text-opacity: .8;">No.</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Department Name</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Subject</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Status</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Action</th>
                </thead>
                <tbody id="tbody" class="">

                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Confirmation UpdateStatus Modal -->
<div class="modal fade" id="mdlStatus" tabindex="-1" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status (Info Subject)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="cancleUpdateFlg"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to update the status ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancleUpdateFlg">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmUpdate">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Info Subject Modal -->
<div class="modal fade" data-bs-keyboard="false" id="mdlEditInfoSubject" tabindex="-1" aria-labelledby="mdlEditInfoSubject" aria-hidden="true" data-bs-backdrop="none">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-3 text-decoration-underline" style="color: #ffc40c;">Edit Info Subject</h5>
                <button type="button" class="btn-close" id="closeMdlEditSubject" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="mdlFormEditInfoSubject">
                <!-- Form -->

            </div>
        </div>
    </div>
</div>