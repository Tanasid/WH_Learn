$(() => {

    showPermisGroup()
    addPermisGP()
    editPermisGP()
    updateStatusFlg()

    function showPermisGroup() {
        $.ajax({
            method: "get",
            url: "/managePermissionGroup/getPermisGroup",
            dataType: 'Json',
            success: (response) => {
                // console.log(response);
                if (response.length > 0) {
                    var html = "";
                    for (let i = 0; i < response.length; i++) {
                        const data = response[i];
                        var btnStatus
                        fetchSwitchID(data.spg_id, function (statusFlg) {
                            const statusGet = statusFlg[0];
                            // console.log(statusGet);
                            if (statusGet['spg_status_flg'] == 1) {
                                btnStatus = `<button class="custom-btn btn-3 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.spg_id}" data-id="${statusGet['spg_status_flg']}"><span>Enable</span></button>`
                            } else {
                                btnStatus = `<button class="custom-btn btn-5 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.spg_id}" data-id="${statusGet['spg_status_flg']}"><span>Disable</span></button>`
                            }
                            html += `
                            <tr>
                                <td class="text-center">${i + 1}</td>
                                <td class="text-center">${data.spg_name}</td>
                                <td class="text-center">${data.spg_updated_date}</td>
                                <td class="text-center">${data.spg_updated_by}</td>
                                <td class="text-center">${btnStatus}</td>
                                <td class="text-center">
                                    <button data-bs-toggle="modal" data-bs-target="#btnEditPermisGroup" id="btnEditPermisGP" class="custom-btn btn-12" data-id="${data.spg_id}">
                                        <span>Edit</span><span><i class="fas fa-wrench fa-lg"></i></span>
                                    </button>
                                </td>
                            </tr>`;
                            $('#tblPermisGP').dataTable().fnDestroy()
                            $("#tbody")
                                .html(html)
                                .promise()
                                .done(() => {
                                    $("#tblPermisGP").dataTable({
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

    function addPermisGP() {
        $(document).on('click', '#btnSaveAdd', function () {
            const inpName = $('#inpPermisGroup').val().trim();
            // console.log(inpName + " " + inpIconName);
            const checkPattern = inpName;
            const thaiPattern = /[\u0E00-\u0E7F]/;
            const Pattern = /[!@#$%^&*(),.?":{}|<>]/;
            Swal.fire({
                title: 'Confirm',
                text: 'Do you want to add this permission group?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28b76d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {

                    if (thaiPattern.test(checkPattern)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please do not enter Thai characters.',
                        });
                        $('#inpPermisGroup').val('');
                        return;
                    }

                    if (Pattern.test(checkPattern)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please do not enter Special characters.',
                        });
                        $('#inpPermisGroup').val('');
                        return;
                    }

                    if (inpName === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Permission Group is required.',
                            icon: 'error'
                        });
                        return $('#inpPermisGroup').focus();
                    }
                    // User confirmed, perform the AJAX request
                    $.ajax({
                        type: 'POST',
                        url: '/managePermissionGroup/addPermisGP', // Replace with the actual URL to your controller method
                        data: {
                            inpName: inpName
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                // Show a success message using SweetAlert2
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    $('#inpPermisGroup').val('');
                                    showPermisGroup();
                                });

                            } else {
                                // Show an error message using SweetAlert2
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                });
                                $('#inpPermisGroup').val('');
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


    function editPermisGP() {
        var permisGPName;
        var oldID, oldName;

        $(document).on('click', '#btnEditPermisGP', function () {
            var permisID = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "/managePermissionGroup/getPermisGPByID", // Replace with your server endpoint to update the state
                data: { spg_id: permisID },
                dataType: 'json',
                success: function (response) {
                    if (response.length == 1) {
                        const data = response[0];
                        var html = "";
                        permisGPName = data.spg_name;
                        html += `
                        <form id="formEditPermisGP">
                            <input type="hidden" id="spgID" value="${data.spg_id}">
                            <div class="row d-flex justify-content-between">
                                <input type="hidden" id="mdlEditId" value="">
                                <div class="col-md-12 mx-auto">
                                    <label class="fs-4" for="">Permission Group Name</label>
                                    <input type="text" class="form-control" id="editGroup" value="${data.spg_name}">
                                </div>
                                <div class="col-md-12 mx-auto d-flex justify-content-evenly mt-3">
                                    <a class="btn btn-outline-danger" data-bs-dismiss="modal" id="closeMdlEditPermis">Cancle</a>
                                    <button class="btn btn-success" id="btnSaveEdit">Save Change</button>
                                </div>
                            </div>
                        </form>
                        `;
                        $('#mdlFormEditPermisGroup').append(html);
                        oldID = data.spg_id;
                        oldName = data.spg_name;
                    }

                },
                error: function () {
                    return;
                }
            });
        })

        $(document).on('click', '#btnSaveEdit', function (event) {
            event.preventDefault();
            var controlPermisGPName = permisGPName;
            var permisId = $('#formEditPermisGP #spgID').val();
            var permisName = $('#formEditPermisGP #editGroup').val().trim();
            var checkPattern = permisName;
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
                $('#formEditPermisGP #editGroup').val(controlPermisGPName);
                return;
            }
            if (Pattern.test(checkPattern)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please do not enter Special characters.',
                });
                $('#formEditPermisGP #editGroup').val(controlPermisGPName);
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
                if (permisId === oldID && permisName === oldName) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'The data has not been edited.',
                    });
                    $('#mdlFormEditPermisGroup').empty();
                    $('#btnEditPermisGroup').modal('hide');
                    return;
                }
                if (permisName === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Main Menu Name is required',
                    });
                    return;
                }
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '/managePermissionGroup/updatePermisGP', // Change the URL to your updateData endpoint
                        data: {
                            spg_id: permisId,
                            spg_name: permisName
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
                                    $('#btnEditPermisGroup').modal('hide');
                                    var closeEdt = $('#mdlFormEditPermisGroup');
                                    closeEdt.empty();
                                    showPermisGroup();
                                });
                            } else {
                                // Show an error message using SweetAlert2
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                });
                                $('#formEditPermisGP #editGroup').val(controlPermisGPName);
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


        $(document).on('click', '#closeMdlEditPermis', function () {
            var closeEdt = $('#mdlFormEditPermisGroup');
            closeEdt.empty();
        })

        $('#mdlEditMainMenu').on('shown.bs.modal', function () {
            $(this).find('input').on('keydown', function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                }
            });
        });

    }

    function updateStatusFlg() {
        $(document).on('click', '#statusFlg', function () {
            var spg_id = $(this).closest('td').find('.btnStatus').val();
            var spg_status_flg = $(this).attr('data-id');
            // console.log(spg_id +" "+ spg_status_flg );
            // return;
            $('#confirmUpdate').on('click', function () {
                if (spg_id) {
                    // Perform the update via AJAX
                    $.ajax({
                        type: "POST",
                        url: "/managePermissionGroup/updateStatusFlg", // Replace with your server endpoint to update the state
                        data: { spg_id: spg_id, spg_status_flg: spg_status_flg },
                        dataType: 'json',
                        success: function (response) {
                            // console.log(response);
                            Swal.fire({
                                title: 'Success!',
                                text: 'Updated Status Flag Successfully.',
                                icon: 'success'
                            }).then(() => {
                                $('#mdlStatus').modal('hide');
                                showPermisGroup();
                                // location.reload();
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
                spg_id = null;
                spg_status_flg = null;
            });

            $('#cancleUpdateFlg').on('click', function () {
                spg_id = null;
                spg_status_flg = null;

                // console.log(su_flg +" "+ su_id_flg );
            });

            $('#mdlStatus').on('hidden.bs.modal', function () {
                // Clear the data in the modal
                spg_id = null;
                spg_status_flg = null;
                // console.log(su_flg +" "+ su_id_flg );
            });

        });
    }


    function fetchSwitchID(spgID, callback) {
        $.ajax({
            method: "get",
            url: `/managePermissionGroup/getPermisGPByStatus`,
            data: { spgID: spgID },
            dataType: 'json',
            success: (response) => {
                // console.log(response);
                callback(response);
            }
        });
    }



})