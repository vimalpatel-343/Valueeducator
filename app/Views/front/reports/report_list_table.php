<div class="table-responsive">
    <table class="table">
        <thead class="">
            <tr class="">
                <th class="">Logo</th>
                <th class="">Stock Name</th>
                <th class="">Last Updated</th>
                <th class="">Sector</th>
                <th class="">Favourite</th>
            </tr>
        </thead>
        <tbody class="">
            <?php if (!empty($reports)): ?>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td>
                            <?php if (!empty($report['logo'])): ?>
                                <img src="<?= base_url($report['logo']) ?>" width="60" alt="<?= $report['company_name'] ?>">
                            <?php else: ?>
                                <img src="<?= base_url('images/default-company.svg') ?>" width="60" alt="<?= $report['company_name'] ?>">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('knowledge-center/reports/detail/' . $report['id']) ?>"><?= $report['company_name'] ?></a>
                        </td>
                        <td><?= date('M d, Y', strtotime($report['modified_datetime'] ?? $report['created_datetime'])) ?></td>
                        <td>
                            <?= $report['sector_name'] ?>
                        </td>
                        <td>
                            <?php if ($isLoggedIn): ?>
                                <a href="javascript:void(0)" class="favorite-btn" data-id="<?= $report['id'] ?>">
                                    <i class="fa <?= isset($userFavorites[$report['id']]) && $userFavorites[$report['id']] ? 'fa-heart' : 'fa-heart-o' ?> cc" style="color: <?= isset($userFavorites[$report['id']]) && $userFavorites[$report['id']] ? 'red' : 'black' ?>;"></i>
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url('login') ?>" class="favorite-btn">
                                    <i class="fa fa-heart-o cc" style="color: black;"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">
                        <div class="no-data-found py-3">
                            <h4>No reports found</h4>
                            <p>Try adjusting your filters or search terms.</p>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>