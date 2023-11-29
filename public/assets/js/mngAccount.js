$(() => {

    showAccount()
    mdlAddAccount()
    mdlEditAccount()
    updateStatus()

    function showAccount() {
        $.ajax({
            method: "get",
            url: "/ManageAccount/showAccount",
            dataType: 'Json',
            success: (response) => {
                // console.log(response);
                if (response.length > 0) {
                    var html = "";
                    for (let i = 0; i < response.length; i++) {
                        const data = response[i];
                        var btnStatus
                        fetchSwitchID(data.su_id, function (statusFlg) {
                            const statusGet = statusFlg[0];
                            // console.log(statusGet);
                            if (statusGet['su_status_flg'] == 1) {
                                btnStatus = `<button class="custom-btn btn-3 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.su_id}" data-id="${statusGet['su_status_flg']}" ><span>Enable</span></button>`
                            } else {
                                btnStatus = `<button class="custom-btn btn-5 btnStatus" id="statusFlg" data-bs-toggle="modal" data-bs-target="#mdlStatus" value="${data.su_id}" data-id="${statusGet['su_status_flg']}"><span>Disable</span></button>`
                            }
                            html += `
                            <tr>
                                <td class="text-center">${i + 1}</td>
                                <td class="text-center">${data.su_emp_code}</td>
                                <td class="text-center">${data.spg_name}</td>
                                <td class="text-center">${data.su_firstname}</td>
                                <td class="text-center">${data.su_email}</td>
                                <td class="text-center">${btnStatus}</td>
                                <td class="text-center">
                                    <button data-bs-toggle="modal" data-bs-target="#mdlEdit" id="btnEditAcc" class="custom-btn btn-12" data-id="${data.su_id}">
                                        <span>Edit</span><span><i class="fas fa-wrench fa-lg"></i></span>
                                    </button>
                                </td>
                            </tr>`;
                            $('#tblManageAccount').dataTable().fnDestroy()
                            $("#tbody")
                                .html(html)
                                .promise()
                                .done(() => {
                                    $("#tblManageAccount").dataTable({
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

    };

    //-------------------------- Update Status Flg ----------------------------------
    function updateStatus() {
        $(document).on('click', '#statusFlg', function () {
            var su_id_flg = $(this).closest('td').find('.btnStatus').val();
            var su_flg = $(this).attr('data-id');

            // console.log(su_flg +" "+ su_id_flg );

            $('#confirmUpdate').on('click', function () {
                if (su_id_flg) {
                    // Perform the update via AJAX
                    $.ajax({
                        type: "POST",
                        url: "/manageAccount/updateStatusFlag", // Replace with your server endpoint to update the state
                        data: { suId: su_id_flg, suFlg: su_flg },
                        dataType: 'json',
                        success: function (response) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Updated Status Flag Successfully.',
                                icon: 'success'
                            }).then(() => {
                                $('#mdlStatus').modal('hide');
                                showAccount();
                                // location.reload();
                            });
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
                su_id_flg = null;
                su_flg = null;
            });

            $('#cancleUpdateFlg').on('click', function () {
                su_id_flg = null;
                su_flg = null;

                // console.log(su_flg +" "+ su_id_flg );
            });

            $('#mdlStatus').on('hidden.bs.modal', function () {
                // Clear the data in the modal
                su_id_flg = null;
                su_flg = null;
                // console.log(su_flg +" "+ su_id_flg );
            });

        });
    }

    //-------------------------- Get Select Modal Add Account --------------------------------//
    function mdlAddAccount() {

        //------------- GET Data From DB --------------//
        $(document).ready(function () {
            // Fetch permission group data and populate the select options
            $.ajax({
                url: '/ManageAccount/getPermissionGroups',
                method: 'GET',
                dataType: 'json',
                success: function (response) {

                    var selectPermis = $('#selPermissionAdd');

                    // Clear any existing options
                    selectPermis.empty();

                    // Add new options based on the response data
                    var option1 = $('<option>', {
                        value: '',  // Adjust the property name based on your data
                        text: 'Please Select Permission Group ...'
                    })
                    selectPermis.append(option1);

                    for (var i = 0; i < response.length; i++) {
                        var option = $('<option>', {
                            value: response[i].spg_id,  // Adjust the property name based on your data
                            text: response[i].spg_name  // Adjust the property name based on your data
                        });
                        selectPermis.append(option);
                    }
                    // console.log(select);
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });

            $.ajax({
                url: '/ManageAccount/getPlant',
                method: 'GET',
                dataType: 'json',
                success: function (response) {

                    var selectPlant = $('#selPlantAdd');

                    // Clear any existing options
                    selectPlant.empty();
                    var option1 = $('<option>', {
                        value: '',  // Adjust the property name based on your data
                        text: 'Please Select Plant ...'  // Adjust the property name based on your data
                    });
                    selectPlant.append(option1);
                    // Add new options based on the response data
                    for (var i = 0; i < response.length; i++) {
                        var option = $('<option>', {
                            value: response[i].mpc_id,  // Adjust the property name based on your data
                            text: response[i].mpc_name  // Adjust the property name based on your data
                        });
                        selectPlant.append(option);
                    }
                    // console.log(select);
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        });

        //------------- Add Data In DB --------------//

        $(document).on('click', '#saveChanges', function () {
            var empCode = $('#inpEmpCode').val().trim();
            var empPassword = $('#inpEmpPassword').val().trim();
            var firstName = $('#inpFirstName').val().trim();
            var lastName = $('#inpLastName').val().trim();
            var email = $('#inpEmail').val().trim();
            var permissionGroup = $('#selPermissionAdd').val().trim();
            var plant = $('#selPlantAdd').val().trim();

            var fieldIds = [
                empCode, empPassword, firstName, lastName,
                email, permissionGroup, plant
            ];
            const checkPattern = fieldIds;
            const thaiWord = /[\u0E00-\u0E7F]/;
            const Pattern = /[!@#$%^&*(),.?":{}|<>]/;

            if (Pattern.test(empCode)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Employee Code Error',
                    text: 'Invalid input. Only English letters and numbers are allowed.',
                });
                return;
            }
            for (var i = 0; i < fieldIds.length; i++) {
                if (thaiWord.test(checkPattern[i])) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please do not enter Thai characters.',
                    });
                    return;
                }
            }
            if (empCode == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Employee Code is required',
                });
                $('#inpEmpCode').focus();
                return;
            }
            if (empPassword == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Employee Password is required',
                });
                $('#inpEmpPassword').focus();
                return;
            }
            if (firstName == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'First Name is required',
                });
                $('#inpFirstName').focus();
                return;
            }
            if (lastName == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Last Name is required',
                });
                $('#inpLastName').focus();
                return;
            }
            if (email == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Email is required',
                });
                $('#inpEmail').focus();
                return;
            }
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (!emailPattern.test(email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Invalid Email Format',
                });
                $('#inpEmail').focus();
                return;
            }
            if (permissionGroup == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Permission Group is required',
                });
                $('#inpEmpCode').focus();
                return;
            }
            if (plant == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Plant is required',
                });
                $('#inpEmpCode').focus();
                return;
            }

            Swal.fire({
                title: 'Confirm Register Account ?',
                text: 'Are you sure you want to save the data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28b76d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/ManageAccount/addAccount', // Replace with your controller URL
                        method: 'POST',
                        data: {
                            empCode: empCode,
                            empPassword: empPassword,
                            firstName: firstName,
                            lastName: lastName,
                            email: email,
                            permissionGroup: permissionGroup,
                            plant: plant
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
                                    $('#inpEmpCode').val('');
                                    $('#inpEmpPassword').val('');
                                    $('#inpFirstName').val('');
                                    $('#inpLastName').val('');
                                    $('#inpEmail').val('');
                                    $('#callMdlAdd').modal('hide');
                                    showAccount();
                                });
                            } else {
                                // Show an error message using SweetAlert2
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                });
                                $('#inpEmpCode').val('');
                                // Close the modal
                            }
                        },
                        error: function (error) {
                            console.log('Error:', error);
                        }
                    });
                }
                // Perform the update via AJAX

            });
            // Send the data to the controller
        });

        //------------- Close Modal AddAcc --------------//


        $(document).on('click', '#closeAddAcc', function () {
            $('#inpEmpCode').val('');
            $('#inpEmpPassword').val('');
            $('#inpFirstName').val('');
            $('#inpLastName').val('');
            $('#inpEmail').val('');
        });
    }

    //-------------------------- Get Data Modal Edit Account ---------------------------

    function mdlEditAccount() {

        var oldEmp, oldPermis, oldFname, oldLname, oldEmail, oldPlant, oldPass;
        $(document).on('click', '#btnEditAcc', function () {

            var userId = $(this).attr('data-id');
            // alert("su_status_flg: " + userId );
            $.ajax({
                url: '/ManageAccount/getDataEdit',
                method: 'GET',
                data: { userID: userId },
                dataType: 'json',
                success: function (response) {
                    // console.log(response);
                    if (response.length > 0) {
                        var html = "";
                        for (let i = 0; i < response.length; i++) {
                            const data = response[i];

                            html += `
                            <form id="formEditAcc">
                                <input type="hidden" id="su_id" value="${data.su_id}">
                                <div class="mb-3 d-flex justify-content-between">
                                    <label for="inpEmpCode" class="form-label col-3 fs-4">Employee Code</label>
                                    <input type="text" class="form-control" id="inpEmpCode" value="${data.su_emp_code}" require disabled>
                                </div>
                                <div class="mb-3 d-flex justify-content-between">
                                    <label for="inpEmpPassword" class="form-label col-3 fs-4">New Password</label>
                                    <input type="text" class="form-control" id="inpEmpPassword" value="" require>
                                </div>
                                <div class="mb-3 d-flex justify-content-between">
                                    <label for="selPermissionAdd" class="form-label col-3 fs-4">Permission Group</label>
                                    <select class="form-select" id="selPermissionAdd" require>
                                        ${populatePermisIdOptions(data.spg_id)}
                                    </select>
                                </div>
                                <div class="mb-3 d-flex justify-content-between">
                                    <label for="inpFirstName" class="form-label col-3 fs-4">First Name</label>
                                    <input type="text" class="form-control" id="inpFirstName" value="${data.su_firstname}" require>
                                </div>
                                <div class="mb-3 d-flex justify-content-between">
                                    <label for="inpLastName" class="form-label col-3 fs-4">Last Name</label>
                                    <input type="text" class="form-control" id="inpLastName" value="${data.su_lastname}" require>
                                </div>
                                <input type="hidden" id="inpStatusFlg" value="${data.su_status_flg}">
                                <div class="mb-3 d-flex justify-content-between">
                                    <label for="inpEmail" class="form-label col-3 fs-4">Email</label>
                                    <input type="text" class="form-control" id="inpEmail" value="${data.su_email}" require>
                                </div>
                                <div class="mb-3 d-flex justify-content-between">
                                    <label for="selPlantAdd" class="form-label col-3 fs-4">Plant</label>
                                    <select class="form-select" id="selPlantAdd" require> 
                                        ${populatePlantOptions(data.mpc_id)}   
                                    </select>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="button" class="btn btn-danger mr-5" id="closeMdlEdit" data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-success ml-5" id="editSave">Save Changes</button>
                                </div>
                            </form>
                        `;
                            $('#mdlFormEdit').append(html);
                            oldEmp = data.su_emp_code;
                            oldPermis = data.spg_id;
                            oldFname = data.su_firstname;
                            oldLname = data.su_lastname;
                            oldEmail = data.su_email;
                            oldPlant = data.mpc_id;
                            oldPass = data.su_emp_password;
                            // console.log(oldEmp + oldPermis + oldFname + oldLname + oldEmail + oldPlant + oldPass);
                        }

                    }
                }

            });

        });

        $(document).on('click', '#editSave', function (event) {
            event.preventDefault(); // Prevent the default form submission
            // var table = $('#tblManageAccount').DataTable();
            // Get the updated values from the form fields
            var suId = $('#formEditAcc #su_id').val().trim();
            var suEmpCode = $('#formEditAcc #inpEmpCode').val().trim();
            var suEmpPassword = $('#formEditAcc #inpEmpPassword').val().trim();
            var spgId = $('#formEditAcc #selPermissionAdd').val().trim();
            var suFirstName = $('#formEditAcc #inpFirstName').val().trim();
            var suLastName = $('#formEditAcc #inpLastName').val().trim();
            var suStatusFlg = $('#formEditAcc #inpStatusFlg').val().trim();
            var suEmail = $('#formEditAcc #inpEmail').val().trim();
            var mpcId = $('#formEditAcc #selPlantAdd').val().trim();

            if(suEmpPassword === '') {
                suEmpPassword = oldPass;
            }

            if (suEmpCode === oldEmp && suEmpPassword === oldPass && suFirstName === oldFname && suLastName === oldLname && suEmail === oldEmail && mpcId === oldPlant && spgId === oldPermis) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'The data has not been edited.',
                });
                return;
            }

            var fieldIds = [
                suId, suEmpCode, spgId,
                suFirstName, suLastName, suEmail, mpcId
            ];
            const checkPattern = fieldIds;
            const thaiPattern = /[\u0E00-\u0E7F]/;
            // Check if any field is empty
            if (suEmpPassword === '') {
                suEmpPassword = oldPass;
            }
            for (var i = 0; i < fieldIds.length; i++) {
                if (fieldIds[i] === "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'All fields must be filled out.',
                    });
                    return; // Exit the function
                }
                if (thaiPattern.test(checkPattern[i])) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please do not enter Thai characters.',
                    });
                    // $('#inpPermisGroup').val('');
                    return;
                }
            }

            if (!isValidEmail(suEmail)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please enter a valid email address.',
                });
                return; // Exit the function
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
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageAccount/updateAccount', // Change the URL to your updateData endpoint
                        data: {
                            suId: suId,
                            oldPassword: oldPass,
                            su_emp_code: suEmpCode,
                            su_emp_password: suEmpPassword,
                            spg_id: spgId,
                            su_firstname: suFirstName,
                            su_lastname: suLastName,
                            su_status_flg: suStatusFlg,
                            su_email: suEmail,
                            mpc_id: mpcId
                            // ... other fields you want to update
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                // Show a success message using SweetAlert2
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'User data updated successfully!',
                                    timer: 2500, // Set the timer for auto-closing alert
                                    showConfirmButton: true
                                }).then(function () {
                                    $('#mdlEdit').modal('hide');
                                    $('#mdlFormEdit').empty();
                                    showAccount();
                                });
                            } else {
                                // Show an error message using SweetAlert2
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to update user data. Please try again.',
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
        });

        $(document).on('click', '#closeMdlEdit', function () {
            var closeEdt = $('#mdlFormEdit');
            closeEdt.empty();
        })

    }

    // function deleteAccount() {
    //     $(document).on('click', '#btnDltAcc', function () {
    //         var suId = $(this).attr('data-id');
    //         console.log("Form field values:");
    //         console.log("suId:", suId);

    //         const swalWithBootstrapButtons = Swal.mixin({
    //             customClass: {
    //                 confirmButton: 'btn btn-success m-3',
    //                 cancelButton: 'btn btn-danger'
    //             },
    //             buttonsStyling: false
    //         })

    //         swalWithBootstrapButtons.fire({
    //             title: 'Are you sure?',
    //             text: "You won't be able to revert this!",
    //             icon: 'warning',
    //             showCancelButton: true,
    //             confirmButtonText: 'Yes, delete it!',
    //             cancelButtonText: 'No, cancel!',
    //             reverseButtons: true
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 $.ajax({
    //                     type: 'POST',
    //                     url: 'ManageAccount/deleteAccount',
    //                     data: { su_id: suId },
    //                     dataType: 'json',
    //                     success: function (response) {
    //                         if (response.success) {
    //                             // Show a success message using SweetAlert2
    //                             swalWithBootstrapButtons.fire(
    //                                 'Deleted!',
    //                                 'Your account has been deleted.',
    //                                 'success'
    //                             )
    //                             showAccount();
    //                             // setTimeout(function () {
    //                             //     location.reload();
    //                             // }, 500);

    //                             // Perform any additional actions, such as updating the UI
    //                         } else {
    //                             // Show an error message using SweetAlert2
    //                             Swal.fire({
    //                                 icon: 'error',
    //                                 title: 'Error',
    //                                 text: 'Failed to delete user.',
    //                                 timer: 3500,
    //                             });
    //                             // setTimeout(function () {
    //                             //     location.reload();
    //                             // }, 500);
    //                         }
    //                     },
    //                     error: function (error) {
    //                         console.log('Error:', error);
    //                     }
    //                 });

    //             } else if (
    //                 /* Read more about handling dismissals below */
    //                 result.dismiss === Swal.DismissReason.cancel
    //             ) {
    //                 swalWithBootstrapButtons.fire(
    //                     'Cancelled',
    //                     'Your Cancelled file is safe :)',
    //                     'error'
    //                 )
    //             }
    //         })
    //     })
    // }

    function fetchSwitchID(suID, callback) {
        $.ajax({
            method: "get",
            url: `/manageAccount/showStatus?suID=${suID}`,
            dataType: 'json',
            success: (response) => {
                // console.log(response);
                callback(response);
            }
        });
    }

    function populatePlantOptions(selectedMpcId) {
        let optionsHTML = ''; // Initialize the options HTML

        // AJAX call to fetch plant data
        $.ajax({
            url: '/ManageAccount/getPlant',
            method: 'GET',
            dataType: 'json',
            async: false, // Wait for the response before continuing
            success: function (response) {
                for (let i = 0; i < response.length; i++) {
                    const plant = response[i];
                    const isSelected = plant.mpc_id === selectedMpcId ? 'selected' : '';
                    optionsHTML += `<option value="${plant.mpc_id}" ${isSelected}>${plant.mpc_name}</option>`;
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });

        return optionsHTML; // Return the generated options HTML
    }

    function populatePermisIdOptions(selectedPermisId) {
        let optionsHTML = ''; // Initialize the options HTML

        // AJAX call to fetch plant data
        $.ajax({
            url: '/ManageAccount/getPermissionGroups',
            method: 'GET',
            dataType: 'json',
            async: false, // Wait for the response before continuing
            success: function (response) {
                for (let i = 0; i < response.length; i++) {
                    const permis = response[i];
                    const isSelected = permis.spg_id === selectedPermisId ? 'selected' : '';
                    optionsHTML += `<option value="${permis.spg_id}" ${isSelected}>${permis.spg_name}</option>`;
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });

        return optionsHTML; // Return the generated options HTML
    }
    function isValidEmail(email) {
        // Use a regular expression to validate email format
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }


})