$(() => {


    // showSubMenu()
    showSelMainMenu()
    searchMainMenu()
    updateStatusFlg()
    editSubMenu()
    addSubMenu()


    function showSubMenu() {
        $.ajax({
            method: "get",
            url: "/manageSubMenu/getSubMenu",
            dataType: 'Json',
            success: (response) => {
                // console.log(response);
                if (response.length > 0) {
                    var html = "";
                    for (let i = 0; i < response.length; i++) {
                        const data = response[i];
                        var btnStatus
                        fetchSwitchID(data.smd_id, function (statusFlg) {
                            const statusGet = statusFlg[0];
                            // console.log(statusGet);
                            if (statusGet['spd_status_flg'] == 1) {
                                btnStatus = `<button class="custom-btn btn-3 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.smd_id}" data-id="${statusGet['spd_status_flg']}"><span>Enable</span></button>`
                            } else {
                                btnStatus = `<button class="custom-btn btn-5 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.smd_id}" data-id="${statusGet['spd_status_flg']}"><span>Disable</span></button>`
                            }
                            html += `
                            <tr>
                                <td class="text-center">${i + 1}</td>
                                <td class="text-center">${data.smd_name}</td>
                                <td class="text-center">${data.smd_link}</td>
                                <td class="text-center">${btnStatus}</td>
                                <td class="text-center">${data.spd_updated_date}</td>
                                <td class="text-center">${data.spd_updated_by}</td>
                                <td class="text-center">
                                    <button class="custom-btn btn-12" data-bs-toggle="modal" data-bs-target="#mdlEditSubMenu" id="btnEditSubMenu" data-id="${data.smd_id}">
                                        <span>Click!</span><span>Edit</span>
                                    </button>
                                </td>
                            </tr>`;
                            $('#tblSubMenu').dataTable().fnDestroy()
                            $("#tbody")
                                .html(html)
                                .promise()
                                .done(() => {
                                    $("#tblSubMenu").dataTable({
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

    function updateStatusFlg() {
        $(document).on('click', '#statusFlg', function () {
            var smd_id = $(this).closest('td').find('.btnStatus').val();
            var smd_status_flg = $(this).attr('data-id');
            // console.log(smd_id +" "+ smd_status_flg );
            // return;
            $('#confirmUpdate').on('click', function () {
                if (smd_id) {
                    // Perform the update via AJAX
                    $.ajax({
                        type: "POST",
                        url: "/manageSubMenu/updateStatusFlg", // Replace with your server endpoint to update the state
                        data: { smd_id: smd_id, smd_status_flg: smd_status_flg },
                        dataType: 'json',
                        success: function (response) {
                            // console.log(response);
                            Swal.fire({
                                title: 'Success!',
                                text: 'Updated Status Flag Successfully.',
                                icon: 'success'
                            }).then(() => {
                                beforeUpdateFlg()
                                // location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire({
                                title: 'Errors!',
                                text: 'Updated Status Flag Errors!.',
                                icon: 'error'
                            })
                            beforeUpdateFlg()
                        }
                    });
                }
                smd_id = null;
                smd_status_flg = null;
            });

            $('#cancleUpdateFlg').on('click', function () {
                smd_id = null;
                smd_status_flg = null;

                // console.log(su_flg +" "+ su_id_flg );
            });

            $('#mdlStatus').on('hidden.bs.modal', function () {
                // Clear the data in the modal
                smd_id = null;
                smd_status_flg = null;
                // console.log(su_flg +" "+ su_id_flg );
            });

        });

    }

    function fetchSwitchID(smdID, callback) {
        $.ajax({
            method: "get",
            url: `/manageSubMenu/getSubMenuByStatus`,
            data: { smdID: smdID },
            dataType: 'json',
            success: (response) => {
                // console.log(response);
                callback(response);
            }
        });
    }

    function searchMainMenu() {
        $(document).on('click', '#btnSearchMain', function () {
            var inpMain = $('#selMainMenu').val().trim();
            // var inpSubMenuName = ('#inpSubMenuName');
            // var inpSubMenuCon = ('#inpSubMenuCon');
            if (inpMain === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Main menu is required',
                    text: 'Please Select Main Menu ...',
                });
                return;
            }
            var groupMenu = $('#formAddSub input');
            groupMenu.prop('disabled', false);
            groupMenu.each(function () {
                $(this).attr("placeholder", "");
            });
            // console.log(inpMain);
            $.ajax({
                method: "get",
                url: "/manageSubMenu/getSubMenuById",
                data: { inpSel: inpMain },
                dataType: 'Json',
                success: (response) => {
                    // console.log(response);
                    if (response.length > 0) {
                        var html = "";
                        for (let i = 0; i < response.length; i++) {
                            const data = response[i];
                            var btnStatus
                            fetchSwitchID(data.smd_id, function (statusFlg) {
                                const statusGet = statusFlg[0];
                                // console.log(statusGet);
                                if (statusGet['spd_status_flg'] == 1) {
                                    btnStatus = `<button class="custom-btn btn-3 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.smd_id}" data-id="${statusGet['spd_status_flg']}"><span>Enable</span></button>`
                                } else {
                                    btnStatus = `<button class="custom-btn btn-5 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.smd_id}" data-id="${statusGet['spd_status_flg']}"><span>Disable</span></button>`
                                }
                                html += `
                                <tr>
                                    <td class="text-center">${i + 1}</td>
                                    <td class="text-center">${data.smd_name}</td>
                                    <td class="text-center">${data.smd_link}</td>
                                    <td class="text-center">${btnStatus}</td>
                                    <td class="text-center">${data.spd_updated_date}</td>
                                    <td class="text-center">${data.spd_updated_by}</td>
                                    <td class="text-center">
                                        <button class="custom-btn btn-12" data-bs-toggle="modal" data-bs-target="#mdlEditSubMenu" id="btnEditSubMenu" data-id="${data.smd_id}">
                                            <span>Edit</span><span><i class="fas fa-wrench fa-lg"></i></span>
                                        </button>
                                    </td>
                                </tr>`;
                                $('#tblSubMenu').dataTable().fnDestroy()
                                $("#tbody")
                                    .html(html)
                                    .promise()
                                    .done(() => {
                                        $("#tblSubMenu").dataTable({
                                            scrollX: true,
                                            responsive: true
                                        });

                                    });

                            })
                        }
                    }
                    $(".table-sub").show();
                },

            });
        })
    }

    function addSubMenu() {
        $(document).on('click', '#btnSaveAdd', function () {
            var inpName = $('#inpSubMenuName').val().trim();
            var inpConName = $('#inpSubMenuCon').val().trim();
            var selMainMenu = $('#selMainMenu').val().trim();
            var thaiPattern = /[\u0E00-\u0E7F]/;
            const Pattern = /[!@#$%^*,.?":{}|<>]/;
            // console.log(inpName + " " + inpConName+" "+selMainMenu);
            // return;
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
                    if (thaiPattern.test(inpName)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please do not enter Thai characters.',
                        });
                        return;
                    }
                    if (Pattern.test(inpName)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please do not enter Special characters.',
                        });
                        return;
                    }
                    if (thaiPattern.test(inpConName)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please do not enter Thai characters.',
                        });
                        return;
                    }
                    if (inpName === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Sub Menu Name is required.',
                            icon: 'error'
                        });
                        return;
                    }
                    if (inpConName === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Sub Menu Controller is required.',
                            icon: 'error'
                        });
                        return;
                    }
                    // User confirmed, perform the AJAX request
                    $.ajax({
                        type: 'POST',
                        url: 'manageSubMenu/addSubMenu', // Replace with the actual URL to your controller method
                        data: {
                            inpName: inpName,
                            inpConName: inpConName,
                            selMainMenu: selMainMenu
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
                                    beforeUpdateFlg();
                                    $('#inpSubMenuName').val('');
                                    $('#inpSubMenuCon').val('');
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
            });

        })
    }

    function populateMainmenuOptions(selectedSmmId) {
        let optionsHTML = '<option value="">Please Select Main Menu ...</option>'; // Initialize the options HTML

        // AJAX call to fetch plant data
        $.ajax({
            url: '/manageSubMenu/getMainMenu',
            method: 'GET',
            dataType: 'json',
            async: false, // Wait for the response before continuing
            success: function (response) {
                for (let i = 0; i < response.length; i++) {
                    const mainMenu = response[i];
                    optionsHTML += `<option value="${mainMenu.smm_id}" >${mainMenu.smm_name}</option>`;
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });

        return optionsHTML; // Return the generated options HTML
    }

    function showSelMainMenu() {
        $('#selMainMenu').html(populateMainmenuOptions());
    }

    function beforeUpdateFlg() {
        var inpMain = $('#selMainMenu').val().trim();
        // console.log(inpMain);
        // return;
        $.ajax({
            method: "get",
            url: "/manageSubMenu/getSubMenuById",
            data: { inpSel: inpMain },
            dataType: 'Json',
            success: (response) => {
                console.log(response);
                if (response.length > 0) {
                    var html = "";
                    for (let i = 0; i < response.length; i++) {
                        const data = response[i];
                        var btnStatus
                        fetchSwitchID(data.smd_id, function (statusFlg) {
                            const statusGet = statusFlg[0];
                            // console.log(statusGet);
                            if (statusGet['spd_status_flg'] == 1) {
                                btnStatus = `<button class="custom-btn btn-3 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.smd_id}" data-id="${statusGet['spd_status_flg']}"><span>Enable</span></button>`
                            } else {
                                btnStatus = `<button class="custom-btn btn-5 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.smd_id}" data-id="${statusGet['spd_status_flg']}"><span>Disable</span></button>`
                            }
                            html += `
                                <tr>
                                    <td class="text-center">${i + 1}</td>
                                    <td class="text-center">${data.smd_name}</td>
                                    <td class="text-center">${data.smd_link}</td>
                                    <td class="text-center">${btnStatus}</td>
                                    <td class="text-center">${data.spd_updated_date}</td>
                                    <td class="text-center">${data.spd_updated_by}</td>
                                    <td class="text-center">
                                        <button class="custom-btn btn-12" data-bs-toggle="modal" data-bs-target="#mdlEditSubMenu" id="btnEditSubMenu" data-id="${data.smd_id}">
                                            <span>Click!</span><span>Edit</span>
                                        </button>
                                    </td>
                                </tr>`;
                            $('#tblSubMenu').dataTable().fnDestroy()
                            $("#tbody")
                                .html(html)
                                .promise()
                                .done(() => {
                                    $("#tblSubMenu").dataTable({
                                        scrollX: true,
                                        responsive: true
                                    });

                                });

                        })
                    }
                }
                $(".table-sub").show();
            },

        });
        $('#mdlStatus').modal('hide');
    }

    function editSubMenu() {
        var subMenuName, subMenuCon, oldID, oldName, oldControl, oldOrder;

        $(document).on('click', '#btnEditSubMenu', function () {
            var smd_id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "/ManageSubMenu/editSubMenuById", // Replace with your server endpoint to update the state
                data: { smd_id: smd_id },
                dataType: 'json',
                success: function (response) {
                    // console.log(response);
                    // return;
                    if (response.length == 1) {
                        const data = response[0];
                        var html = "";
                        subMenuName = data.smd_name;
                        subMenuCon = data.smd_link
                        html += `
                        <form id="formEditSubMenu">
                            <div class="row d-flex justify-content-between">
                                <input type="hidden" id="mdlEditId" value="${data.smd_id}">
                                <div class="col-md-12 mx-auto">
                                    <label class="fs-4" for="">Sub Menu Name</label>
                                    <input type="text" class="form-control" id="editSubMenu" value="${data.smd_name}">
                                </div>
                                <div class="col-md-12 mx-auto mt-3">
                                    <label class="fs-4" for="">Sub Menu Controller</label>
                                    <input type="text" class="form-control" id="editController" value="${data.smd_link}" >
                                </div>
                                <div class="col-md-12 mx-auto mt-3">
                                    <label class="fs-4" for="">Sub Menu Order</label>
                                    <input type="number" min="1" class="form-control" id="editOrderNo" value="${data.smd_order}">
                                </div>
                                <div class="col-md-12 mx-auto d-flex justify-content-evenly mt-3">
                                    <a class="btn btn-outline-danger" data-bs-dismiss="modal" id="closeMdlEditSubMenu">Cancle</a>
                                    <button class="btn btn-success" id="btnSaveEditSub">Save Change</button>
                                </div>
                            </div>
                        </form>
                        `;
                        $('#mdlFormEditSubMenu').append(html);
                        oldID = data.smd_id
                        oldName = data.smd_name
                        oldControl = data.smd_link
                        oldOrder = data.smd_order
                    }

                },
                error: function () {
                    return;
                }
            });
        })

        $(document).on('click', '#btnSaveEditSub', function (event) {
            event.preventDefault();
            var controlSubName = subMenuName;
            var controlSubCon = subMenuCon;
            var smdId = $('#formEditSubMenu #mdlEditId').val();
            var smdName = $('#formEditSubMenu #editSubMenu').val().trim();
            var smdCon = $('#formEditSubMenu #editController').val().trim();
            var smdOrder = $('#formEditSubMenu #editOrderNo').val().trim();
            var checkName = smdName;
            var checkCon = smdCon;
            var thaiPattern = /[\u0E00-\u0E7F]/;
            const Pattern = /[!@#$%^*,.?":{}|<>]/;
            // console.log(permisId+" | "+permisName);
            // return;
            if (thaiPattern.test(checkName)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please do not enter Thai characters.',
                });
                $('#formEditSubMenu #editSubMenu').val(controlSubName);
                return;
            }
            if (Pattern.test(checkName)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please do not enter Special characters.',
                });
                $('#formEditSubMenu #editSubMenu').val(controlSubName);
                return;
            }
            if (thaiPattern.test(checkCon)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please do not enter Thai characters.',
                });
                $('#formEditSubMenu #editController').val(controlSubCon);
                return;
            }
            Swal.fire({
                title: 'Confirm Save Changes',
                text: 'Are you sure you want to save sub menu?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28b76d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (smdId === oldID && smdName === oldName && smdCon === oldControl && smdOrder === oldOrder) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'The data has not been edited.',
                    });
                    $('#mdlFormEditSubMenu').empty();
                    $('#mdlEditSubMenu').modal('hide');
                    return;
                }
                if (smdName === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Sub Menu Name is required',
                    });
                    return;
                }
                if (smdCon === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Sub Menu Controller is required',
                    });
                    return;
                }
                if (smdOrder === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Sub Menu Order is required',
                    });
                    return;
                }
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageSubMenu/updateSubMenu', // Change the URL to your updateData endpoint
                        data: {
                            smd_id: smdId,
                            smd_name: smdName,
                            smd_link: smdCon,
                            smd_order: smdOrder
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
                                    text: 'Updated successfully!',
                                    timer: 2500, // Set the timer for auto-closing alert
                                    showConfirmButton: true
                                }).then(function () {
                                    $('#mdlEditSubMenu').modal('hide');
                                    var closeEdt = $('#mdlFormEditSubMenu');
                                    closeEdt.empty();
                                    beforeUpdateFlg();
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


        $(document).on('click', '#closeMdlEditSubMenu', function () {
            var closeEdt = $('#mdlFormEditSubMenu');
            closeEdt.empty();
        })

        $('#formEditSubMenu').on('shown.bs.modal', function () {
            $(this).find('input').on('keydown', function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                }
            });
        });

    }

})