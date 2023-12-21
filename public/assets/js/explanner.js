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
                $('#videoContent').attr('src', $('#inpDocument').val());
                // console.log(response);
            },
            error: function () {
                Swal.fire({
                    title: 'Errors!',
                    text: 'Updated Status Flag Errors!.',
                    icon: 'error'
                })
            }
        });

        // $('#inpDocument').click(function () {
        //     var fileContent = $(this).val();
        //     var fileExtension = fileContent.split('.').pop().toLowerCase();
        //     var contentType = getContentType(fileExtension);

        //     var blob = new Blob([fileContent], { type: contentType });

        //     $('#downloadLink').attr('href', window.URL.createObjectURL(blob));

        //     // Debugging information
        //     console.log('File Content:', fileContent);
        //     console.log('File Extension:', fileExtension);
        //     console.log('Content Type:', contentType);
        //     console.log('Blob:', blob);

        //     // Trigger the download link click
        //     $('#downloadLink')[0].click();
        // });

        function getContentType(extension) {
            switch (extension) {
                case 'txt':
                    return 'text/plain;charset=utf-8';
                case 'pdf':
                    return 'application/pdf';
                default:
                    return 'application/octet-stream';
            }
        }

    }

})