$(() => {

    showSubList()


    function showSubList() {
        $.ajax({
            method: "get",
            url: "/ownOverview/showProgress",
            dataType: 'Json',
            success: (response) => {
                // console.log(response);
                if (response.length > 0) {
                    var html = "";
                    for (let i = 0; i < response.length; i++) {
                        let progression;
                        const data = response[i];
                        progression = data.progress;
                        // console.log(statusGet);
                        if (progression <= 100 && progression >= 80) {
                            progression = `<div class="d-flex justify-content-center col-auto">
                            <div class="progress my-2 w-50 mr-3 shadow-sm">
                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: ${data.progress}%" aria-valuenow="${data.progress}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold my-2 text-success"><span class="">${data.progress}%</span></h4>
                        </div>`
                        } else if (progression <= 79 && progression >= 50) {
                            progression = `<div class="d-flex justify-content-center col-auto">
                            <div class="progress my-2 w-50 mr-3 shadow-sm">
                                <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: ${data.progress}%" aria-valuenow="${data.progress}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold my-2 text-warning"><span class="">${data.progress}%</span></h4>
                        </div>`
                        } else if (progression <= 49 && progression >= 1) {
                            progression = `<div class="d-flex justify-content-center col-auto">
                            <div class="progress my-2 w-50 mr-3 shadow-sm">
                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: ${data.progress}%" aria-valuenow="${data.progress}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold my-2 text-danger"><span class="">${data.progress}%</span></h4>
                        </div>`
                        } else {
                            progression = `<div class="d-flex justify-content-center col-auto">
                            <div class="progress my-2 w-50 mr-3 shadow-sm">
                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold my-2 text-danger"><span class="">0%</span></h4>
                        </div>`
                        }
                        html += `
                            <tr>
                                <td>
                                    <div class="mt-2" style="--bs-text-opacity: .8;">${i + 1}</div>
                                </td>
                                <td>
                                    <div class="mt-2" style="--bs-text-opacity: .8;">${data.ss_subject_name}</div>
                                </td>
                                <td>${progression}</td>
                            </tr>`;
                        $('#tblOwn').dataTable().fnDestroy()
                        $("#tbody")
                            .html(html)
                            .promise()
                            .done(() => {
                                $("#tblOwn").dataTable({
                                    scrollX: true,
                                    responsive: true
                                });

                            });
                    }


                }
            },
            // error: (err) => {
            //     console.log(err);
            // },

        });

    };

})