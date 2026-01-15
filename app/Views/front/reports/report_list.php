<?php if (!empty($reports)): ?>
    <?php foreach ($reports as $report): ?>
        <div class="item pf-item">
            <div class="sc-pb-20">
                <div class="sc-icon-box" style="padding-bottom:10px; z-index: 0;">
                    <div class="image">
                        <?php if ($isLoggedIn): ?>
                            <a href="javascript:void(0)" class="favorite-btn" data-id="<?= $report['id'] ?>">
                                <i class="fa <?= isset($userFavorites[$report['id']]) && $userFavorites[$report['id']] ? 'fa-heart' : 'fa-heart-o' ?> cc" style="color: <?= isset($userFavorites[$report['id']]) && $userFavorites[$report['id']] ? 'red' : 'black' ?>;"></i>
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('login') ?>" class="favorite-btn">
                                <i class="fa fa-heart-o cc" style="color: black;"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="sc-auother-header text-center">
                        <div class="min-hgt">
                            <a href="<?= base_url('knowledge-center/reports/detail/' . $report['id']) ?>">
                                <?php if (!empty($report['logo'])): ?>
                                    <img src="<?= base_url($report['logo']) ?>" alt="<?= $report['company_name'] ?>">
                                <?php else: ?>
                                    <img src="<?= base_url('images/default-company.svg') ?>" alt="<?= $report['company_name'] ?>">
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="detail">
                            <a href="<?= base_url('knowledge-center/reports/detail/' . $report['id']) ?>">
                                <h5><?= $report['company_name'] ?></h5>
                            </a>
                            <p>
                                <span><?= $report['sector_name'] ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="font-16-normal" style="clear:both; display:block; height:50px; position:absolute; bottom:-50px; padding:5px 0px; color:#D4D4D4;">
                Last updated: <?= date('M d, Y', strtotime($report['modified_datetime'] ?? $report['created_datetime'])) ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="no-data-found text-center py-5">
        <img src="<?= base_url('images/no-data.png') ?>" alt="No Reports">        
    </div>
<?php endif; ?>