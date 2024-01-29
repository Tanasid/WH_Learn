
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Factory Automation</h1>
    <hr>

    <div class="row d-flex justify-content-between">
        <div class="col-md-12 mx-auto">
            <div class="d-flex">
                <label class="fs-4 mr-3" for="">Link</label>
                <input type="text" class="form-control mr-md-5 col-md-6" id="inpLink" value="" placeholder="Link this here .." readonly>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-between mt-3">
        <div class="col-md-12 mx-auto">
            <div class="d-flex">
                <label class="fs-4 mr-3" for="">Document</label>
                <a href="" id="downloadLink" class="my-button" download><span></span>Download</a>
            </div>
        </div>
    </div>

    <div class="row mt-3" id="preview_Link">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header bg-gradient-light py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Videos</h6>
                </div>
                <div class="card-body bg-gradient-light">
                    <div class="video-content embed-responsive embed-responsive-16by9 d-flex justify-content-center">
                        <video class="border-pill embed-responsive-item" id="videoContent" controls>
                            <source src="" type="video/mp4">
                        </video>
                    </div>
                </div>
                <div class="card-footer bg-gray-100 d-flex justify-content-end fs-5">
                    <code id="name_content"></code>
                </div>
            </div>
        </div>
    </div>

</div>