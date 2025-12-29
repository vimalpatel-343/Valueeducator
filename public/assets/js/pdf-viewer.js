document.querySelectorAll('.open-pdf').forEach(el => {
    el.addEventListener('click', function (e) {
        e.preventDefault();
        
        const file = this.dataset.file;
        const type = this.dataset.type;
        const stock = this.dataset.stock || '';
        
        // Show loading indicator
        const originalHtml = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        
        // Function to open PDF with token
        const openPdf = () => {
            fetch('/pdf/generate-token/' + type + '/' + file, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const viewerUrl = '/pdfjs/web/viewer.html?file=' + 
                        encodeURIComponent('/pdf/view-with-token/' + data.token);
                    
                    // Open in new tab
                    const newWindow = window.open(viewerUrl, '_blank');
                    
                    // Focus on new window
                    if (newWindow) {
                        newWindow.focus();
                        
                        // Set up a timer to refresh the token before it expires
                        setTimeout(() => {
                            // Check if the window is still open
                            if (!newWindow.closed) {
                                // Generate a new token silently
                                fetch('/pdf/generate-token/' + type + '/' + file, {
                                    method: 'GET',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                }).catch(error => {
                                    console.log('Token refresh failed:', error);
                                });
                            }
                        }, 240000); // Refresh at 4 minutes (before 5 minute expiry)
                    }
                } else {
                    this.showErrorMessage(data.message, data.error_type);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.showErrorMessage('An error occurred while loading the PDF', 'network_error');
            })
            .finally(() => {
                // Restore original HTML
                this.innerHTML = originalHtml;
            });
        };
        
        // Open PDF immediately
        openPdf();
    });
    
    // Method to show error message
    this.showErrorMessage = function(message, errorType) {
        // Create a modal or alert based on error type
        let modalHtml = '';
        
        switch(errorType) {
            case 'auth_required':
                modalHtml = `
                    <div class="modal fade" id="pdfErrorModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title">
                                        <i class="fas fa-user-lock me-2"></i>Authentication Required
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>${message}</p>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="/auth" class="btn btn-primary">
                                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                        </a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                break;
                
            case 'no_subscription':
            case 'product_access_denied':
                modalHtml = `
                    <div class="modal fade" id="pdfErrorModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title">
                                        <i class="fas fa-lock me-2"></i>Access Denied
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>${message}</p>
                                    <p class="text-muted small">
                                        <i class="fas fa-info-circle me-1"></i>
                                        PDF links are valid for 5 minutes and can be refreshed.
                                    </p>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="/emerging-titans" class="btn btn-primary">
                                            <i class="fas fa-crown me-2"></i>View Plans
                                        </a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                break;
                
            default:
                modalHtml = `
                    <div class="modal fade" id="pdfErrorModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h5 class="modal-title">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Unable to Load PDF
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>${message}</p>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
        }
        
        // Remove existing modal if any
        const existingModal = document.getElementById('pdfErrorModal');
        if (existingModal) {
            existingModal.remove();
        }
        
        // Add modal to body and show it
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        const modal = new bootstrap.Modal(document.getElementById('pdfErrorModal'));
        modal.show();
        
        // Clean up modal after hidden
        document.getElementById('pdfErrorModal').addEventListener('hidden.bs.modal', function () {
            this.remove();
        });
    };
});