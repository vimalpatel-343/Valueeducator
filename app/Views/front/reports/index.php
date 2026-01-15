<?= $this->include('front/header') ?>

<div class="sc-breadcrumb-area mt-3 mb-2">
    <div class="container">
        <div class="row align-items-center">
            <!-- Title -->
            <div class="col-lg-6 col-md-6 col-12">
                <h1 class="breadcrumb-title">Reports</h1>
            </div>

            <!-- Breadcrumb -->
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-list">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li>Reports</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="sc-reports-area sc-pt-40 sc-pb-40 sc-md-pt-30 sc-md-pb-30">

    
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sc-reports-header">
                    <div class="d-flex justify-content-between align-items-center sc-mb-30">
                        <div class="left-section d-none d-lg-block">
                            <div class="search">
                                <input type="text" id="searchReports" class="searchTerm" placeholder="Search Report">
                            </div>
                        </div>
                        
                        <div class="right-section report">
                            <div class="buttons">
                                <div id="grid-view-btn" class="active square-btn"><i class="fa fa-th-large"></i></div>
                                <div id="list-view-btn" class="square-btn"><i class="fa fa-bars"></i></div>
                            </div>
                            
                            <div class="search d-block d-lg-none sc-md-mb-20">
                                <input type="text" id="searchReportsMobile" class="searchTerm" placeholder="Search Report">
                            </div>
                            
                            <div class="portfolio-area d-block">
                                <div class="mix-item-menu">	
                                    <button id="showButton" class="filter-btn active black" data-filter="all">All</button>
                                    <button id="favouritesButton" class="filter-btn black" data-filter="favourites">
                                        <img src="<?= base_url('images/icon-favorite.png') ?>"> Favourites
                                    </button>
                                    <button id="recommendedButton" class="filter-btn black" data-filter="recommended">Recommended</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="">
                        <div class="sc-faq-style sc-pt-0 sc-md-pt-0 sc-pb-20 sc-md-pb-20">
                            <div id="faqAccordion" class="accordion">
                                <div class="accordion-item" style="margin-bottom:20px;">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed font-lg-20-bold font-16-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Market Cap</button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <input type="radio" id="market_cap_all" class="radio-input" name="market_cap" value="all" checked>
                                            <label for="market_cap_all" class="radio-label">
                                                <span class="radio-border"></span>
                                                <span class="label-name">All Caps</span>
                                            </label>
                                            
                                            <?php foreach ($marketCapOptions as $value => $label): ?>
                                                <?php if ($value !== 'all'): ?>
                                                    <input type="radio" id="market_cap_<?= $value ?>" class="radio-input" name="market_cap" value="<?= $value ?>">
                                                    <label for="market_cap_<?= $value ?>" class="radio-label">
                                                        <span class="radio-border"></span>
                                                        <span class="label-name"><?= $label ?></span>
                                                    </label>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed font-lg-20-bold font-16-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Sector</button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                                        <div class="accordion-body">
                                            <div class="sector-item-menu">
                                                <button class="multi-btn" data-id="all" data-name="All">All</button>
                                                
                                                <?php foreach ($sectors as $sector): ?>
                                                    <button class="multi-btn" data-id="<?= $sector['id'] ?>" data-name="<?= htmlspecialchars($sector['name']) ?>">
                                                        <img src="<?= base_url($sector['icon']) ?>" alt="">
                                                        <?= htmlspecialchars($sector['name']) ?>
                                                    </button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="content grid-view min-vh-100">
                        <div id="portfolio-grid" class="grid-view">
                            <?= view('front/reports/report_list', [
                                'reports' => $reports,
                                'isLoggedIn' => $isLoggedIn,
                                'userFavorites' => $userFavorites
                            ]) ?>
                        </div>
                    </div>
                    
                    <div class="content list-view min-vh-100" style="display:none;">
                        <div id="portfolio-grid-list" class="list-view">
                            <?= view('front/reports/report_list_table', [
                                'reports' => $reports,
                                'isLoggedIn' => $isLoggedIn,
                                'userFavorites' => $userFavorites
                            ]) ?>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="pagination-wrapper">
                <?= $pager->links('default', 'custom_pagination') ?>
            </div>
        </div>
    </div>
    
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<?= $this->include('front/footer') ?>

