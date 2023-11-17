$(() => {

    getView()



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


})