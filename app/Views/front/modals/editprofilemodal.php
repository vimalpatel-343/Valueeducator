<div aria-hidden="true" id="search-modal-4" class="modal fade search-modal w-60" role="dialog" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="edit-content-1">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="font-lg-24-bold font-16-bold">Edit Profile</h3>
                    <button type="button" class="close text-decoration-none" id="save-profile-btn" style="background: none;">
                        Save & Close <img src="<?= base_url('images/cancel.svg') ?>">
                    </button>
                </div>
                
                <div class="text-center mb-4">
                    <div class="avatar-upload position-relative d-inline-block">
                        <div class="avatar-preview">
                            <div id="imagePreview" class="rounded-circle" style="background-image: url('<?php echo !empty(session()->get('userProfileImage')) ? base_url(session()->get('userProfileImage')) : base_url('images/no_image.png'); ?>'); width: 120px; height: 120px; background-size: cover; background-position: center;">
                            </div>
                            <div class="avatar-edit position-absolute" style="bottom: 5px; right: 5px; background: #007bff; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" style="display: none;" />
                                <label for="imageUpload" style="margin: 0; cursor: pointer; color: white;">
                                    <i class="fa fa-camera" style="font-size:16px;"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="foot-lnk sc-mt-10" id="error-profile-message" style="color:red; text-align: center; margin-bottom: 15px;"></div>
                
                <form id="edit-profile-form">
                    <div class="user_details-">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input_box">
                                    <label for="edit_name" class="form-label">Name</label>
                                    <input type="text" id="edit_name" name="edit_name" class="form-control" placeholder="Enter your name" value="<?php echo session()->get('userName'); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input_box">
                                    <label for="edit_email" class="form-label">Email ID</label>
                                    <input type="email" id="edit_email" name="edit_email" class="form-control" placeholder="Enter your email" value="<?php echo session()->get('userEmail'); ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input_box">
                                    <label for="edit_mobile" class="form-label">Phone Number</label>
                                    <input type="tel" id="edit_mobile" name="edit_mobile" class="form-control" value="<?php echo session()->get('userMobile'); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input_box">
                                    <label class="form-label">Date of Birth</label>
                                    <div class="d-flex gap-2">
                                        <div class="flex-grow-1">
                                            <input type="text" pattern="[0-9]*" id="day" name="day" maxlength="2" class="form-control" placeholder="DD" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="text" pattern="[0-9]*" id="month" name="month" maxlength="2" class="form-control" placeholder="MM" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="text" pattern="[0-9]*" id="year" name="year" maxlength="4" class="form-control" placeholder="YYYY" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="input_box">
                                    <label for="edit_pan_no" class="form-label">Tax Number</label>
                                    <input type="text" id="edit_pan_no" name="edit_pan_no" class="form-control" placeholder="Tax Number" required>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
</div>
<style>
/* Profile Picture Styles */
.avatar-upload {
    position: relative;
    display: inline-block;
}

.avatar-preview {
    position: relative;
    overflow: hidden;
    border-radius: 50%;
    width: 120px;
    height: 120px;
    border: 3px solid #f0f0f0;
    margin: 0 auto;
}

.avatar-preview > div {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}

.avatar-edit {
    position: absolute;
    right: 5px;
    bottom: 5px;
    z-index: 1;
}

.avatar-edit input {
    display: none;
}

.avatar-edit label {
    display: inline-block;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: #007bff;
    color: white;
    text-align: center;
    line-height: 35px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.avatar-edit label:hover {
    background: #0056b3;
}
</style>
<script>
 $(document).ready(function() {
    // Load profile data when modal is shown
    $('#search-modal-4').on('show.bs.modal', function(e) {
        $.ajax({
            url: base_url + 'auth/get-profile-data',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Populate form fields
                    $('#edit_name').val(response.user.name);
                    $('#edit_email').val(response.user.email);
                    $('#edit_mobile').val(response.user.mobile);
                    $('#edit_pan_no').val(response.user.pan_no);
                    $('#day').val(response.user.day);
                    $('#month').val(response.user.month);
                    $('#year').val(response.user.year);
                    
                    // Update profile image
                    if (response.user.profile_image) {
                        $('#imagePreview').css('background-image', 'url(' + base_url + response.user.profile_image + ')');
                    }
                }
            },
            error: function() {
                $('#error-profile-message').text('Failed to load profile data');
            }
        });
    });
    
    // Handle image preview
    $('#imageUpload').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
            };
            reader.readAsDataURL(file);
            
            // Upload the image
            uploadProfilePicture();
        }
    });
    
    // Handle form submission
    $('#edit-profile-form').submit(function(e) {
        e.preventDefault();
        
        // Show loading state
        $('#save-profile-btn').prop('disabled', true).html('Saving...');
        $('#error-profile-message').text('');
        
        // Get form data
        const formData = new FormData(this);
        
        // Submit form via AJAX
        $.ajax({
            url: base_url + 'auth/update-profile',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $('#error-profile-message').css('color', 'green').text(response.message);
                    
                    // Close modal after a short delay
                    setTimeout(function() {
                        $('#search-modal-4').modal('hide');
                        // Reload page to show updated profile
                        window.location.reload();
                    }, 1500);
                } else {
                    // Show error message
                    $('#error-profile-message').css('color', 'red').text(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Show error message
                $('#error-profile-message').css('color', 'red').text('An error occurred. Please try again.');
            },
            complete: function() {
                // Reset button state
                $('#save-profile-btn').prop('disabled', false).html('Save & Close');
            }
        });
    });
    
    // Function to upload profile picture
    function uploadProfilePicture() {
        const fileInput = document.getElementById('imageUpload');
        const file = fileInput.files[0];
        
        if (!file) return;
        
        const formData = new FormData();
        formData.append('imageUpload', file);
        
        // Submit image via AJAX
        $.ajax({
            url: base_url + 'auth/update-profile-picture',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (!response.success) {
                    // Show error message
                    $('#error-profile-message').css('color', 'red').text(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Show error message
                $('#error-profile-message').css('color', 'red').text('Failed to upload image. Please try again.');
            }
        });
    }
});
</script>