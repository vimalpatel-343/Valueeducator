<?= $this->include('front/header') ?>

<div class="sc-team-section-area pt-5 sc-pb-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">

                <div class="development-box p-5">
                    <div class="mb-4">
                        <i class="fa fa-cogs fa-4x text-primary"></i>
                    </div>

                    <h1 class="font-lg-28-bold mb-3">
                        Page Under Development
                    </h1>

                    <p class="font-lg-16-normal mb-4">
                        We are currently working on this section to bring you
                        high-quality content. Please check back soon.
                    </p>

                    <span class="font-lg-14-normal text-muted">
                        🚧 This page is in progress
                    </span>

                </div>

            </div>
        </div>
    </div>
</div>
<style>
.development-box {
    border: 2px dashed #e0e0e0;
    border-radius: 12px;
    background: #fafafa;
}

.development-box i {
    opacity: 0.8;
}
</style>
<?= $this->include('front/footer') ?>