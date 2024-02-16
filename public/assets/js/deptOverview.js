$(() => {

    showSelDepartment()
    searchDep()

    function showSubList(deptID) {
        $('#info_head').text($('#selDepartment option:selected').text());
        $.ajax({
            method: "get",
            url: "/departmentOverview/showProgress",
            data: { deptID: deptID },
            dataType: 'Json',
            success: (response) => {
                // console.log(response);
                if (response.length > 0) {
                    var html = "";
                    for (let i = 0; i < response.length; i++) {
                        let progression;
                        const data = response[i];
                        progression = data.summary;
                        // console.log(statusGet);
                        if (progression <= 100 && progression >= 80) {
                            progression = `<div class="d-flex justify-content-center col-auto">
                            <div class="progress my-2 w-50 mr-3 shadow-sm">
                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: ${data.summary}%" aria-valuenow="${data.summary}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold my-2 text-success"><span class="">${data.summary}%</span></h4>
                        </div>`
                        } else if (progression <= 79 && progression >= 50) {
                            progression = `<div class="d-flex justify-content-center col-auto">
                            <div class="progress my-2 w-50 mr-3 shadow-sm">
                                <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: ${data.summary}%" aria-valuenow="${data.summary}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold my-2 text-warning"><span class="">${data.summary}%</span></h4>
                        </div>`
                        } else if (progression <= 49 && progression >= 1) {
                            progression = `<div class="d-flex justify-content-center col-auto">
                            <div class="progress my-2 w-50 mr-3 shadow-sm">
                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: ${data.summary}%" aria-valuenow="${data.summary}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold my-2 text-danger"><span class="">${data.summary}%</span></h4>
                        </div>`
                        } else {
                            progression = `<div class="d-flex justify-content-center col-auto">
                            <div class="progress my-2 w-50 mr-3 shadow-sm">
                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold my-2 text-danger"><span class="">0%</span></h4>
                        </div>`
                        }
                        html += `
                            <tr>
                                <td>
                                    <div class="mt-2" style="--bs-text-opacity: .8;">${i + 1}</div>
                                </td>
                                <td>
                                    <div class="mt-2" style="--bs-text-opacity: .8;">${data.su_emp_code}</div>
                                </td>
                                <td>
                                    <div class="mt-2" style="--bs-text-opacity: .8;">${data.ss_subject_name}</div>
                                </td>
                                <td>${progression}</td>
                            </tr>`;
                        $("#tbody").empty();
                        $('#tblOwn').dataTable().fnDestroy()
                        $("#tbody")
                            .html(html)
                            .promise()
                            .done(() => {
                                $("#tblOwn").dataTable({
                                    scrollX: true,
                                    responsive: true
                                });

                            });
                    }


                } else {
                    $('#tblOwn').dataTable().fnDestroy()
                    $("#tbody").empty();
                    html += `<tr>
                                <td class="fs-5" colspan="4"> Not found data ...</td>
                             </tr>`;
                    $("#tbody").html(html);
                }
            },
            // error: (err) => {
            //     console.log(err);
            // },

        });

    };

    function populateDeptOptions() {
        let optionsHTML = '<option value="">Please Select Department ..</option>';

        $.ajax({
            url: '/departmentOverview/getDepartment',
            method: 'GET',
            dataType: 'json',
            async: false, // Wait for the response before continuing
            success: function (response) {
                for (let i = 0; i < response.length; i++) {
                    const dept = response[i];
                    optionsHTML += `<option value="${dept.sd_id}" >${dept.sd_department_name}</option>`;
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
        return optionsHTML;
    }

    function showSelDepartment() {
        $('#selDepartment').html(populateDeptOptions());
    }

    function searchDep() {
        $(document).on('click', '#btnSearch', function () {
            var selDepartment = $('#selDepartment').val();
            if (selDepartment === '') {
                Swal.fire({
                    icon: 'warning',
                    iconColor: "#FF6666",
                    title: 'Department Required',
                    text: 'Please Select Department ...',
                });
                return;
            }
            showSubList(selDepartment)
        })
    }

})