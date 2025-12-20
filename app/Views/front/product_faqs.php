<?= $this->include('front/header') ?>

<div class="sc-team-section-area sc-pb-0 sc-md-pb-0 sc-mt-0 sc-md-mt-0">
    <div class="container">
        <div class="row sc-pt-40 sc-md-pt-20">
            <div class="col-lg-12 col-md-12 sc-pb-20 sc-md-pb-0">
                <div class="sc-heading-area sc-mb-35 sc-md-mb-5 sc-md-pt-0 text-justify">
                    <h1 class="sc-mb-10 sc-mt-0 font-lg-32-bold font-24-bold">FAQs (Frequently Asked Questions)</h1>
                    
                    <div class="faq-section">
                        <?php if (!empty($generalFAQs)): ?>
                            <?php $counter = 1; ?>
                            <?php foreach ($generalFAQs as $faq): ?>
                                <div class="faq-item sc-mb-0 sc-mt-10 sc-pb-20 sc-pt-20 font-lg-20-normal font-14-normal bdr-top">
                                    <div class="faq-question sc-mb-10">
                                        <strong><?= $counter ?>. <?= htmlspecialchars($faq['fld_question']) ?></strong>
                                    </div>
                                    <div class="faq-answer">
                                        <?= $faq['fld_answer'] ?>
                                    </div>
                                </div>
                                <?php $counter++; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <?php if (empty($generalFAQs) && empty($productFAQs)): ?>
                            <div class="alert alert-info">
                                No FAQs available at the moment.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('front/footer') ?>