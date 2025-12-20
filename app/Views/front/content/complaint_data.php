<?= $this->include('front/header') ?>

<div class="sc-team-section-area sc-pb-0 sc-md-pb-0 sc-mt-0 sc-md-mt-0">
    <div class="container">
        <div class="row sc-pt-40 sc-md-pt-20">
            <div class="col-lg-12 col-md-12 sc-pb-20 sc-md-pb-0">
                <div class="sc-heading-area sc-mb-35 sc-md-mb-5 sc-md-pt-0 text-justify">
                    <h1 class="sc-mb-30 sc-mt-0 font-lg-32-bold font-24-bold"><?= $page['fld_title'] ?></h1>
                    <div class="page-content">
                        <?= $page['fld_content'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('front/footer') ?>