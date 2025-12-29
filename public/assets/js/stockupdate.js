class StockUpdateModal {
    constructor() {
        this.modalId = 'stock-update-modal';
        this.init();
    }

    init() {
        if (!$(`#${this.modalId}`).length) {
            this.createModal();
        }

        $(document).on('click', '.stock-link', (e) => {
            e.preventDefault();
            const productId = $(e.currentTarget).data('product-id');
            const stockId   = $(e.currentTarget).data('stock-id');
            const stockName = $(e.currentTarget).data('stock-name');
            this.loadStockUpdates(productId, stockId, stockName);
        });
    }

    createModal() {
        const modalHTML = `
            <div id="${this.modalId}" class="modal fade search-modal- w-90" tabindex="-1">
                <div class="modal-dialog modal-xl p-2">
                    <div class="modal-content p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="font-lg-20-bold stock-modal-title">Stock Updates</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="background: none; border: 0px; color: #000000;">
                                Close
                                <img src="${base_url || ''}/images/cancel.svg">
                            </button>
                        </div>

                        <div class="tabs_wrapper">
                            <ul class="tabs-company" id="stock-tabs-list"></ul>
                            <div class="tab_container" id="stock-tab-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('body').append(modalHTML);
    }

    loadStockUpdates(productId, stockId, stockName) {
        const modal        = $(`#${this.modalId}`);
        const tabsList     = modal.find('#stock-tabs-list');
        const tabContainer = modal.find('#stock-tab-container');

        modal.find('.stock-modal-title').text(`${stockName} - Updates`);

        tabsList.empty();
        tabContainer.empty();
        tabsList.html('<li class="loading">Loading...</li>');

        modal.modal('show');

        $.ajax({
            url: `/get-stock-updates/${productId}/${stockId}`,
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

    isMobile() {
        return window.innerWidth <= 767;
    }

    formatDate(dateString) {
        const date = new Date(dateString);
        const monthNames = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
        return `${date.getDate()} ${monthNames[date.getMonth()]} ${date.getFullYear()}`;
    }

    renderContent(updates, tabsList, tabContainer) {
        tabsList.empty();
        tabContainer.empty();

        if (!updates || updates.length === 0) {
            tabContainer.html('<p>No stock updates available</p>');
            return;
        }

        const sortedUpdates = [...updates].sort(
            (a, b) => new Date(b.fld_update_date) - new Date(a.fld_update_date)
        );

        /* ======================
           MOBILE → ACCORDION
        ====================== */
        if (this.isMobile()) {
            sortedUpdates.forEach(update => {
                const date = this.formatDate(update.fld_update_date);

                tabContainer.append(`
                    <div class="sc-accordion-item">
                        <button class="sc-accordion-header">
                            <span>${date}</span>
                            <span class="icon">+</span>
                        </button>
                        <div class="sc-accordion-body" style="display:none;">
                            ${update.fld_description}
                        </div>
                    </div>
                `);
            });

            this.initializeAccordion();
            return;
        }

        /* ======================
           DESKTOP → TABS
        ====================== */
        sortedUpdates.forEach((update, index) => {
            const tabId = `stock-tab-${index + 1}`;
            const active = index === 0 ? 'active' : '';
            const show   = index === 0 ? 'style="display:block;"' : '';
            const date   = this.formatDate(update.fld_update_date);

            tabsList.append(`
                <li class="${active}" rel="${tabId}">
                    ${date}
                </li>
            `);

            tabContainer.append(`
                <div id="${tabId}" class="tab_content" ${show}>
                    <h3 class="tab_drawer_heading ${active}" rel="${tabId}">
                        ${date}
                    </h3>
                    ${update.fld_description}
                </div>
            `);
        });

        this.initializeTabs();
    }

    initializeTabs() {
        $("#stock-tabs-list li").off().on('click', function () {
            const tabId = $(this).attr("rel");

            $("#stock-tabs-list li").removeClass("active");
            $(".tab_content").hide();
            $(".tab_drawer_heading").removeClass("d_active");

            $(this).addClass("active");
            $("#" + tabId).show();
            $(".tab_drawer_heading[rel='" + tabId + "']").addClass("d_active");
        });
    }

    initializeAccordion() {
        $(".sc-accordion-header").off().on('click', function () {
            const body = $(this).next(".sc-accordion-body");

            $(".sc-accordion-body").not(body).slideUp();
            body.slideToggle();
        });
    }
}

$(document).ready(() => {
    new StockUpdateModal();
});
