$(() => {

    editProfile()

    function editProfile() {
        var userId = $('#topbar_user_id').val();
        var oldFname, oldLname, oldEmail, oldPass, oldPlant, nameDefult;

        $(document).ready(function () {
            // alert("userID: " + userId);
            // return;
            $.ajax({
                url: '/ManageAccount/getDataEdit',
                method: 'GET',
                data: { userID: userId },
                dataType: 'json',
                success: function (response) {
                    // console.log(response);
                    // return;
                    if (response.length = 1) {
                        const data = response[0];
                        let textStatus
                        if (data.su_status_flg == 1) {
                            textStatus = '<option value="1">Enable</option>';
                        } else {
                            textStatus = '<option value="0">Disable</option>';
                        }
                        $('#emp_code').val(data.su_emp_code);
                        $('#su_firstname').val(data.su_firstname);
                        $('#su_lastname').val(data.su_lastname);
                        $('#su_email').val(data.su_email);
                        $('#password').val(data.su_emp_password);
                        $('#selPlantAdd').html(populatePlantOptions(data.mpc_id));
                        $('#selPermis').html(populatePermisIdOptions(data.spg_id));
                        $('#status_flg').html(textStatus);
                        nameDefult = data.su_emp_code;
                        oldId = data.su_id;
                        oldFname = data.su_firstname
                        oldLname = data.su_lastname
                        oldEmail = data.su_email
                        oldPass = data.su_emp_password
                        oldPlant = $('#selPlantAdd').val().trim();
                    }


                }

            });
        })

        $(document).on('click', '#editButton', function () {
            
            Swal.fire({
                title: 'Are you sure?',
                text: 'Please check the information before saving.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, save changes',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#28b76d',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    var suId = userId;
                    var suEmpCode = $('#editProfileForm #emp_code').val();
                    var suEmpPassword = $('#editProfileForm #password').val();
                    var spgId = $('#editProfileForm #selPermis').val();
                    var suFirstName = $('#editProfileForm #su_firstname').val();
                    var suLastName = $('#editProfileForm #su_lastname').val();
                    var suEmail = $('#editProfileForm #su_email').val();
                    var mpcId = $('#editProfileForm #selPlantAdd').val();

                    if (suFirstName == "") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'First Name is required',
                        }).then(() => {
                            $('#inpFirstName').focus();
                        });
                        return false;
                    }
                    if (suLastName == "") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Last Name is required',
                        }).then(() => {
                            $('#inpLastName').focus();
                        });
                        return false;
                    }
                    if (suEmail == "") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Email is required',
                        }).then(() => {
                            $('#inpEmail').focus();
                        });
                        return false;
                    }
                    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                    if (!emailPattern.test(suEmail)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Invalid Email Format',
                        }).then(() => {
                            $('#inpEmail').focus();
                        });
                        return false;
                    }
                    if (suEmpCode === nameDefult && suFirstName === oldFname && suLastName === oldLname && suEmail === oldEmail && suEmpPassword === oldPass && mpcId === oldPlant) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: 'The data has not been edited.',
                        });
                        return;
                    }
                    // Send data to the server using AJAX
                    $.ajax({
                        url: '/editProfile/updateProfile', // Replace with your controller URL
                        method: 'POST',
                        data: {
                            nameControl: nameDefult,
                            oldPassword: oldPass,
                            suID: suId,
                            empCode: suEmpCode,
                            empPassword: suEmpPassword,
                            firstName: suFirstName,
                            lastName: suLastName,
                            email: suEmail,
                            permissionGroup: spgId,
                            plant: mpcId
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Update Profile successfully',
                                    timer: 3500 // Set the timeout duration in milliseconds
                                });
                                oldFname = $('#su_firstname').val().trim();
                                oldLname = $('#su_lastname').val().trim();
                                oldEmail = $('#su_email').val().trim();
                                oldPass = $('#password').val().trim();
                                oldPlant = $('#selPlantAdd').val().trim();
                            } else {
                                // Show an error message using SweetAlert2
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                });
                                $('#editProfileForm #emp_code').val(nameDefult);
                            }
                        },
                        error: function (error) {
                            // console.log(error);
                            // return;
                            Swal.fire('Error', 'invalid data found when processing input', 'error');
                        }
                    });
                }
            });
        })


        $(document).on('click', '#saveNewPassword', function () {
            var newPass = $('#inpNewPassword').val().trim();
            var ConfirmPass = $('#inpConfirmPassword').val().trim();
            const thaiPattern = /[\u0E00-\u0E7F]/;

            Swal.fire({
                title: 'Confirm Save New Password',
                text: 'Are you sure you want to save the new password?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28b76d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (newPass === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'New Password is Required.',
                    });
                    $('#inpNewPassword').val('');
                    return;
                }
                if (ConfirmPass === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Confirm Password is Required',
                    });
                    $('#inpConfirmPassword').val('');
                    return;
                }
                if (thaiPattern.test(newPass)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'New Password Error',
                        text: 'Please do not enter Thai characters.',
                    });
                    $('#inpNewPassword').val('');
                    return;
                }
                if (thaiPattern.test(ConfirmPass)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Confirm Password Error',
                        text: 'Please do not enter Thai characters.',
                    });
                    $('#inpConfirmPassword').val('');
                    return;
                }
                if (newPass !== ConfirmPass) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Error',
                        text: 'The password information does not match. Please check.',
                    });
                    return;
                }
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'The new password was successfully updated.',
                        timer: 2000, // Set the timer for auto-closing alert
                        showConfirmButton: true
                    });
                    $('#password').val(newPass);
                    $('#inpNewPassword').val('');
                    $('#inpConfirmPassword').val('');
                    $('#mdlNewPassword').modal('hide');
                }
                // Perform the update via AJAX

            });
        })

        $(document).on('click', '#mdlClose', function () {
            $('#inpNewPassword').val('');
            $('#inpConfirmPassword').val('');
        });

    }

    function populatePlantOptions(selectedMpcId) {
        // console.log('Selected MPC ID:', selectedMpcId);
        let optionsHTML = ''; // Initialize the options HTML

        // AJAX call to fetch plant data
        $.ajax({
            url: '/ManageAccount/getPlant',
            method: 'GET',
            dataType: 'json',
            async: false,
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
            url: '/manageAccount/getPermissionGroups',
            method: 'GET',
            dataType: 'json',
            async: false, // Wait for the response before continuing
            success: function (response) {
                // console.log(response);
                // return;
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


})
