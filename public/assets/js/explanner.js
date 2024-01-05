$(() => {

    refreshContent()

    function refreshContent() {
        $.ajax({
            type: "get",
            url: "/explanner/getDocument", // Replace with your server endpoint to update the state
            dataType: 'json',
            success: function (response) {
                const data = response[0];
                // console.log(data);
                $('#inpLink').val(data.ss_document);
                $('#inpDocument').val(data.ss_document);
                $('#videoContent').attr('src', data.ss_document);
                $('#downloadLink').attr('href', data.ss_document);
                console.log($('#videoContent').attr('src'));
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

})