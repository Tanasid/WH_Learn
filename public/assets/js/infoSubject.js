$(() => {

    showSelDepartment()
    searchDep()

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
            $('#selSubject').html(populateSubjectOptions(selSubject));
            $("#search_box").show();
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
            url: '/managePermission/getMainMenu',
            method: 'GET',
            data: { ss_id: selectedSubId },
            dataType: 'json',
            async: false, // Wait for the response before continuing
            success: function (response) {
                for (let i = 0; i < response.length; i++) {
                    const mainMenu = response[i];
                    const isSelected = mainMenu.smm_id === selectedSubId ? 'selected' : '';
                    optionsHTML += `<option value="${mainMenu.smm_id}" >${mainMenu.smm_name}</option>`;
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });

        return optionsHTML; // Return the generated options HTML
    }

})