<script>
 $(document).ready(function() {
    // Initialize variables
    let selectedMarketCap = "<?= $filters['market_cap'] ?>";
    let selectedSectors = <?= !empty($filters['sector_id']) ? json_encode($filters['sector_id']) : '[]' ?>;
    let keyword = "<?= $filters['keyword'] ?>";
    let recommended = <?= $filters['recommended'] ?>;
    let favourites = <?= $filters['favorites'] ?>;
    
    // Initialize: Show grid view and hide list view
    setTimeout(function(){
        $('.content.grid-view').show();
        $('.content.list-view').hide();
    },1000);    
    
    // Handle Grid View Button click
    $('#grid-view-btn').on('click', function() {
        $('.content.list-view').hide();
        $('.content.grid-view').show();
        $(this).addClass('active');
        $('#list-view-btn').removeClass('active');
    });
    
    // Handle List View Button click
    $('#list-view-btn').on('click', function() {
        $('.content.grid-view').hide();
        $('.content.list-view').show();
        $(this).addClass('active');
        $('#grid-view-btn').removeClass('active');
    });
    
    // Handle Market Cap selection
    $('.radio-input').on('change', function() {
        if ($(this).attr('name') === 'market_cap') {
            selectedMarketCap = $(this).val();
            fetchReports();
        }
    });
    
    // Handle Sector selection
    $('.multi-btn').on('click', function() {
        const sectorId = $(this).data('id');
        
        if (sectorId === 'all') {
            $('.multi-btn').removeClass('active');
            $(this).addClass('active');
            selectedSectors = [];
        } else {
            $('.multi-btn[data-id="all"]').removeClass('active');
            $(this).toggleClass('active');
            
            // Update selected sectors array
            selectedSectors = [];
            $('.multi-btn.active[data-id!="all"]').each(function() {
                selectedSectors.push($(this).data('id'));
            });
        }
        
        fetchReports();
    });
    
    // Handle Filter buttons
    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        const filterType = $(this).data('filter');
        console.log(filterType);
        if (filterType === 'recommended') {
            recommended = 1;
            favourites = 0;
        } else if (filterType === 'favourites') {
            recommended = 0;
            favourites = 1;
        } else {
            recommended = 0;
            favourites = 0;
        }
        
        fetchReports();
    });
    
    // Handle Search
    $('#searchReports, #searchReportsMobile').on('keyup', function() {
        keyword = $(this).val();
        fetchReports();
    });
    
    // Function to fetch reports via AJAX
    function fetchReports() {
        showLoading();
        
        const params = new URLSearchParams({
            market_cap: selectedMarketCap,
            sector_id: selectedSectors,
            recommended: recommended,
            favourites: favourites,
            keyword: keyword
        });
        
        $.ajax({
            url: '<?= base_url('knowledge-center/reports') ?>?' + params.toString(),
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                hideLoading();
                
                if ($('.content.grid-view').is(':visible')) {
                    $('#portfolio-grid').html(response.html);
                } else {
                    $('#portfolio-grid-list').html(response.html);
                }
                
                $('.pagination-wrapper').html(response.pagination);
            },
            error: function() {
                hideLoading();
                showNoData();
            }
        });
    }
    
    // Toggle favorite
    $(document).on('click', '.favorite-btn', function(e) {
        e.preventDefault();
        
        const reportId = $(this).data('id');
        const icon = $(this).find('i');
        
        $.ajax({
            url: '<?= base_url('knowledge-center/reports/toggle-favorite') ?>',
            type: 'POST',
            data: {
                report_id: reportId,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'added') {
                    icon.removeClass('fa-heart-o').addClass('fa-heart').css('color', 'red');
                } else if (response.status === 'removed') {
                    icon.removeClass('fa-heart').addClass('fa-heart-o').css('color', 'black');
                }
                
                // Show toast notification
                showToast(response.message, response.status === 'added' ? 'success' : 'info');
            },
            error: function() {
                showToast('Error occurred. Please try again.', 'error');
            }
        });
    });
    
    // Show loading overlay
    function showLoading() {
        $('#loadingOverlay').show();
    }
    
    // Hide loading overlay
    function hideLoading() {
        $('#loadingOverlay').hide();
    }
    
    // Show no data message
    function showNoData() {
        const noDataHtml = `
            <div class="no-data-found text-center py-5">
                <img src="<?= base_url('images/no-data.png') ?>" alt="No Reports">
                <h4>No reports found</h4>
                <p>Try adjusting your filters or search terms.</p>
            </div>
        `;
        
        if ($('.content.grid-view').is(':visible')) {
            $('#portfolio-grid').html(noDataHtml);
        } else {
            $('#portfolio-grid-list').html(noDataHtml);
        }
    }
    
    // Show toast notification
    function showToast(message, type = 'info') {
        const toast = $(`
            <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'primary'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `);
        
        $('.toast-container').append(toast);
        
        const bsToast = new bootstrap.Toast(toast[0]);
        bsToast.show();
        
        toast.on('hidden.bs.toast', function() {
            $(this).remove();
        });
    }
});

