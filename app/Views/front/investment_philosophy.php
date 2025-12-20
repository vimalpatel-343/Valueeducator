<?= $this->include('front/header') ?>

<div class="sc-team-section-area sc-pb-0 sc-md-pb-0 sc-mt-0 sc-md-mt-0">
    <div class="container">
        <div class="row">
            <div class="text-sprint">SPRINT</div>
        </div>

        <div class="row d-flex justify-content-between align-items-center sc-pt-100 sc-md-pt-50"
            style="z-index:1; position:relative;">
            <div class="col-lg-6 col-12 col-12 sc-pb-20"><img
                    src="images/empowering.svg"></div>

            <div class="col-lg-6 col-12 col-12 sc-pb-20 sc-md-pb-0">
                <div class="sc-heading-area sc-mb-35 sc-md-mb-5 sc-md-pt-0 text-justify">
                    <h3 class="sc-mb-10 sc-mt-0 font-lg-32-bold font-20-bold">SPRINT Investment Philosophy: Sustainable
                        Growth &amp; Value Creation</h3>

                    <p class="sc-mb-0 sc-mt-0 font-lg-20-normal font-14-normal">At SPRINT, our investment philosophy is
                        built on six core principles that shape every decision we make. Our disciplined approach focuses
                        on identifying and cultivating high-potential companies with the ability to sustain long-term
                        growth and deliver consistent value. By leveraging our strategy, we uncover the most promising
                        opportunities from over 5,000 listed companies, selecting those with the strongest potential for
                        success.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($philosophies)): ?>
    <?php foreach ($philosophies as $index => $philosophy): ?>
        <div class="sc-service-section-three sc-pt-50 sc-md-pt-0 sc-pb-10 sc-md-pb-10">
            <div class="container">
                <div class="row d-flex align-items-stretch">
                    <div class="sc-heading-area sc-mb-15 text-start d-block d-lg-none">
                        <h5 class="font-20-bold">Our Six Core Principles for Long-Term Growth and Value Creation</h5>
                    </div>

                    <div class="col-lg-4 col-12">
                        <div class="sc-team-item min-hgt-auto less-pad d-flex flex-column" style="border:1px solid #ccc;">
                            <div class="sc-pt-0 sc-pb-40 sc-md-pb-0">
                                <div class="text-start text-lg-center">
                                    <?php if (!empty($philosophy['fld_image'])): ?>
                                        <img alt="<?= $philosophy['fld_title'] ?>" src="<?= base_url($philosophy['fld_image']) ?>">
                                    <?php else: ?>
                                        <img alt="" src="images/no_image.png">
                                    <?php endif; ?>
                                </div>

                                <div class="sc-team-content">
                                    <?php
                                    // Extract the first letter of the title for the big letter
                                    $firstLetter = substr($philosophy['fld_title'], 0, 1);
                                    ?>
                                    <h1 class="letter d-flex flex-column-reverse d-md-flex align-items-start"><?= $firstLetter ?></h1>

                                    <h4 class="sc-md-ml-20 sc-md-mt-15 font-lg-24-bold font-20-bold"><?= $philosophy['fld_title'] ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-12 sc-mt-0 sc-md-mt-30">
                        <div class="h-100 d-flex flex-column justify-content-top">
                            <div class="col-lg-12 col-12 sc-pb-20">
                                <h5 class="font-lg-20-normal font-14-normal" style="font-weight:400;"><?= $philosophy['fld_description'] ?></h5>
                            </div>

                            <?php if (!empty($philosophy['services'])): ?>
                                <div class="row">
                                    <?php foreach ($philosophy['services'] as $service): ?>
                                        <div class="col-lg-4 col-12 sal-animate" data-sal="slide-up" data-sal-delay="300" data-sal-duration="800">
                                            <div class="sc-services-style3 no-pad">
                                                <div class="sc-service-text no-pad-top">
                                                    <div class="sc-services-icon no-margin text-start">
                                                        <?php if (!empty($service['icon_name'])): ?>
                                                            <i class="material-icons"><?= $service['icon_name'] ?></i>
                                                        <?php else: ?>
                                                            <i class="material-icons">star</i>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="service-text-right sc-mt-0 sc-md-mt-0" style="margin-bottom:0px; padding-bottom:0px;">
                                                        <h5 class="font-lg-16-bold font-16-bold"><?= $service['service_title'] ?></h5>
                                                        <p class="des sc-pt-5 font-lg-14-normal font-14-normal sc-md-mb-10" style="color:#8D8D8D;"><?= $service['service_description'] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if (!empty($philosophy['images'])): ?>
                    <div class="row">
                        <?php foreach ($philosophy['images'] as $image): ?>
                            <div class="col-lg-4 col-md-12 col-4 sc-mt-20 sc-md-mt-0">
                                <div class="logo-box text-center">
                                    <img class="crop" src="<?= base_url($image['image_path']) ?>" alt="Company Logo">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<p class="m5">&nbsp;</p>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<?= $this->include('front/footer') ?>