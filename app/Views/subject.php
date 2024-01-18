<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between my-3">
        <h1 class="h3 mb-2 text-gray-800">System Subject</h1>
    </div>
    <hr>

    <div class="mx-auto" style="width: 90%;">
        <div class="d-flex justify-content-end iconHover">
            <button class="btn btn-none border border-light-emphasis shadow-sm rounded" id="btnAdd" data-bs-toggle="modal" data-bs-target="#callMdlAdd">Add Subject</button>
        </div>
    </div>


    <div class="card mt-3 mx-auto shadow" style="width: 90%;">
        <div class="card-header text-primary fs-5 fw-bold text-decoration-underline bg-white">
            Subject List
        </div>

        <div class="card-body">
            <table class="table table-striped table-hover align-self-center w-100" id="tblSubject">
                <thead class="table-light"">
                    <th class=" text-center text-dark" style="--bs-text-opacity: .8;">No.</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Subject Name</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Method</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Link</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Document</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Status</th>
                    <th class="text-center text-dark" style="--bs-text-opacity: .8;">Action</th>
                </thead>
                <tbody id="tbody" class="">

                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Add Subject  -->
<div class="modal fade bg-dark" id="callMdlAdd" tabindex="-1" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-3 text-primary text-decoration-underline">Add Subject</h5>
                <button type="button" id="closeAddSubject" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form -->
                <form id="formAddSubject" enctype="multipart/form-data">
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="inpSubjectName" class="form-label col-3 fs-4">Subject Name</label>
                        <input type="text" class="form-control" id="inpSubjectName">
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="inpMethod" class="form-label col-3 fs-4">Method</label>
                        <input type="text" class="form-control" id="inpMethod">
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="document" class="form-label col-3 fs-4">Document</label>
                        <input type="file" class="form-control" id="document"></input>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-danger mr-5" id="closeAddSubject" data-bs-dismiss="modal">Close</button>
                        <a id="saveChanges" class="btn btn-success ml-5">Save</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9" id="contentPreview">
                    <!-- <img src="" alt="Image Preview" id="imagePreview" class="img-fluid"> -->
                    <iframe src="" frameborder="0" style="object-fit: contain;" class="embed-responsive-item" title="Document" width="100%" height="100%" id="imagePreview" allowfullscreen></iframe>
                    <!-- <div class="hover-text">Click to open new tap ...</div> -->
                </div>
            </div>
            <div class="modal-footer">
                <div class="iconHover">
                    <button type="button" class="btn btn-none border border-light-emphasis shadow-sm rounded " id="btn_newTap">Open New Tap</button>
                </div>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Subject Modal -->
<div class="modal fade" data-bs-keyboard="false" id="mdlEditSubject" tabindex="-1" aria-labelledby="mdlEditSubject" aria-hidden="true" data-bs-backdrop="none">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-3 text-decoration-underline" style="color: #ffc40c;">Edit Subject</h5>
                <button type="button" class="btn-close" id="closeMdlEditSubject" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="mdlFormEditSubject">
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
                <h5 class="modal-title" id="exampleModalLabel">Update Status Flag (Subject)</h5>
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