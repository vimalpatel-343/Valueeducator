class ScuttlebuttModal {
    constructor() {
        this.modalId = 'scuttlebut-modal';
        this.init();
    }

    init() {
        // Create modal if it doesn't exist
        if (!$(`#${this.modalId}`).length) {
            this.createModal();
        }

        // Bind click events to elements with scuttlebutt-trigger class
        $(document).on('click', '.scuttlebutt-trigger', (e) => {
            e.preventDefault();
            const productId = $(e.currentTarget).data('product');
            this.loadScuttlebuttNotes(productId);
        });
    }

    createModal() {
        const modalHTML = `
            <div id="${this.modalId}" class="modal fade search-modal w-90" role="dialog" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="d-flex gap-2 justify-content align-items-center">
                            <h3 class="font-lg-16-bold">Scuttlebutt notes</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="background: none;">
                                Close
                                <img src="${base_url || ''}/images/cancel.svg">
                            </button>
                        </div>
                        <div class="tabs_wrapper">
                            <ul class="tabs-company" id="tabs-list">
                                <!-- Tabs will be loaded dynamically -->
                            </ul>
                            <div class="tab_container" id="tab-container">
                                <!-- Tab content will be loaded dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('body').append(modalHTML);
    }

    loadScuttlebuttNotes(productId) {
        const modal = $(`#${this.modalId}`);
        const tabsList = modal.find('#tabs-list');
        const tabContainer = modal.find('#tab-container');
        
        // Clear existing content
        tabsList.empty();
        tabContainer.empty();
        
        // Show loading indicator
        tabsList.html('<li class="loading">Loading...</li>');
        
        // Show modal
        modal.modal('show');
        
        // Fetch scuttlebutt notes via AJAX
        $.ajax({
            url: `/get-scuttlebutt-notes/${productId}`,
            method: 'GET',
            dataType: 'json',
            success: (response) => {
                this.renderContent(response, tabsList, tabContainer);
            },
            error: () => {
                tabsList.html('<li class="error">Error loading data</li>');
            }
        });
    }

    formatDate(dateString) {
        const date = new Date(dateString);
        const day = date.getDate();
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        const month = monthNames[date.getMonth()];
        const year = date.getFullYear();
        
        // Format as "4 Dec 2025" (remove leading zero from day)
        return `${day} ${month} ${year}`;
    }

    renderContent(notes, tabsList, tabContainer) {
        // Clear loading indicator
        tabsList.empty();
        
        if (!notes || notes.length === 0) {
            tabsList.html('<li class="no-data">No scuttlebutt notes available</li>');
            return;
        }
        
        // Sort notes by date in descending order (newest first)
        const sortedNotes = [...notes].sort((a, b) => new Date(b.fld_date) - new Date(a.fld_date));
        
        // Generate tabs and content
        sortedNotes.forEach((note, index) => {
            const tabId = `tab${index + 1}`;
            const isActive = index === 0 ? 'active' : '';
            const isDisplayed = index === 0 ? 'style="display: block;"' : '';
            const isHeadingActive = index === 0 ? 'd_active' : '';
            
            // Format the date
            const formattedDate = this.formatDate(note.fld_date);
            
            // Create tab
            const tab = $(`
                <li class="${isActive}" rel="${tabId}">
                    ${note.fld_title}<br>
                    ${formattedDate}
                </li>
            `);
            tabsList.append(tab);
            
            // Create tab content
            const tabContent = $(`
                <div id="${tabId}" class="tab_content" ${isDisplayed}>
                    <h3 class="tab_drawer_heading ${isHeadingActive}" rel="${tabId}">${formattedDate}</h3>
                    ${note.fld_description}
                </div>
            `);
            tabContainer.append(tabContent);
        });
        
        // Initialize tab functionality
        this.initializeTabs();
    }

    initializeTabs() {
        // Tab switching
        $(".tabs-company li").off('click').on('click', function() {
            const tabId = $(this).attr("rel");
            
            // Remove active class from all tabs and contents
            $(".tabs-company li").removeClass("active");
            $(".tab_content").hide();
            $(".tab_drawer_heading").removeClass("d_active");
            
            // Add active class to clicked tab
            $(this).addClass("active");
            
            // Show corresponding content
            $("#" + tabId).show();
            $(".tab_drawer_heading[rel='" + tabId + "']").addClass("d_active");
        });
        
        // Mobile tab switching
        $(".tab_drawer_heading").off('click').on('click', function() {
            const tabId = $(this).attr("rel");
            
            // Remove active class from all tabs and contents
            $(".tabs-company li").removeClass("active");
            $(".tab_content").hide();
            $(".tab_drawer_heading").removeClass("d_active");
            
            // Add active class to clicked heading
            $(this).addClass("d_active");
            
            // Show corresponding content
            $("#" + tabId).show();
            $(".tabs-company li[rel='" + tabId + "']").addClass("active");
        });
    }
}

// Initialize the ScuttlebuttModal when DOM is ready
 $(document).ready(() => {
    new ScuttlebuttModal();
});