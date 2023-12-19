$(() => {

    addSubject()
    showSubject()
    updateStatusFlg()
    preview()

    

    function showSubject() {
        $.ajax({
            method: "get",
            url: "/subject/getSubject",
            dataType: 'Json',
            success: (response) => {
                // console.log(response);
                // return;
                if (response.length > 0) {
                    var html = "";
                    for (let i = 0; i < response.length; i++) {
                        // console.log(response);
                        // return;
                        const data = response[i];
                        var btnStatus
                        fetchSwitchID(data.ss_id, function (statusFlg) {
                            const statusGet = statusFlg[0];
                            // console.log(statusGet);
                            if (statusGet['ss_status_flg'] == 1) {
                                btnStatus = `<button class="custom-btn btn-3 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.ss_id}" data-id="${statusGet['ss_status_flg']}"><span>Enable</span></button>`
                            } else {
                                btnStatus = `<button class="custom-btn btn-5 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.ss_id}" data-id="${statusGet['ss_status_flg']}"><span>Disable</span></button>`
                            }
                            html += `
                            <tr>
                                <td class="text-center">${i + 1}</td>
                                <td class="text-center">${data.ss_subject_name}</td>
                                <td class="text-center">${data.ss_method}</td>
                                <td class="text-center">
                                    <button data-toggle="modal" data-target="#imageModal" id="btn_Image" data-id="${data.ss_document}" class="custom-btn btn-1 mr-3"><span><i class="fas fa-search fa-lg"></i></span></button>
                                </td>
                                <td class="text-center">${btnStatus}</td>
                                <td class="text-center">
                                    <button data-bs-toggle="modal" data-bs-target="#mdlEditDepartment" id="btnEditDep" class="custom-btn btn-12" data-id="${data.ss_id}">
                                        <span>Edit</span><span><i class="fas fa-wrench fa-lg"></i></span>
                                    </button>
                                </td>
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

                        })
                    }
                }
            },

        });

    }

    function addSubject() {
        $(document).on('click', '#saveChanges', function () {
            const inpName = $('#inpSubjectName').val().trim();
            const inpMethod = $('#inpMethod').val().trim();
            const inpDocument = $('#document')[0].files[0];
            // console.log(inpName);
            // return;
            const thaiPattern = /[\u0E00-\u0E7F]/;
            const Pattern = /[!@#$%^&*(),.?":{}|<>]/;
            Swal.fire({
                title: 'Confirm',
                text: 'Do you want to add Subject?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28b76d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {

                    if (thaiPattern.test(inpName)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please do not enter Thai characters.',
                        });
                        $('#inpSubjectName').val('');
                        return;
                    }

                    if (Pattern.test(inpName)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please do not enter Special characters.',
                        });
                        $('#inpSubjectName').val('');
                        return;
                    }

                    if (inpName === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Subject Name is required.',
                            icon: 'error'
                        });
                        return $('#inpSubjectName').focus();
                    }

                    if (thaiPattern.test(inpMethod)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please do not enter Thai characters.',
                        });
                        $('#inpMethod').val('');
                        return;
                    }

                    if (Pattern.test(inpMethod)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please do not enter Special characters.',
                        });
                        $('#inpMethod').val('');
                        return;
                    }

                    if (inpMethod === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Method is required.',
                            icon: 'error'
                        });
                        return $('#inpMethod').focus();
                    }


                    if (inpDocument == null) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Document is required.',
                            icon: 'error'
                        });
                        return $('#document').focus();
                    }

                    // Form File
                    const formData = new FormData();
                    formData.append('inpName', inpName);
                    formData.append('inpMethod', inpMethod);
                    formData.append('inpDocument', inpDocument);
                    // Log the values
                    // for (const pair of formData.entries()) {
                    //     console.log(pair[0], pair[1]);
                    // }
                    // return;

                    // User confirmed, perform the AJAX request
                    $.ajax({
                        type: 'POST',
                        url: '/subject/addSubject',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.success) {
                                // Show a success message using SweetAlert2
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    $('#inpSubjectName').val('');
                                    $('#inpMethod').val('');
                                    $('#document').val('');
                                    $('#callMdlAdd').modal('hide');
                                    showSubject();
                                });

                            } else {
                                // Show an error message using SweetAlert2
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                });
                                console.log(response);
                                $('#inpSubjectName').val('');
                                $('#inpMethod').val('');
                                $('#document').val('');
                            }
                        },
                        error: function (error) {
                            console.log('Error:', error);
                        }
                    });
                }
            });
        })
    }

    function updateStatusFlg() {
        $(document).on('click', '#statusFlg', function () {
            var ss_id = $(this).closest('td').find('.btnStatus').val();
            var ss_status_flg = $(this).attr('data-id');
            // console.log(ss_id +" "+ ss_status_flg );
            // return;
            $('#confirmUpdate').on('click', function () {
                if (ss_id) {
                    // Perform the update via AJAX
                    $.ajax({
                        type: "POST",
                        url: "/subject/updateStatusFlg", // Replace with your server endpoint to update the state
                        data: { ss_id: ss_id, ss_status_flg: ss_status_flg },
                        dataType: 'json',
                        success: function (response) {
                            // console.log(response);
                            Swal.fire({
                                title: 'Success!',
                                text: 'Updated Status Flag Successfully.',
                                icon: 'success'
                            }).then(() => {
                                $('#mdlStatus').modal('hide');
                                showSubject();
                            });
                        },
                        error: function () {
                            Swal.fire({
                                title: 'Errors!',
                                text: 'Updated Status Flag Errors!.',
                                icon: 'error'
                            })
                            $('#mdlStatus').modal('hide');
                        }
                    });
                }
                ss_id = null;
                ss_status_flg = null;
            });

            $('#cancleUpdateFlg').on('click', function () {
                ss_id = null;
                ss_status_flg = null;

                // console.log(su_flg +" "+ su_id_flg );
            });

            $('#mdlStatus').on('hidden.bs.modal', function () {
                // Clear the data in the modal
                ss_id = null;
                ss_status_flg = null;
                // console.log(su_flg +" "+ su_id_flg );
            });

        });
    }

    function editDepartment() {
        var depName;
        var oldID, oldName;

        $(document).on('click', '#btnEditDep', function () {
            var depID = $(this).attr('data-id');
            // console.log(depID);
            // return;
            $.ajax({
                type: "GET",
                url: "/department/getDepartmentByID", // Replace with your server endpoint to update the state
                data: { sd_id: depID },
                dataType: 'json',
                success: function (response) {
                    if (response.length == 1) {
                        const data = response[0];
                        var html = "";
                        depName = data.sd_department_name;
                        html += `
                        <form id="formEditDepartment">
                            <input type="hidden" id="sdID" value="${data.sd_id}">
                            <div class="row d-flex justify-content-between">
                                <input type="hidden" id="mdlEditId" value="">
                                <div class="col-md-12 mx-auto">
                                    <label class="fs-4" for="">Department Name</label>
                                    <input type="text" class="form-control" id="inpDepName" value="${data.sd_department_name}">
                                </div>
                                <div class="col-md-12 mx-auto d-flex justify-content-evenly mt-3">
                                    <a class="btn btn-outline-danger" data-bs-dismiss="modal" id="closeMdlEditDepartment">Cancle</a>
                                    <button class="btn btn-success" id="btnSaveEdit">Save Change</button>
                                </div>
                            </div>
                        </form>
                        `;
                        $('#mdlFormEditDepartment').append(html);
                        oldID = data.sd_id;
                        oldName = data.sd_department_name;
                    }

                },
                error: function () {
                    return;
                }
            });
        })

        $(document).on('click', '#btnSaveEdit', function (event) {
            event.preventDefault();
            var controlDepName = depName;
            var depId = $('#formEditDepartment #sdID').val();
            var departmentName = $('#formEditDepartment #inpDepName').val().trim();
            var checkPattern = departmentName;
            var thaiPattern = /[\u0E00-\u0E7F]/;
            const Pattern = /[!@#$%^&*(),.?":{}|<>]/;
            // console.log(permisId+" | "+permisName);
            // return;
            if (thaiPattern.test(checkPattern)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please do not enter Thai characters.',
                });
                $('#formEditDepartment #inpDepName').val(controlDepName);
                return;
            }
            if (Pattern.test(checkPattern)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please do not enter Special characters.',
                });
                $('#formEditDepartment #inpDepName').val(controlDepName);
                return;
            }
            Swal.fire({
                title: 'Confirm Save Changes',
                text: 'Are you sure you want to save the changes?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28b76d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (depId === oldID && departmentName === oldName) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'The data has not been edited.',
                    });
                    $('#mdlFormEditDepartment').empty();
                    $('#mdlEditDepartment').modal('hide');
                    return;
                }
                if (departmentName === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Department Name is required',
                    });
                    $('#formEditDepartment #inpDepName').val(controlDepName);
                    return;
                }
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '/department/updateDepartment', // Change the URL to your updateData endpoint
                        data: {
                            sd_id: depId,
                            sd_departname_name: departmentName
                            // ... other fields you want to update
                        },
                        dataType: 'json',
                        success: function (response) {
                            // console.log(response);
                            // return;
                            if (response.success) {
                                // Show a success message using SweetAlert2
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'User data updated successfully!',
                                    timer: 2500, // Set the timer for auto-closing alert
                                    showConfirmButton: true
                                }).then(function () {
                                    $('#mdlEditDepartment').modal('hide');
                                    var closeEdt = $('#mdlFormEditDepartment');
                                    closeEdt.empty();
                                    showDepartment();
                                });
                            } else {
                                // Show an error message using SweetAlert2
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                });
                                $('#formEditDepartment #inpDepName').val(controlDepName);
                            }
                        },
                        error: function (error) {
                            console.log('Error:', error);
                        }
                    });
                }
                // Perform the update via AJAX

            });

        })


        $(document).on('click', '#closeMdlEditDepartment', function () {
            var closeEdt = $('#mdlFormEditDepartment');
            closeEdt.empty();
        })

        $('#mdlEditDepartment').on('shown.bs.modal', function () {
            $(this).find('input').on('keydown', function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                }
            });
        });

    }

    function fetchSwitchID(subjectID, callback) {
        $.ajax({
            method: "get",
            url: `/subject/getSubjectByStatus`,
            data: { subjectID: subjectID },
            dataType: 'json',
            success: (response) => {
                // console.log(response);
                callback(response);
            }
        });
    }

    function preview() {
        $(document).on('click', '#btn_Image', function () {
            var imagePath = $(this).attr('data-id');
            // console.log(imagePath)
            $('#imageModal').find('#imagePreview').attr('src', imagePath);
        });

        $('#imageModal').on('hidden.bs.modal', function () {
            $(this).find('#imagePreview').attr('src', '');
            console.log($(this).find('#imagePreview').attr('src'));
        });

        $('#contentPreview').on('click', function() {
            let picture = $(this).find('#imagePreview').attr('src');
            console.log(picture);
            window.open(picture, '_blank');
            picture = ''
            console.log(picture)
        });
    }

})