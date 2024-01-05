$(() => {

    showSelDepartment()
    searchDep()
    updateStatusFlg()

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
            $('#selSubject').html(populateSubjectOptions());
            $("#search_box").show();
            $("#form_table").show();
            refleshTable()
        })
    }

    function populatePermisOptions() {
        let optionsHTML = '<option value="">Please Select Department...</option>'; // Initialize the options HTML

        // AJAX call to fetch plant data
        $.ajax({
            url: '/infoSubject/getDepartment',
            method: 'GET',
            dataType: 'json',
            async: false, // Wait for the response before continuing
            success: function (response) {
                for (let i = 0; i < response.length; i++) {
                    const department = response[i];
                    // const isSelected = mainMenu.mpc_id === selectedSmmId ? 'selected' : '';
                    optionsHTML += `<option value="${department.sd_id}" >${department.sd_department_name}</option>`;
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });

        return optionsHTML; // Return the generated options HTML
    }

    function showSelDepartment() {
        $('#selDepartment').html(populatePermisOptions());
    }

    function populateSubjectOptions(selectedSubId) {
        let optionsHTML = ''; // Initialize the options HTML

        // AJAX call to fetch plant data
        $.ajax({
            url: '/infoSubject/getSubject',
            method: 'GET',
            data: { ss_id: selectedSubId },
            dataType: 'json',
            async: false, // Wait for the response before continuing
            success: function (response) {
                for (let i = 0; i < response.length; i++) {
                    const subject = response[i];
                    const isSelected = subject.ss_id === selectedSubId ? 'selected' : '';
                    optionsHTML += `<option value="${subject.ss_id}" >${subject.ss_subject_name}</option>`;
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });

        return optionsHTML; // Return the generated options HTML
    }

    function refleshTable() {
        var selDepartment = $('#selDepartment').val();
        $.ajax({
            method: "get",
            url: "/infoSubject/getDepById",
            data: { ss_id: selDepartment },
            dataType: 'Json',
            success: (response) => {
                // console.log(response);
                if (response.length > 0) {
                    var html = "";
                    for (let i = 0; i < response.length; i++) {
                        const data = response[i];
                        var btnStatus
                        // fetchSwitchID(data.ss_id, function (statusFlg) {
                        const statusGet = data.iss_status_flg;
                        // console.log(statusGet+' '+data.iss_id);
                        if (statusGet == 1) {
                            btnStatus = `<button class="custom-btn btn-3 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.iss_id}" data-id="${statusGet}"><span>Enable</span></button>`
                        } else {
                            btnStatus = `<button class="custom-btn btn-5 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.iss_id}" data-id="${statusGet}"><span>Disable</span></button>`
                        }
                        html += `
                            <tr>
                                <td class="text-center">${i + 1}</td>
                                <td class="text-center">${data.sd_department_name}</td>
                                <td class="text-center">${data.ss_subject_name}</td>
                                <td class="text-center">${btnStatus}</td>
                            </tr>`;
                        $('#tblSubject').dataTable().fnDestroy()
                        $("#tbody")
                            .html(html)
                            .promise()
                            .done(() => {
                                $("#tblSubject").dataTable({
                                    scrollX: true,
                                    responsive: true
                                });

                            });

                        // })
                    }
                }

            },

        });
    }


    function updateStatusFlg() {
        $(document).on('click', '#statusFlg', function () {
            var iss_id = $(this).closest('td').find('.btnStatus').val();
            var iss_status_flg = $(this).attr('data-id');
            // console.log(iss_id +" "+ iss_status_flg );
            // return;
            $('#confirmUpdate').on('click', function () {
                if (iss_id) {
                    // Perform the update via AJAX
                    $.ajax({
                        type: "POST",
                        url: "/infoSubject/updateStatusFlg", // Replace with your server endpoint to update the state
                        data: { iss_id: iss_id, iss_status_flg: iss_status_flg },
                        dataType: 'json',
                        success: function (response) {
                            // console.log(response);
                            Swal.fire({
                                title: 'Success!',
                                text: 'Updated Status Successfully.',
                                icon: 'success'
                            }).then(() => {
                                $('#mdlStatus').modal('hide');
                                refleshTable();
                            });
                        },
                        error: function () {
                            Swal.fire({
                                title: 'Errors!',
                                text: 'Updated Status Errors!.',
                                icon: 'error'
                            })
                            $('#mdlStatus').modal('hide');
                        }
                    });
                }
                iss_id = null;
                iss_status_flg = null;
            });

            $('#cancleUpdateFlg').on('click', function () {
                iss_id = null;
                iss_status_flg = null;

                // console.log(su_flg +" "+ su_id_flg );
            });

            $('#mdlStatus').on('hidden.bs.modal', function () {
                // Clear the data in the modal
                iss_id = null;
                iss_status_flg = null;
                // console.log(su_flg +" "+ su_id_flg );
            });

        });
    }

})