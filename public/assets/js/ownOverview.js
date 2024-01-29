$(() => {


    function showAccount() {
        $.ajax({
            method: "get",
            url: "/ownOverview/showProgress",
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
                                <td class="text-center">${data.sd_department_name}</td>
                                <td class="text-center">${data.su_firstname} ${data.su_lastname}</td>
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

})