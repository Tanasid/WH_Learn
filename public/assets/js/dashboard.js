$(() => {

    getView()
    showSubject()

    function getView() {
        $(document).ready(function () {
            $.ajax({
                method: "get",
                url: `/dashboard/getView`,
                dataType: 'json',
                success: (response) => {
                    const data = response[0];
                    $('#text_view').html(data['QTY']);
                }
            });

            $.ajax({
                method: "get",
                url: `/dashboard/getUser`,
                dataType: 'json',
                success: (response) => {
                    const data = response[0];
                    $('#text_user').html(data['QTY']);
                }
            });

        });
    }

    function showSubject() {
        $.ajax({
            method: "get",
            url: "/dashboard/getSubject",
            dataType: 'Json',
            success: (response) => {
                // console.log(response);
                if (response.length > 0) {
                    var html = "";
                    const data = response[0];
                    // console.log(data);
                    // return;
                    html += `
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">All Progressing
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 pl-2 mr-3 font-weight-bold text-gray-800">${data.summary}%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: ${data.summary}%" aria-valuenow="${data.summary}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>`;
                    $("#content_card").html(html)

                }
            },
            // error: (err) => {
            //     console.log(err);
            // },

        });

    };


})