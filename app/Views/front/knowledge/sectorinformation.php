<?= $this->include('front/header') ?>

<div class="sc-team-section-area sc-pb-40">
    <div class="container">

        <!-- Heading -->
        <div class="sc-pt-40 sc-pb-20">
            <h2 class="sector-title">Sector Information</h2>
        </div>

        <!-- Sector Cards -->
        <div class="row">
            <?php foreach ($sectors as $sector): ?>
                <div class="col-lg-3 col-md-4 col-6 sc-pb-20">
                    <?php if ($hasAccess): ?>
                        <a href="<?= base_url('knowledge-center/sector/' . urlencode($sector['name'])) ?>" class="sector-link">
                    <?php else: ?>
                        <a href="#" class="sector-link disabled">
                    <?php endif; ?>

                        <div class="sector-card">

                            <?php if (!$hasAccess): ?>
                                <span class="paid-badge">
                                    <img src="<?= base_url('images/lock.svg') ?>"> Paid Service
                                </span>
                            <?php endif; ?>

                            <?php if (!empty($sector['image'])): ?>
                                <img src="<?= base_url($sector['image']) ?>" class="sector-icon" alt="<?= esc($sector['name']) ?>">
                            <?php endif; ?>
                            <h5><?= esc($sector['name']) ?></h5>
                        </div>

                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<style>
/* Title */
.sector-title {
    font-size: 32px;
    font-weight: 700;
}

/* Search */
.sector-search {
    width: 100%;
    padding: 14px 20px;
    border-radius: 12px;
    border: none;
    background: #f5f5f5;
    font-size: 16px;
    outline: none;
}

/* Card */
.sector-card {
    position: relative;
    background: #f8f8f8;
    border-radius: 16px;
    padding: 30px 20px;
    text-align: center;
    height: 100%;
    transition: all 0.3s ease;
}

.sector-card:hover {
    background: #ffffff;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transform: translateY(-4px);
}

/* Icon */
.sector-icon {
    height: 60px;
    margin-bottom: 20px;
}

/* Title */
.sector-card h5 {
    font-size: 18px;
    font-weight: 600;
    margin: 0;
}

/* Paid Badge */
.paid-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: #fff;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* Disable link */
.sector-link.disabled {
    pointer-events: none;
    opacity: 0.85;
}

</style>

<?= $this->include('front/footer') ?>