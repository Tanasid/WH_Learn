<?php
$session = session();
if ($session->has('altLogin')) {
    echo $session->get('altLogin');
    $session->remove('altLogin');
}
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Dashboard</h1>
    <!-- <p class="mb-4">Chart.js is a third party plugin that is used to generate the charts in this theme.
        The charts below have been customized - for further customization options, please visit the <a target="_blank" href="https://www.chartjs.org/docs/latest/">official Chart.js
            documentation</a>.</p> -->

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center px-4">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                TOTAL USERS</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="text_user"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center px-4">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Earnings (Annual)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center px-4">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tasks
                                <div class="h5 mb-0 font-weight-bold text-gray-800">-</div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center px-4">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                View Page
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="text_view"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-desktop fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-8 mx-auto">
            <!-- Area Chart -->
            <!-- <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Videos</h6>
                </div>
                <div class="card-body">
                    <div class="video-content d-flex justify-content-center">
                        <iframe class="border-pill" width="70%" height="530" src="https://www.youtube.com/embed/z3Y5gJWmVVU" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="card-footer">
                    Styling for the area chart can be found in the
                    <code>Are you ready for learning ??</code>
                </div>
            </div> -->

            <!-- <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Videos</h6>
                </div>
                <div class="card-body">
                    <div class="video-content d-flex justify-content-center">
                        <iframe class="border-pill" width="70%" height="530" src=https://www.youtube.com/embed/K7EivjQY0KE?si=fBUXIxOqIiWWTmOv" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="card-footer">
                    Styling for the area chart can be found in the
                    <code>Are you ready for learning ??</code>
                </div>
            </div> -->

        </div>
    </div>
    
</div>