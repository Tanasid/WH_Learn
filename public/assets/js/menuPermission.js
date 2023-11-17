$(() => {

    dashboard()
    showMainMenu()

    
    function showMainMenu() {
        var currentPath = window.location.pathname.substring(1);
        // console.log(currentPath);
        $.ajax({
            method: "get",
            url: "/Menupermission",
            dataType: 'json',
            success: (response) => {
                // console.log(response);
                if (response.length > 0) {
                    for (let i = 0; i < response.length; i++) {
                        let collapsed = 'collapsed';
                        let show = '';
                        let activeMain = '';
                        const data = response[i];
                        fetchSubMenu(data['smm_id'], function (submenuData) {
                            var htmlSub = ""; // Initialize htmlSub here
                            for (let j = 0; j < submenuData.length; j++) {
                                const submenu = submenuData[j];
                                let active = '';
                                if (submenu['smd_link'] == currentPath) {
                                    collapsed = '';
                                    active = 'active';
                                    // activeMain = 'active';
                                    show = 'show';
                                }
                                htmlSub += `<a class="collapse-item sidebar-actives ${active}" href="/${submenu['smd_link']}">${submenu['smd_name']}</a>`;
                            }
                            // Update the sub-menu content
                            $(`#subMenuByID${data['smm_id']}`).html(htmlSub);

                            // Generate the main menu item HTML
                            var html = `
                            <li class="nav-item ${activeMain}">
                                <a class="nav-link ${collapsed}" href="" data-toggle="collapse" data-target="#${data['smm_name']}" aria-expanded="true" aria-controls="collapseTwo">
                                    <i class="${data['smm_icon']}"></i>
                                    <span>${data['smm_name']}</span>
                                </a>
                                <div id="${data['smm_name']}" class="collapse ${show}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                    <div class="bg-white py-2 collapse-inner rounded subMenuAC" id="subMenuByID${data['smm_id']}">
                                        ${htmlSub}
                                    </div>
                                </div>
                            </li>`;

                            // Append the HTML to the element with ID "testMenu"
                            $("#MenuPermis").append(html);
                        });
                    }
                }
            }
        });
        // activeClass()
    }

    // Function to fetch submenu data using AJAX
    function fetchSubMenu(smmId, callback) {
        $.ajax({
            method: "get",
            url: `/SubMenuPermission?smm_id=${smmId}`,
            dataType: 'json',
            success: (response) => {
                callback(response);
            }
        });
    }

    function dashboard() {
        let currentPath = window.location.pathname.substring(1);
        let linkDash = $('#dashBoard').attr('href');
        if(linkDash == currentPath || currentPath == 'start') {
            $('#dashMain').addClass('active');
        }
    }


});
