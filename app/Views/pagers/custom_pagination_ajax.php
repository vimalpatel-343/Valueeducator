<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" data-page="<?= $pager->getFirst() ?>" aria-label="First">
                    <span aria-hidden="true">&laquo;&laquo;</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" data-page="<?= $pager->getPrevious() ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="javascript:void(0)" data-page="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" data-page="<?= $pager->getNext() ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" data-page="<?= $pager->getLast() ?>" aria-label="Last">
                    <span aria-hidden="true">&raquo;&raquo;</span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>

<script>
 $(document).ready(function() {
    // Handle pagination clicks
    $('.pagination .page-link').on('click', function(e) {
        e.preventDefault();
        
        const page = $(this).data('page');
        if (page) {
            // Update URL with page parameter
            const url = new URL(window.location);
            url.searchParams.set('page', page);
            
            // Fetch reports for the new page
            fetchReports();
        }
    });
});
</script>