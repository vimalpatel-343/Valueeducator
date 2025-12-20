<?= $this->include('front/header') ?>

<div class="sc-testimonial-section-three pt-5 sc-pb-60 sc-md-pb-60 sc-md-mt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sc-heading-area sc-mb-15 text-left">
                    <div class="d-flex justify-content-between align-items-center sc-mb-10 sc-md-mb-10">
                        <h3 class="font-lg-24-bold">Substack</h3>
                    </div>
                    <div class="search mb-4">
                        <input type="text" class="searchTerm" id="keyword" placeholder="Search Substack">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="" id="blog-container">
            <div class="row">
                <?php if (empty($substackUpdates)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        <p class="mb-0">No Substack updates available at the moment. Please check back later.</p>
                    </div>
                </div>
                <?php else: ?>
                    <?php foreach ($substackUpdates as $item): ?>
                    <div class="col-lg-4 col-md-4">
                        <div class="substack-wrapper">
                            <div class="substack">
                                <a href="<?= $item['fld_url'] ?>" target="_blank">
                                    <?php if (!empty($item['fld_image'])): ?>
                                        <img src="<?= base_url($item['fld_image']) ?>" alt="<?= $item['fld_title'] ?>">
                                    <?php else: ?>
                                        <img src="<?= base_url('images/default-substack.jpg') ?>" alt="<?= $item['fld_title'] ?>">
                                    <?php endif; ?>
                                </a>
                                <div class="substack-content">
                                    <h3 class="font-lg-24-bold sc-mt-10"><?= $item['fld_title'] ?></h3>
                                    <p class="font-lg-16-normal"><?= $item['fld_description'] ?></p>
                                </div>
                                <div class="substack-footer">
                                    <span class="arrow">
                                        <a href="<?= $item['fld_url'] ?>" target="_blank">
                                            <img src="<?= base_url('images/blog.png') ?>" alt="Read More">
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <div class="post-date">Posted <?= $item['time_elapsed'] ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Simple search functionality for substack updates
document.getElementById('keyword').addEventListener('keyup', function() {
    var searchTerm = this.value.toLowerCase();
    var substackItems = document.querySelectorAll('.substack-wrapper');
    
    substackItems.forEach(function(item) {
        var title = item.querySelector('h3').textContent.toLowerCase();
        var description = item.querySelector('p').textContent.toLowerCase();
        
        if (title.includes(searchTerm) || description.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>

<?= $this->include('front/footer') ?>