</script>

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

.left-section {
  /*display: flex;
  align-items: center;  
  justify-content: flex-end; 
  border:1px solid red;
  flex-direction: column; */
  float:left;
  /*border:1px solid black;  */
  display:inline-block;
  text-align:right;
  width:40%;
}


.search {
 display: flex;
  align-items: center;
  flex: 0 0 30%!important;   
   flex: 1!important;  
}

.searchTerm {
  width: 100%;
  border-radius: 8px;
  padding: 15px;
  height: 43px;
  outline: none;
  color: #8d8d8d;
  background: #f7f7f7;
}

.searchTerm:focus{
  color: #121212;
}

.searchButton {
  width: 40px;
  height: 36px;
  border: 1px solid #00B4CC;
  background: #00B4CC;
  text-align: center;
  color: #fff;
  border-radius: 0 5px 5px 0;
  cursor: pointer;
  font-size: 20px;
}

.float-left {
  float: left;
  padding-right: 20px;
}
/* Right section holding both favourite and buttons */
.right-section {
  /*display: flex;
  align-items: center;  
  justify-content: flex-end; 
  border:1px solid red;
  flex-direction: column; */
  float:right;
  border:0px solid red;
  display:inline-block;
  text-align:right;
  width:50%;
}
.right-section.report {
  /*display: flex;
  align-items: center;  
  justify-content: flex-end; 
  border:1px solid red;
  flex-direction: column; */
  float:right;
  border:0px solid red;
  display:inline-block;
  text-align:right;
  width:50%;
}
.favourite { 
  margin-right: 10px; /* Add some space between the items */
  float:right;
  height:43px;
  display:inline-block;
}
.favourite a {
  text-decoration: none;
  padding:7px 20px;
}
.favourite img {
  margin-right: 5px;
}
.right-section .buttons {
border:1px solid #222;
border-radius:50px;
float:right;
/*height:43px;*/
display:flex;
padding:0px 0px 0px;
align-items:center;
}

.square-btn {
  width: 38px!important;
  height: 38px!important;
  margin: 0 0px;
  border: 0px solid #d6d6d6;
  background: #fff;
  border-radius: 50px;
  color: #121212!important;
  text-align:center;
  padding:8px 0px;
  cursor:pointer;
}

.square-btn:hover {
  background: #121212;
  color: #ffffff!important;
}

.square-btn:active {
width: 38px!important;
  height: 38px!important;
  background: #777;
  color: #ffffff!important;
}
/* Active state for the clicked button */
.square-btn.active {
width: 38px!important;
  height: 38px!important;
  background: #121212; /* Green color when active */
  color: #ffffff!important;
}
.square-btn:hover img {
filter:invert(1);
}

@media (max-width:991px) {
.left-section {
  float:none;
  /*border:1px solid black;  */
  display:block;
  text-align:left;
  width:100%;
  margin-bottom:0px;
  margin-top:20px;
  border:0px solid red;
}
.right-section {
  float:right;
  border:0px solid red;
  display:inline-block;
  text-align:right;
  width:100%;
  margin-bottom:0px;
}
.right-section.report {  
  float:none;
  border:0px solid red;
  display:block;
  text-align:left;
  width:100%;
}
.right-section.report h3 {
width:40%;
float:left;
border:0px solid red;
}
.right-section.report .buttons {
border:1px solid #222;
border-radius:50px;
float:right;
/*height:43px;*/
display:flex;
padding:0px 0px 0px;
align-items:center;
}
.right-section .favourite {
float:left;
}
}
.portfolio-area .mix-item-menu button {
  background: transparent none repeat scroll 0 0;
  border: medium none;
  box-shadow: inherit;
  font-weight: 500;
  margin: 0px 5px;
  position: relative;
  z-index: 1;
  color: #121212;
border-radius:43px!important;
padding:10px 30px;
background:#f7f7f7;
font-size:16px;
white-space: nowrap; /* prevent text wrapping */
      width: auto; /* keep width relative to text */
}

.portfolio-area .mix-item-menu {
  margin-bottom: 0px;
  margin-top: 0px;
  display: flex;
      gap: 10px;
      flex-wrap: nowrap;
      justify-content: center;
      margin: 0px 0px;
}
.portfolio-area .mix-item-menu button.active {
  color: #fff;
  background:#9155F1;
}
.portfolio-area .mix-item-menu button.active img {
filter:invert(1);
}
.portfolio-area.inc-colum {
  /*padding-bottom: 105px;*/
}

