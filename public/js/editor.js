function loadEditor(selector = '.editor', height = 400) {
    $(selector).summernote({
        height: height,
        toolbar: [
            // FULL TOOLBAR
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear', 'fontsize', 'fontname', 'strikethrough', 'superscript', 'subscript']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph', 'height']],
            ['insert', ['picture', 'video', 'link', 'table', 'hr']],
            ['view', ['fullscreen', 'codeview', 'undo', 'redo']]
        ],
        placeholder: "Write content here..."
    });
}