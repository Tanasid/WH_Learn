<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between my-3">
        <h1 class="h3 mb-2 text-dark">Manage Sub Menu</h1>
    </div>

    <div class="row d-flex justify-content-between">
        <div class="col-md-12 mx-auto text-gray-700">
            <label class="fs-4" for="">Select Main Menu</label>
            <div class="d-flex">
                <select type="text" class="form-select mr-md-5 col-md-6" id="selMainMenu">
                </select>
                <button class="btn btn-outline-primary rounded" id="btnSearchMain">Search</button>
            </div>
        </div>
    </div>
    <hr>
    <div class="row d-flex justify-content-between" id="formAddSub">
        <div class="my-3">
            <h1 class="h3 mb-2 text-dark">Register Menu</h1>
        </div>
        <div class="col-md-6 mx-auto text-gray-700">
            <label class="fs-4" for="">Sub Menu Name</label>
            <input type="text" class="form-control" id="inpSubMenuName" placeholder="Please select main menu ..." disabled>
        </div>
        <div class="col-md-6 mx-auto text-gray-700">
            <label class="fs-4" for="">Sub Menu Controller</label>
            <div class="d-flex">
                <input type="text" class="form-control mr-md-5 col-md-6l" id="inpSubMenuCon" placeholder="Please select main menu ..." disabled>
                <button class="btn btn-success px-3" id="btnSaveAdd">Add</button>
            </div>
        </div>
    </div>

    <div class="card mt-5 table-sub mx-auto" style="width: 90%;">
        <div class="card-header text-primary fs-5 fw-bold text-decoration-underline bg-white">
            Sub Menu List
        </div>

        <div class="card-body">
            <table class="table table-striped table-hover align-self-center w-100" id="tblSubMenu">
                <thead class="table-light"">
                    <th class=" text-center text-dark" style="--bs-text-opacity: .8;">No.</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Sub Menu</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Menu Controller</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Status</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Last Update date</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Last Update By</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Action</th>
                </thead>
                <tbody id="tbody" class="">

                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="modal fade bg-dark" data-bs-keyboard="false" id="mdlEditSubMenu" tabindex="-1" aria-labelledby="mdlEditSubMenu" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-3 text-decoration-underline" style="color: #ffc40c;">Edit Sub Menu</h5>
                <button type="button" class="btn-close" id="closeMdlEditSubMenu" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="mdlFormEditSubMenu">
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