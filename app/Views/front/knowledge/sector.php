<?= $this->include('front/header') ?>

<div class="sc-breadcrumb-area mt-5">
    <div class="container">
        <div class="row align-items-center">
            <!-- Title -->
            <div class="col-lg-6 col-md-6 col-12">
                <h1 class="breadcrumb-title"><?= esc($sector['name']) ?></h1>
            </div>

            <!-- Breadcrumb -->
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-list">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li><a href="<?= base_url('knowledge-center/sector-information') ?>">Sector Information</a></li>
                    <li><?= esc($sector['name']) ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="sc-team-section-area sc-pt-40 sc-pb-40 sc-md-pt-30 sc-md-pb-30">
    <div class="container">
        
        <div class="row">
            <?php if (!empty($topics)): ?>
                <?php foreach ($topics as $topic): ?>
                    <div class="col-lg-6 col-md-6 col-12 sc-mb-20">
                        <?php if ($hasAccess): ?>
                            <a href="<?= base_url('knowledge-center/sector/' . urlencode($sector['name']) . '/' . urlencode($topic['name'])) ?>" class="topic-link">
                        <?php else: ?>
                            <a href="#" class="topic-link disabled">
                        <?php endif; ?>

                            <div class="topic-card">

                                <?php if (!empty($topic['icon'])): ?>
                                    <div class="topic-icon">
                                        <img src="<?= base_url($topic['icon']) ?>" alt="<?= esc($topic['name']) ?>">
                                    </div>
                                <?php endif; ?>

                                <div class="topic-content">
                                    <h4><?= esc($topic['name']) ?></h4>
                                </div>

                                <?php if (!$hasAccess): ?>
                                    <span class="paid-tag">
                                        <i class="bx bx-lock"></i> Premium
                                    </span>
                                <?php endif; ?>

                            </div>

                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-lg-12">
                    <div class="no-data-found text-center">
                        <img src="<?= base_url('images/no-data.png') ?>" alt="No Topics">
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
<style>

/* Breadcrumb Layout */
.sc-breadcrumb-area {
    padding: 20px 0;
}

.breadcrumb-title {
    font-size: 28px;
    font-weight: 700;
    margin: 0;
}

/* Breadcrumb list */
.breadcrumb-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.breadcrumb-list li {
    font-size: 14px;
    color: #555;
}

.breadcrumb-list li a {
    color: #555;
    text-decoration: none;
}

.breadcrumb-list li::after {
    content: "/";
    margin-left: 10px;
}

.breadcrumb-list li:last-child::after {
    content: "";
}

/* Mobile fix */
@media (max-width: 767px) {
    .breadcrumb-list {
        justify-content: flex-start;
        margin-top: 10px;
    }
}

/* Topic Card */
.topic-card {
    position: relative;
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 20px;
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    transition: 0.3s ease;
    height: 100%;
}

.topic-card:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    transform: translateY(-2px);
}

/* Icon */
.topic-icon img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

/* Title */
.topic-content h4 {
    font-size: 16px;
    font-weight: 600;
    margin: 0;
    color: #000;
}

/* Link */
.topic-link {
    text-decoration: none;
    color: inherit;
}

/* Disabled */
.topic-link.disabled {
    pointer-events: none;
    opacity: 0.7;
}

/* Paid Tag */
.paid-tag {
    position: absolute;
    right: 15px;
    top: 15px;
    font-size: 12px;
    background: #f3f3f3;
    padding: 4px 10px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 4px;
}
</style>
<?= $this->include('front/footer') ?>