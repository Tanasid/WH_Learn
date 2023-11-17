$(() => {


    showSelPermisGP()
    searchPermis()
    addPermis()
    updateStatusFlg()


    function searchPermis() {
        $(document).on('click', '#btnSearch', function () {
            var selPermis = $('#selGroup').val();
            if (selPermis === '') {
                Swal.fire({
                    icon: 'warning',
                    iconColor: "#FF6666",
                    title: 'Permission Group Required',
                    text: 'Please Select Permission Gruop ...',
                });
                return;
            }
            $('#selMenuGroupName').prop('disabled', false);
            $('#selSubMenuName').prop('disabled', false);
            $('#selMenuGroupName').html(populateMainMenuOptions(selPermis));
            var selMain = $('#selMenuGroupName').val();
            // console.log(selMain);
            // return;
            $('#selSubMenuName').html(selMainToSub(selMain));

            $('#selMenuGroupName').on('change', function () {
                var selMain = $(this).val();
                $('#selSubMenuName').html(selMainToSub(selMain));
            })

            $("#form_table").show();
            refleshTable()
        })
    }

    function populatePermisOptions(selectedSmmId) {
        let optionsHTML = '<option value="">Please Select Permission Group ...</option>'; // Initialize the options HTML

        // AJAX call to fetch plant data
        $.ajax({
            url: '/managePermission/getPermisGP',
            method: 'GET',
            dataType: 'json',
            async: false, // Wait for the response before continuing
            success: function (response) {
                for (let i = 0; i < response.length; i++) {
                    const mainMenu = response[i];
                    // const isSelected = mainMenu.mpc_id === selectedSmmId ? 'selected' : '';
                    optionsHTML += `<option value="${mainMenu.spg_id}" >${mainMenu.spg_name}</option>`;
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });

        return optionsHTML; // Return the generated options HTML
    }

    function populateMainMenuOptions(selectedSmmId) {
        let optionsHTML = ''; // Initialize the options HTML

        // AJAX call to fetch plant data
        $.ajax({
            url: '/managePermission/getMainMenu',
            method: 'GET',
            data: { spg_id: selectedSmmId },
            dataType: 'json',
            async: false, // Wait for the response before continuing
            success: function (response) {
                for (let i = 0; i < response.length; i++) {
                    const mainMenu = response[i];
                    const isSelected = mainMenu.smm_id === selectedSmmId ? 'selected' : '';
                    optionsHTML += `<option value="${mainMenu.smm_id}" >${mainMenu.smm_name}</option>`;
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });

        return optionsHTML; // Return the generated options HTML
    }

    function showSelPermisGP() {
        $('#selGroup').html(populatePermisOptions());
    }

    function fetchSwitchID(spd_id, callback) {
        $.ajax({
            method: "get",
            url: `/managePermission/getStatus`,
            data: { spd_id: spd_id },
            dataType: 'json',
            success: (response) => {
                // console.log(response);
                callback(response);
            }
        });
    }

    function selMainToSub(selectedSmmId) {
        let optionsHTML = ''; // Initialize the options HTML

        // AJAX call to fetch plant data
        $.ajax({
            url: '/managePermission/getSubMenuByMainSel',
            method: 'GET',
            data: { smm_id: selectedSmmId },
            dataType: 'json',
            async: false, // Wait for the response before continuing
            success: function (response) {
                for (let i = 0; i < response.length; i++) {
                    const mainMenu = response[i];
                    const isSelected = mainMenu.smd_id === selectedSmmId ? 'selected' : '';
                    optionsHTML += `<option value="${mainMenu.smd_id}" >${mainMenu.smd_name}</option>`;
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });

        return optionsHTML; // Return the generated options HTML
    }

    function addPermis() {
        $(document).on('click', '#btnSaveAddPer', function () {
            var selPermis = $('#selGroup').val();
            var selSub = $('#selSubMenuName').val();
            var menu = $("#MenuPermis");
            // console.log(selPermis+" "+selSub);
            // return;
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

                    // User confirmed, perform the AJAX request
                    $.ajax({
                        type: 'POST',
                        url: '/managePermission/addPermis', // Replace with the actual URL to your controller method
                        data: {
                            spg_id: selPermis,
                            smd_id: selSub
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
                                    refleshTable();
                                    menu.empty();
                                    showMainMenu()
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

    function updateStatusFlg() {
        $(document).on('click', '#statusFlg', function () {
            var spd_id = $(this).closest('td').find('.btnStatus').val();
            var spd_status_flg = $(this).attr('data-id');
            var menu = $("#MenuPermis");
            // console.log(spg_id +" "+ spg_status_flg );
            // return;
            $('#confirmUpdate').on('click', function () {
                if (spd_id) {
                    // Perform the update via AJAX
                    $.ajax({
                        type: "POST",
                        url: "/managePermission/updateStatusFlg", // Replace with your server endpoint to update the state
                        data: { spd_id: spd_id, spd_status_flg: spd_status_flg },
                        dataType: 'json',
                        success: function (response) {
                            // console.log(response);
                            Swal.fire({
                                title: 'Success!',
                                text: 'Updated Status Flag Successfully.',
                                icon: 'success'
                            }).then(() => {
                                $('#mdlStatus').modal('hide');
                                refleshTable();
                                menu.empty();
                                showMainMenu()
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
                spd_id = null;
                spd_status_flg = null;
            });

            $('#cancleUpdateFlg').on('click', function () {
                spd_id = null;
                spd_status_flg = null;

                // console.log(su_flg +" "+ su_id_flg );
            });

            $('#mdlStatus').on('hidden.bs.modal', function () {
                // Clear the data in the modal
                spd_id = null;
                spd_status_flg = null;
                // console.log(su_flg +" "+ su_id_flg );
            });

        });
    }


    function refleshTable() {
        var selPermis = $('#selGroup').val();
        $.ajax({
            method: "get",
            url: "/managePermission/getPermisDetail",
            data: { smm_id: selPermis },
            dataType: 'Json',
            success: (response) => {
                // console.log(response);
                if (response.length > 0) {
                    var html = "";
                    for (let i = 0; i < response.length; i++) {
                        const data = response[i];
                        var btnStatus
                        fetchSwitchID(data.spd_id, function (statusFlg) {
                            const statusGet = statusFlg[0];
                            // console.log(statusGet);
                            if (statusGet['spd_status_flg'] == 1) {
                                btnStatus = `<button class="custom-btn btn-3 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.spd_id}" data-id="${statusGet['spd_status_flg']}"><span>Enable</span></button>`
                            } else {
                                btnStatus = `<button class="custom-btn btn-5 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.spd_id}" data-id="${statusGet['spd_status_flg']}"><span>Disable</span></button>`
                            }
                            html += `
                            <tr>
                                <td class="text-center">${i + 1}</td>
                                <td class="text-center">${data.smd_name}</td>
                                <td class="text-center">${data.smd_link}</td>
                                <td class="text-center">${btnStatus}</td>
                                <td class="text-center">${data.spd_updated_date}</td>
                                <td class="text-center">${data.spd_updated_by}</td>
                            </tr>`;
                            $('#tblPermis').dataTable().fnDestroy()
                            $("#tbody")
                                .html(html)
                                .promise()
                                .done(() => {
                                    $("#tblPermis").dataTable({
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

    function showMainMenu() {
        var currentPath = window.location.pathname.substring(1);
        // console.log(currentPath);
        $.ajax({
            method: "get",
            url: "/Menupermission",
            dataType: 'json',
            success: (response) => {
                // console.log(response);
                if (response.length > 0) {
                    for (let i = 0; i < response.length; i++) {
                        let collapsed = 'collapsed';
                        let show = '';
                        let activeMain = '';
                        const data = response[i];
                        fetchSubMenu(data['smm_id'], function (submenuData) {
                            var htmlSub = ""; // Initialize htmlSub here
                            for (let j = 0; j < submenuData.length; j++) {
                                const submenu = submenuData[j];
                                let active = '';
                                if (submenu['smd_link'] == currentPath) {
                                    collapsed = '';
                                    active = 'active';
                                    // activeMain = 'active';
                                    show = 'show';
                                }
                                htmlSub += `<a class="collapse-item sidebar-actives ${active}" href="/${submenu['smd_link']}">${submenu['smd_name']}</a>`;
                            }
                            // Update the sub-menu content
                            $(`#subMenuByID${data['smm_id']}`).html(htmlSub);

                            // Generate the main menu item HTML
                            var html = `
                            <li class="nav-item ${activeMain}">
                                <a class="nav-link ${collapsed}" href="" data-toggle="collapse" data-target="#${data['smm_name']}" aria-expanded="true" aria-controls="collapseTwo">
                                    <i class="${data['smm_icon']}"></i>
                                    <span>${data['smm_name']}</span>
                                </a>
                                <div id="${data['smm_name']}" class="collapse ${show}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                    <div class="bg-white py-2 collapse-inner rounded subMenuAC" id="subMenuByID${data['smm_id']}">
                                        ${htmlSub}
                                    </div>
                                </div>
                            </li>`;

                            // Append the HTML to the element with ID "testMenu"
                            $("#MenuPermis").append(html);
                        });
                    }
                }
            }
        });
        // activeClass()
    }

    // Function to fetch submenu data using AJAX
    function fetchSubMenu(smmId, callback) {
        $.ajax({
            method: "get",
            url: `/SubMenuPermission?smm_id=${smmId}`,
            dataType: 'json',
            success: (response) => {
                callback(response);
            }
        });
    }

})