@media (max-width: 991px) {
.wrap {
width:150px!important;
  white-space: nowrap;       
  overflow: hidden!important;         
  text-overflow: ellipsis;
  border:0px solid red; 
}
    /* Hide regular buttons on mobile view */
	.portfolio-area {
	border:0px solid red;
	display:block;
	width:100%;
	clear:both;
	margin-top:-5px;
	
	}
	.portfolio-area .mix-item-menu {
	text-align:center;
	flex-wrap: wrap;
    gap: 8px;
	
	}
    .portfolio-area .mix-item-menu button {
        /*display: none;*/
		padding:10px 10px;
border:0px solid red;
margin:5px 0px;
        width: auto; /* keeps size relative to text even on mobile */
        text-align: center;
		border-radius:10px!important;
		
    }
    /* Show the dropdown menu */
    .dropdown-tabs {
        display: block;
        width: 100%;
        text-align: center;
		border:none;
		margin:80px 0px 30px 0px;
		padding:0px 20px!important;
    }

    /* Style for the dropdown select */
    .dropdown-tabs select {
        width: 100%;
        padding: 10px!important;
        font-size: 16px;
        border-radius: 43px;
        border: 1px solid #ccc;
		padding-right:50px!important;
    }
}
/* Hide the dropdown menu on desktop */
@media (min-width: 768px) {
    .dropdown-tabs {
        display: none;
    }
}


.sector-item-menu button {
  background: transparent none repeat scroll 0 0;
  border: medium none;
  box-shadow: inherit;
  font-weight: 500;
  margin: 5px 5px;
  position: relative;
  z-index: 1;
  color: #121212;
border-radius:43px!important;
padding:10px 30px;
background:#fff;
font-size:16px;
}

.sector-item-menu {
  margin-bottom: 20px;
  margin-top: -10px;
}

.sector-item-menu .multi-btn.active {
  color: #fff;
  background:#9155F1;
}
.sector-item-menu .multi-btn.active img {
filter:invert(1);
}


.sector-item-menu.inc-colum {
  /*padding-bottom: 105px;*/
}

.content {
  /*display: flex;
  flex-wrap: wrap;
  gap: 15px;*/
  width:100%;
  /*min-height:900px;*/
  border:0px solid red;
}
.content.grid-view {
  display:block;
}
.content.list-view {
  display: none;
}
.content.grid-view .item {
  background-color: #fff;
  border-radius: 5px;
  padding: 0px;
  margin:10px 10px;
  border:1px solid #ccc;
}

.content.list-view .item {
   /* Full width for list view */
  margin-bottom: 10px; /* Add some space between items in list view */
  border:0px solid red;
  display:block!important;
  clear:both;
}
.pf-item {
position:relative;
 border: 0px solid #ddd; /* Optional: styling for individual items */
  background-color: #fff; /* Optional: styling for item background */
}
.bdr-radius {
border-radius:8px;
border:1px solid #D4D4D4;
}
.bdr-radius-no-radii {
border-radius:8px;
border:0px solid #D4D4D4;
}
.bdr-bottom {
border-bottom:1px solid #D4D4D4;
}
.content.grid-view .pf-item {
  float: left;
  padding: 0px;
  margin-bottom:40px;
  width:31.5%!important;
 
}
.content.list-view .pf-item {
 width: 100%;
   /*padding: 10px;
  margin: 10px 0;
  display: block;
  border: 1px solid #ddd;
  box-sizing: border-box;*/
}

.portfolio-area .portfolio-items.col-4 .pf-item h4 {
  font-size: 16px;
}
@media (max-width: 768px) {
.content.grid-view .item {
margin:10px 0px;
}
.content.grid-view .pf-item {
  float: left;
  padding: 0px;
  margin-bottom:40px;
  width:100%!important; 
}
}
.filter-btn.active {
    background-color: #007bff;
    color: white;
}

.filter-btn {
    cursor: pointer;
}
.filter-btn.active.black {
background-color: #000!important; 
    color: white!important; 
}

.list-view .table td {
padding:20px 0px;
vertical-align:middle;
}

.list-view .table td.companylogo img {
width:auto;
height:60px;
border:0px solid red;
text-align:center;
}
.list-view .table td.companylogo img {
}
@media (max-width:768px) {
.list-view .table td.companylogo img {
width:auto;
height:50px!important;
border:1px solid red;
text-align:center;
}
}
</style>