$(() => {

    showMainMenu()
    iconSelect()
    addMainmenu()
    updateStatusFlg()
    editMainmenu()

    function showMainMenu() {
        $.ajax({
            method: "get",
            url: "/ManageMainMenu/getMainMenu",
            dataType: 'Json',
            success: (response) => {
                // console.log(response);
                if (response.length > 0) {
                    var html = "";
                    for (let i = 0; i < response.length; i++) {
                        const data = response[i];
                        var btnStatus
                        fetchSwitchID(data.smm_id, function (statusFlg) {
                            const statusGet = statusFlg[0];
                            // console.log(statusGet);
                            if (statusGet['smm_status_flg'] == 1) {
                                btnStatus = `<button class="custom-btn btn-3 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.smm_id}" data-id="${statusGet['smm_status_flg']}"><span>Enable</span></button>`
                            } else {
                                btnStatus = `<button class="custom-btn btn-5 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.smm_id}" data-id="${statusGet['smm_status_flg']}"><span>Disable</span></button>`
                            }
                            html += `
                            <tr>
                                <td class="text-center">${i + 1}</td>
                                <td class="text-center">${data.smm_name}</td>
                                <td class="text-center">${data.smm_updated_date}</td>
                                <td class="text-center">${data.smm_updated_by}</td>
                                <td class="text-center">${btnStatus}</td>
                                <td class="text-center">
                                    <button data-bs-toggle="modal" data-bs-target="#mdlEditMainMenu" id="btnEditAMainMenu" class="custom-btn btn-12" data-id="${data.smm_id}">
                                        <span>Click!</span><span>Edit</span>
                                    </button>
                                </td>
                            </tr>`;
                            $('#tblMainMenu').dataTable().fnDestroy()
                            $("#tbody")
                                .html(html)
                                .promise()
                                .done(() => {
                                    $("#tblMainMenu").dataTable({
                                        scrollX: true,
                                        responsive: true
                                    });

                                });

                        })
                    }


                }
            },
            // error: (err) => {
            //     console.log(err);
            // },

        });

    }

    function addMainmenu() {
        $(document).on('click', '#saveMainMenu', function () {
            var inpName = $('#inpMainMenuName').val().trim();
            var inpIconName = $('#inpMainMenuIcon').val();
            const checkPattern = inpName;
            const thaiPattern = /[\u0E00-\u0E7F]/;
            const Pattern = /[!@#$%^*,.?":{}|<>]/;
            // console.log(inpName + " " + inpIconName);
            Swal.fire({
                title: 'Confirm',
                text: 'Do you want to add this main menu?',
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
                            text: 'Menu Name is required.',
                            icon: 'error'
                        });
                        return;
                    }
                    if (inpIconName === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Icon Name is required.',
                            icon: 'error'
                        });
                        return;
                    }

                    // User confirmed, perform the AJAX request
                    $.ajax({
                        type: 'POST',
                        url: 'manageMainMenu/addMainMenu', // Replace with the actual URL to your controller method
                        data: {
                            inpName: inpName,
                            inpIconName: inpIconName
                        },
                        dataType: 'json',
                        success: function (response) {
                            if(response.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    showMainMenu();
                                    $('#inpMainMenuName').val('');
                                    $('#inpMainMenuIcon').val('');
                                });
                            } else {
                                // Show an error message using SweetAlert2
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                });
                                $('#inpMainMenuName').val('');
                                // Close the modal
                            }       
                        },
                    });
                }
            });

        })
    }

    function updateStatusFlg() {
        $(document).on('click', '#statusFlg', function () {
            var smm_id = $(this).closest('td').find('.btnStatus').val();
            var smm_status_flg = $(this).attr('data-id');
            // console.log(smm_id +" "+ smm_status_flg );
            $('#confirmUpdate').on('click', function () {
                if (smm_id) {
                    // Perform the update via AJAX
                    $.ajax({
                        type: "POST",
                        url: "/manageMainMenu/updateStatusFlg", // Replace with your server endpoint to update the state
                        data: { smmId: smm_id, smmFlg: smm_status_flg },
                        dataType: 'json',
                        success: function (response) {
                            // console.log(response);
                            Swal.fire({
                                title: 'Success!',
                                text: 'Updated Status Flag Successfully.',
                                icon: 'success'
                            }).then(() => {
                                $('#mdlStatus').modal('hide');
                                showMainMenu();
                                // location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire({
                                title: 'Errors!',
                                text: 'Updated Status Flag Errors!.',
                                icon: 'error'
                            })
                        }
                    });
                }
                smm_id = null;
                smm_status_flg = null;
            });

            $('#cancleUpdateFlg').on('click', function () {
                smm_id = null;
                smm_status_flg = null;

                // console.log(su_flg +" "+ su_id_flg );
            });

            $('#mdlStatus').on('hidden.bs.modal', function () {
                // Clear the data in the modal
                smm_id = null;
                smm_status_flg = null;
                // console.log(su_flg +" "+ su_id_flg );
            });

        });
    }

    function editMainmenu() {
        
        var oldID, oldName, oldIcon, oldOrder;

        $(document).on('click', '#btnEditAMainMenu', function () {
            var menuID = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "/manageMainMenu/getMainMenuByID", // Replace with your server endpoint to update the state
                data: { smm_id: menuID },
                dataType: 'json',
                success: function (response) {
                    if (response.length == 1) {
                        const data = response[0];
                        var html = "";
                        html += `
                            <form id="formEditMainMenu">
                                <div class="row d-flex justify-content-between">
                                    <input type="hidden" id="mdlEditId" value="${data.smm_id}">
                                    <div class="col-md-12 mx-auto">
                                        <label class="fs-4" for="">Main Menu</label>
                                        <input type="text" class="form-control" id="editMainMenu" placeholder="Enter your name menu ..." value="${data.smm_name}">
                                    </div>
                                    <div class="col-md-12 mx-auto mt-3">
                                        <label class="fs-4" for="">Main Menu Icon</label> <a class="btn btn-none" data-bs-toggle="modal" data-bs-target="#mdlEditICon"><i class="far fa-comment-dots fa-lg"></i></a>
                                        <input type="text" class="form-control" id="editMainIcon" data-bs-toggle="modal" data-bs-target="#mdlEditICon" placeholder="Icon name menu ..." value="${data.smm_icon}" disabled>  
                                    </div>
                                    <div class="col-md-12 mx-auto mt-3">
                                        <label class="fs-4" for="">Order NO.</label> <button class="btn btn-none" data-bs-toggle="modal" data-bs-target="#mdlICon"></button>
                                        <input type="number" min="1" class="form-control" id="editMainOrder" value="${data.smm_order}">
                                    </div>
                                    <div class="col-md-12 mx-auto d-flex justify-content-evenly mt-3">
                                        <a class="btn btn-outline-danger" data-bs-dismiss="modal" id="closeMdlEditMainMenu">Cancle</a>
                                        <button class="btn btn-success" id="saveEditMainMenu">Save Change</button>
                                    </div>
                                </div>
                            </form>
                        `;
                        $('#mdlFormEditMainMenu').append(html);
                        oldID = data.smm_id;
                        oldName = data.smm_name;
                        oldIcon = data.smm_icon;
                        oldOrder = data.smm_order;
                    }

                },
                error: function () {
                    return;
                }
            });
        })

        $(document).on('click', '#saveEditMainMenu', function (event) {
            event.preventDefault();
            var mainMenuId = $('#formEditMainMenu #mdlEditId').val();
            var mainMenuName = $('#formEditMainMenu #editMainMenu').val();
            var mainMenuIcon = $('#formEditMainMenu #editMainIcon').val();
            var mainMenuOrder = $('#formEditMainMenu #editMainOrder').val();
            const checkPattern = mainMenuName;
            const thaiPattern = /[\u0E00-\u0E7F]/;
            const Pattern = /[!@#$%^*,.?":{}|<>]/;
            // console.log(mainMenuId+" | "+mainMenuName+" | "+mainMenuIcon+" | "+mainMenuOrder);
            // return;
            Swal.fire({
                title: 'Confirm Save Changes',
                text: 'Are you sure you want to save the changes?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28b76d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (mainMenuId === oldID && mainMenuName === oldName && mainMenuIcon === oldIcon && mainMenuOrder === oldOrder) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'The data has not been edited.',
                    });
                    $('#mdlFormEditMainMenu').empty();
                    $('#mdlEditMainMenu').modal('hide');
                    return;
                }
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
                if (mainMenuName === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Main Menu Name is required',
                    });
                    return;
                }
                if (mainMenuIcon === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Main Menu Icon is required',
                    });
                    return;
                }
                if (mainMenuOrder === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Order NO. is required',
                    });
                    return;
                }
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '/manageMainMenu/updateMainMenu', // Change the URL to your updateData endpoint
                        data: {
                            smm_id: mainMenuId,
                            smm_name: mainMenuName,
                            smm_icon: mainMenuIcon,
                            smm_order: mainMenuOrder
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
                                    text: 'Update Main Menu successfully!',
                                    timer: 2500, // Set the timer for auto-closing alert
                                    showConfirmButton: true
                                }).then(function () {
                                    $('#mdlEditMainMenu').modal('hide');
                                    var closeEdt = $('#mdlFormEditMainMenu');
                                    closeEdt.empty();
                                    showMainMenu();
                                });
                            } else {
                                // Show an error message using SweetAlert2
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                });
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

        $('#closeMdlEditIcon').on('click', function () {
            $('#mdlEditICon').modal("hide");
            $('#mdlEditMainMenu').modal("show");
        })

        $('#iconListEdit #iconItem').on('click', function () {
            const iconVal = $(this).val();
            // console.log(iconVal);
            $('#editMainIcon').val(iconVal);
            $('#mdlEditICon').modal('hide');
            $('#mdlEditMainMenu').modal("show");
        });

        $(document).on('click', '#closeMdlEditMainMenu', function () {
            var closeEdt = $('#mdlFormEditMainMenu');
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

    function fetchSwitchID(smmID, callback) {
        $.ajax({
            method: "get",
            url: `/manageMainMenu/getMainMenuByStatus`,
            data: { smmID: smmID },
            dataType: 'json',
            success: (response) => {
                // console.log(response);
                callback(response);
            }
        });
    }

    function iconSelect() {
        $('#iconList #iconItem').on('click', function () {
            const iconVal = $(this).val();
            // console.log(iconVal);

            $('#inpMainMenuIcon').val(iconVal);

            $('#mdlICon').modal('hide'); // Close the icon modal
        });
    }


})