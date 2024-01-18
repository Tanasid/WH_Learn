$(() => {

    refreshContent()

    function refreshContent() {
        var video = document.getElementById('videoContent');
        var storedTime = localStorage.getItem('videoPlaybackPosition');
        var base_url = $('#base_url').val();

        video.addEventListener('loadedmetadata', function() {
            // Log the total duration to the console
            let fulltime = video.duration;
            console.log(fulltime);
        });

        $.ajax({
            type: "get",
            url: "/explanner/getDocument", // Replace with your server endpoint to update the state
            dataType: 'json',
            success: function (response) {
                const data = response[0];
                // console.log(data);
                $('#inpLink').val(data.ss_link);
                $('#inpDocument').val(data.ss_document);
                $('#downloadLink').attr('href', data.ss_document);
                $('#name_content').text(data.ss_subject_name);
                $('#videoContent source').attr('src', base_url+data.ss_link);
                $('#videoContent')[0].load();
                console.log("startTime => "+storedTime);
                video.currentTime = storedTime;
                
                // console.log($('#videoContent source').attr('src'));
                // console.log(base_url+data.ss_link);
            },
            error: function (error) {
                console.log(error)
            }
        });

        $('#inpLink').on('click', function () {
            let content = base_url+$('#inpLink').val();
            // console.log(picture);
            window.open(content, '_blank');
            content = ''
            // console.log(picture)
        });



        $('#videoContent').on('click', function () {
            if (video.paused && !video.ended) {
                // Set the playback position if available
                // if (storedTime) {
                //     video.currentTime = parseFloat(storedTime);
                // }
            }
        });

        video.addEventListener('timeupdate', function () {
            localStorage.setItem('videoPlaybackPosition', video.currentTime);
            // console.log(video.currentTime);
        });

        // Handle page visibility change (e.g., user switches tabs)
        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'hidden') {
                // Save the playback position when the page is hidden
                localStorage.setItem('videoPlaybackPosition', video.currentTime);
                storedTime = localStorage.getItem('videoPlaybackPosition');
                video.pause()
                console.log(storedTime);
            }
        });

    }

    function checkTimeContent(timeContent) {
        let optionsHTML = ''; // Initialize the options HTML
        // AJAX call to fetch plant data
        $.ajax({
            url: '/infoSubject/getSubject',
            method: 'GET',
            data: { timeContent: timeContent },
            dataType: 'json',
            async: false, // Wait for the response before continuing
            success: function (response) {
                for (let i = 0; i < response.length; i++) {
                    const subject = response[i];
                    const isSelected = subject.ss_id === selectedSubId ? 'selected' : '';
                    optionsHTML += `<option value="${subject.ss_id}" >${subject.ss_subject_name}</option>`;
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
        return optionsHTML; // Return the generated options HTML
    }


})