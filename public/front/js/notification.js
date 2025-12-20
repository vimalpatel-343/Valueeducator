 $(document).ready(function() {
    // Toggle notification dropdown
    window.toggleBox = function(boxId, element, event) {
        event.preventDefault();
        event.stopPropagation();
        
        // Hide all dropdowns first
        $('.notification-dropdown, .user-dropdown').hide();
        
        // Toggle the requested dropdown
        const $box = $('#' + boxId);
        
        if ($box.is(':visible')) {
            $box.hide();
        } else {
            // Position the dropdown based on which box is being toggled
            if (boxId === 'box2') {
                // Notification dropdown
                const $notification = $(element);
                const offset = $notification.offset();
                
                // Calculate position
                const topPosition = offset.top + $notification.outerHeight() + 10;
                const leftPosition = offset.left - $box.outerWidth() + $notification.outerWidth();
                
                $box.css({
                    'position': 'absolute',
                    'top': topPosition,
                    'left': leftPosition,
                    'z-index': 1000
                }).show();
            } else if (boxId === 'box1') {
                // User dropdown - create it if it doesn't exist
                if ($('#box1').length === 0) {
                    createUserDropdown();
                }
                
                const $userImage = $(element);
                const offset = $userImage.offset();
                
                // Calculate position
                const topPosition = offset.top + $userImage.outerHeight() + 10;
                const leftPosition = offset.left - $('#box1').outerWidth() + $userImage.outerWidth();
                
                $('#box1').css({
                    'position': 'absolute',
                    'top': topPosition,
                    'left': leftPosition,
                    'z-index': 1000
                }).show();
            }
        }
    };
    
    // Create user dropdown dynamically
    function createUserDropdown() {
        const userName = '<?= session()->get("userName") ?>';
        const userEmail = '<?= session()->get("userEmail") ?>';
        const userProfileImage = '<?= session()->get("userProfileImage") ?>';
        
        const userDropdown = `
            <div class="user-dropdown" id="box1" style="display: none;">
                <div class="box p-0">
                    <div class="user-info p-3 text-center">
                        <div class="user-avatar mb-2">
                            <img src="${userProfileImage || 'images/no_image.png'}" alt="${userName}" class="rounded-circle" width="80" height="80">
                        </div>
                        <h3 class="font-lg-16-bold">${userName}</h3>
                        <p class="font-lg-14-normal text-muted">${userEmail}</p>
                    </div>
                    <div class="dropdown-menu-items">
                        <a href="${base_url}profile" class="dropdown-item">
                            <i class="fas fa-user"></i> My Profile
                        </a>
                        <a href="${base_url}dashboard" class="dropdown-item">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a href="${base_url}settings" class="dropdown-item">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="${base_url}auth/logout" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt"></i> Sign Out
                        </a>
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(userDropdown);
    }
    
    // Close dropdowns when clicking outside
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.welc-user').length && !$(event.target).closest('.notification-dropdown').length && !$(event.target).closest('.user-dropdown').length) {
            $('.notification-dropdown, .user-dropdown').hide();
        }
    });
    
    // Update download ebook function
    window.updateDownloadEbook = function(ebookUrl) {
        // Log the download or perform any other action
        console.log('E-book downloaded:', ebookUrl);
        
        // You can also send an AJAX request to track the download
        $.ajax({
            url: base_url + 'track/ebook-download',
            type: 'POST',
            data: { url: ebookUrl },
            dataType: 'json',
            success: function(response) {
                console.log('Download tracked successfully');
            },
            error: function() {
                console.log('Failed to track download');
            }
        });
        
        return true; // Allow the default link behavior
    };
});