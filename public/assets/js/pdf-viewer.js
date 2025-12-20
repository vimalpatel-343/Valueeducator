/**
 * Reusable PDF Viewer
 * Prevents downloading, copying, and right-clicking
 */
class PDFViewer {
    constructor() {
        this.modal = null;
        this.pdfViewer = null;
        this.pdfTitle = null;
        this.initialized = false;
        this.init();
    }

    init() {
        // Add polyfill for closest if not available
        if (!Element.prototype.closest) {
            Element.prototype.closest = function(s) {
                var el = this;
                do {
                    if (el.matches && el.matches(s)) return el;
                    el = el.parentElement || el.parentNode;
                } while (el !== null && el.nodeType === 1);
                return null;
            };
        }
        
        // Create modal if it doesn't exist
        this.createModal();
        
        // Initialize modal after a short delay to ensure DOM is ready
        setTimeout(() => {
            this.initializeModal();
        }, 100);
    }

    createModal() {
        // Check if modal already exists
        if (document.getElementById('pdfModal')) {
            return;
        }

        const modalHTML = `
            <div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true" style="z-index: 99999999 !important;">
                <div class="modal-dialog modal-xl modal-dialog-centered" style="max-width: 98%;">
                    <div class="modal-content p-0" style="border-radius: 6px;">
                        <!-- Title Bar -->
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="m-0" id="pdfTitle"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <!-- PDF Body -->
                        <div class="modal-body p-0">
                            <div id="pdfViewer" style="width:100%; height:88vh; overflow:auto; background:#f0f0f0; position: relative; text-align: center;">
                                <div class="pdf-loading text-center py-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2">Loading PDF...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    initializeModal() {
        // Get modal elements
        const modalElement = document.getElementById('pdfModal');
        if (!modalElement) {
            console.error('PDF Modal not found');
            return;
        }

        // Initialize Bootstrap modal
        this.modal = new bootstrap.Modal(modalElement);
        this.pdfViewer = document.getElementById('pdfViewer');
        this.pdfTitle = document.getElementById('pdfTitle');

        // Check if elements exist
        if (!this.pdfViewer || !this.pdfTitle) {
            console.error('PDF Viewer elements not found');
            return;
        }

        // Bind events
        this.bindEvents();
        this.initialized = true;
    }

    bindEvents() {
        // Handle PDF links
        document.addEventListener('click', (e) => {
            // Use a safe method to find the closest element
            let target = e.target;
            while (target && target !== document) {
                if (target.classList && target.classList.contains('open-pdf')) {
                    e.preventDefault();
                    const pdfUrl = target.getAttribute('data-pdf');
                    const stockName = target.getAttribute('data-stock') || 'PDF Viewer';
                    
                    // Ensure modal is initialized before opening
                    if (!this.initialized) {
                        this.initializeModal();
                    }
                    
                    this.openPDF(pdfUrl, stockName);
                    break;
                }
                target = target.parentElement || target.parentNode;
            }
        });

        // Disable right-click on modal
        document.addEventListener('contextmenu', (e) => {

            const target = (e.target.nodeType === 1) ? e.target : e.target.parentElement;
            if (target && (target.closest('#pdfModal') || target.closest('#pdfViewer'))) {

                e.preventDefault();
                return false;
            }
        });

        // Disable keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // Check if modal is open
            const modal = document.getElementById('pdfModal');
            if (modal && modal.classList.contains('show')) {
                // Ctrl+S (Save)
                if (e.ctrlKey && e.keyCode === 83) {
                    e.preventDefault();
                    return false;
                }
                // Ctrl+P (Print)
                if (e.ctrlKey && e.keyCode === 80) {
                    e.preventDefault();
                    return false;
                }
                // F12 (Developer Tools)
                if (e.keyCode === 123) {
                    e.preventDefault();
                    return false;
                }
                // Ctrl+Shift+I (Developer Tools)
                if (e.ctrlKey && e.shiftKey && e.keyCode === 73) {
                    e.preventDefault();
                    return false;
                }
                // Ctrl+Shift+J (Console)
                if (e.ctrlKey && e.shiftKey && e.keyCode === 74) {
                    e.preventDefault();
                    return false;
                }
            }
        });

        // Disable text selection in PDF viewer
        document.addEventListener('selectstart', (e) => {
            let el = e.target.nodeType === 1 ? e.target : e.target.parentElement;
            if (el && el.closest('#pdfViewer')) {
                e.preventDefault();
                return false;
            }
        });

        // Disable drag and drop
        document.addEventListener('dragstart', (e) => {
            let el = e.target.nodeType === 1 ? e.target : e.target.parentElement;
            if (el && el.closest('#pdfViewer')) {
                e.preventDefault();
                return false;
            }
        });
    }

    async openPDF(url, title) {
        // Ensure modal is initialized
        if (!this.initialized) {
            this.initializeModal();
        }

        // Set title
        if (this.pdfTitle) {
            this.pdfTitle.textContent = title;
        }
        
        // Show loading indicator
        if (this.pdfViewer) {
            this.pdfViewer.innerHTML = `
                <div class="pdf-loading text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading PDF...</p>
                </div>
            `;
        }
        
        // Show modal
        if (this.modal) {
            this.modal.show();
        }
        
        try {
            // Load PDF.js if not already loaded
            if (typeof pdfjsLib === 'undefined') {
                await this.loadPDFJS();
            }
            
            // Set worker source
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
            
            // Load PDF document
            const loadingTask = pdfjsLib.getDocument(url);
            const pdf = await loadingTask.promise;
            
            // Clear loading indicator
            if (this.pdfViewer) {
                this.pdfViewer.innerHTML = '';
            }
            
            // Render all pages
            const renderScale = 3; // Adjust scale for better quality
            
            for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
                const page = await pdf.getPage(pageNumber);
                
                // Create viewport
                const viewport = page.getViewport({ scale: renderScale });
                
                // Create canvas
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                
                // Create container for canvas
                const container = document.createElement('div');
                container.className = 'pdf-page-container';
                container.style.marginBottom = '20px';
                container.style.textAlign = 'center';
                
                // Render PDF page
                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                
                await page.render(renderContext).promise;
                
                // Add canvas to container
                container.appendChild(canvas);
                
                // Add watermark
                this.addWatermark(container);
                
                // Add page number
                const pageNum = document.createElement('div');
                pageNum.className = 'pdf-page-number';
                pageNum.textContent = `Page ${pageNumber} of ${pdf.numPages}`;
                pageNum.style.marginTop = '10px';
                pageNum.style.fontSize = '12px';
                pageNum.style.color = '#666';
                container.appendChild(pageNum);
                
                // Add container to viewer
                if (this.pdfViewer) {
                    this.pdfViewer.appendChild(container);
                }
            }
            
            // Scroll to top
            if (this.pdfViewer) {
                this.pdfViewer.scrollTop = 0;
            }
            
        } catch (error) {
            console.error('Error loading PDF:', error);
            if (this.pdfViewer) {
                this.pdfViewer.innerHTML = `
                    <div class="alert alert-danger m-3">
                        Failed to load PDF. Please try again later.
                    </div>
                `;
            }
        }
    }

    addWatermark(container) {
        const watermark = document.createElement('div');
        watermark.style.position = 'absolute';
        watermark.style.top = '50%';
        watermark.style.left = '50%';
        watermark.style.transform = 'translate(-50%, -50%) rotate(-45deg)';
        watermark.style.fontSize = '48px';
        watermark.style.color = 'rgba(200, 200, 200, 0.3)';
        watermark.style.fontWeight = 'bold';
        watermark.style.pointerEvents = 'none';
        watermark.style.userSelect = 'none';
        watermark.style.zIndex = '1000';
        watermark.textContent = 'CONFIDENTIAL';
        container.style.position = 'relative';
        container.appendChild(watermark);
    }

    async loadPDFJS() {
        return new Promise((resolve, reject) => {
            if (typeof pdfjsLib !== 'undefined') {
                resolve();
                return;
            }
            
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js';
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }
}

// Initialize PDF Viewer when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.pdfViewer = new PDFViewer();
});