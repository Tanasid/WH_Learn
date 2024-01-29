$(() => {

    refreshContent()

    function refreshContent() {
        var video = document.getElementById('videoContent');
        var storedTime = localStorage.getItem('videoPlaybackPosition');
        var base_url = $('#base_url').val();
        var su_id = $('#topbar_user_id').val()
        var ss_id;

        $.ajax({
            type: "get",
            url: "/FA/getDocument", // Replace with your server endpoint to update the state
            dataType: 'json',
            success: function (response) {
                const data = response[0];
                // console.log(data);
                $('#inpLink').val(data.ss_link);
                $('#inpDocument').val(data.ss_document);
                $('#downloadLink').attr('href', data.ss_document);
                $('#name_content').text(data.ss_subject_name);
                $('#videoContent source').attr('src', base_url + data.ss_link);
                $('#videoContent')[0].load();
                ss_id = data.ss_id;

                // console.log($('#videoContent source').attr('src'));
                // console.log(base_url+data.ss_link);
            },
            error: function (error) {
                console.log(error)
            }
        });

        video.addEventListener('loadedmetadata', function () {
            // Log the total duration to the console
            let fulltime = video.duration;
            checkTimeContent(parseFloat(fulltime), su_id, ss_id)
            // console.log(parseFloat(fulltime));
        });

        $('#inpLink').on('click', function () {
            let contentId = $('#inpLink').val();
            window.open(base_url + contentId, '_blank')
        });

        // $('#videoContent').on('click', function () {
        //     if (video.paused && !video.ended) {
        //         cru_time = localStorage.getItem('videoPlaybackPosition');
        //         updateCurrentTime(cru_time, su_id, ss_id);
        //     }
        // });

        video.addEventListener('timeupdate', function () {
            localStorage.setItem('videoPlaybackPosition', video.currentTime);
            // console.log(video.currentTime);
        });

        // Handle page visibility change (e.g., user switches tabs)
        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'hidden') {
                // Save the playback position when the page is hidden
                localStorage.setItem('videoPlaybackPosition', video.currentTime);
                cru_time = localStorage.getItem('videoPlaybackPosition');
                video.pause()
                console.log("pauseVideo => " + cru_time);
                updateCurrentTime(cru_time, su_id, ss_id);
            }
        });

        function checkTimeContent(timeContent, su_id, ss_id) {
            // AJAX call to fetch plant data
            $.ajax({
                url: '/FA/checkTimeContent',
                method: 'POST',
                data: { timeContent: timeContent, su_id: su_id, ss_id: ss_id },
                type: 'json',
                async: false, // Wait for the response before continuing
                success: function (response) {
                    let video = document.getElementById('videoContent');
                    if (response.success) {
                        console.log(response.message);
                        // console.log("startTime => " + response.cru_time);
                        if(response.cru_time == null) {
                            return;
                        }else {
                            video.currentTime = response.cru_time;
                        }
                    }
                    return;
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function updateCurrentTime(cru_time, su_id, ss_id) {
            $.ajax({
                url: '/FA/updateTimeCurrent',
                method: 'POST',
                data: { cru_time: cru_time, su_id: su_id, ss_id: ss_id },
                type: 'json',
                async: false, // Wait for the response before continuing
                success: function (response) {
                    // let video = document.getElementById('videoContent');
                    if (response.success) {
                        // console.log(response.message);
                        // console.log("pauseVideo2 => " + storedTime);
                        console.log("startTime is (response.cru_time) => " + response.cru_time);
                        video.currentTime = response.cru_time;
                    } else {
                        // console.log("fail updated is => " + response.message);
                        video.currentTime = response.cru_time;
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

    }




})