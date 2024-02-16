<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Department Overview (Admin)</h1>
    <hr>
    <div class="d-flex mt-3 ml-md-3">
        <label class="fs-5 mr-3" for="selSubject">Department</label>
        <select type="text" class="form-select mr-md-5 col-md-3" id="selDepartment"></select>
        <button class="btn btn-primary px-4 rounded" id="btnSearch">Search</button>
    </div>
    <div class="card mx-auto shadow-sm mt-3" style="width: 90%;">
        <div class="card-header text-primary fs-5 fw-bold text-decoration-underline bg-white" id="info_head">
            Infomation
        </div>
        <div class="card-body">
            <table class="table table-bordered w-100" id="tblOwn">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center text-dark col-1" style="--bs-text-opacity: .8;">No.</th>
                        <th class="text-center text-dark col-2" style="--bs-text-opacity: .8;">Emp Code</th>
                        <th class="text-center text-dark col-5" style="--bs-text-opacity: .8;">Subject Name</th>
                        <th class="text-center text-dark col-auto" style="--bs-text-opacity: .8;">Status</th>
                    </tr>
                </thead>
                <tbody id="tbody" class="text-center mb-2">
                </tbody>
            </table>
        </div>
    </div>


</div>