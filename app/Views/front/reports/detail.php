<?= $this->include('front/header') ?>

<div class="sc-breadcrumb-area mt-3 mb-2">
    <div class="container">
        <div class="row align-items-center">
            <!-- Title -->
            <div class="col-lg-6 col-md-6 col-12">
                <h1 class="breadcrumb-title">Reports : <?= $report['company_name'] ?></h1>
            </div>

            <!-- Breadcrumb -->
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-list">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li><a href="<?= base_url('knowledge-center/reports') ?>">Reports</a></li>
                    <li><?= $report['company_name'] ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="sc-report-detail-area sc-pt-40 sc-pb-40 sc-md-pt-30 sc-md-pb-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sc-report-detail">
                    
                    <div class="report-content">
                        <div class="report-description">
                            <?= $report['description'] ?>
                        </div>
                    </div>
                    
                </div>
            </div>
            
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
</style>
<?= $this->include('front/footer') ?>