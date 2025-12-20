<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo text-center d-flex align-items-center justify-content-center mb-3 mt-4">
    <a href="<?= base_url('admin/dashboard') ?>" class="app-brand-link d-flex align-items-center justify-content-center"> 
        <img src="<?= base_url('assets/img/logo.png') ?>" alt="Value Educator Logo" style="height: auto; width: 200px;">
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Main</span>
    </li>
    <li class="menu-item <?= (strpos(current_url(), 'dashboard') !== false) ? 'active' : '' ?>">
      <a href="<?= base_url('admin/dashboard') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <!-- Content Management Section -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Content Management</span>
    </li>

    <!-- Investment Philosophy -->
    <li class="menu-item <?= (strpos(current_url(), 'investment-philosophy') !== false) ? 'active' : '' ?>">
      <a href="<?= base_url('admin/investment-philosophy') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-brain"></i>
        <div data-i18n="Investment Philosophy">Investment Philosophy</div>
      </a>
    </li>

    <!-- FAQs -->
    <li class="menu-item <?= (strpos(current_url(), 'faqs') !== false) ? 'active' : '' ?>">
      <a href="<?= base_url('admin/faqs') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-help-circle"></i>
        <div data-i18n="FAQs">FAQs</div>
      </a>
    </li>

    <!-- YouTube Videos -->
    <li class="menu-item <?= (strpos(current_url(), 'youtube-videos') !== false) ? 'active' : '' ?>">
      <a href="<?= base_url('admin/youtube-videos') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-video"></i>
        <div data-i18n="YouTube Videos">YouTube Videos</div>
      </a>
    </li>

    <!-- Products Section -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Products</span>
    </li>

    <!-- Product Management -->
    <li class="menu-item <?= (strpos(current_url(), 'products') !== false) ? 'active open' : '' ?>">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-package"></i>
        <div data-i18n="Product Management">Product Management</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item <?= (current_url() === base_url('admin/products') || strpos(current_url(), 'products/index') !== false) ? 'active' : '' ?>">
          <a href="<?= base_url('admin/products') ?>" class="menu-link">
            <div data-i18n="All Products">All Products</div>
          </a>
        </li> 
        <li class="menu-item <?= (strpos(current_url(), 'products/create') !== false) ? 'active' : '' ?>">
          <a href="<?= base_url('admin/products/create') ?>" class="menu-link">
            <div data-i18n="Create Product">Create Product</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Knowledge Centre -->
    <li class="menu-item <?= (strpos(current_url(), 'knowledge-centre') !== false) ? 'active open' : '' ?>">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-book-open"></i>
        <div data-i18n="Knowledge Centre">Knowledge Centre</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item <?= (strpos(current_url(), 'knowledge-centre/categories') !== false) ? 'active' : '' ?>">
          <a href="<?= base_url('admin/knowledge-centre/categories') ?>" class="menu-link">
            <div data-i18n="Categories">Categories</div>
          </a>
        </li>
        <li class="menu-item <?= (strpos(current_url(), 'knowledge-centre/items') !== false) ? 'active' : '' ?>">
          <a href="<?= base_url('admin/knowledge-centre/items') ?>" class="menu-link">
            <div data-i18n="Items">Items</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Compliance Section -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Compliance</span>
    </li>

    <!-- Complaint Data -->
    <li class="menu-item <?= (strpos(current_url(), 'complaint-data') !== false) ? 'active' : '' ?>">
      <a href="<?= base_url('admin/complaint-data') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div data-i18n="Complaint Data">Complaint Data</div>
      </a>
    </li>

    <!-- Disclosures and Disclaimer -->
    <li class="menu-item <?= (strpos(current_url(), 'disclosures') !== false) ? 'active' : '' ?>">
      <a href="<?= base_url('admin/disclosures') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
        <div data-i18n="Disclosures">Disclosures and Disclaimer</div>
      </a>
    </li>

    <!-- Grievance Redressal -->
    <li class="menu-item <?= (strpos(current_url(), 'grievance') !== false) ? 'active' : '' ?>">
      <a href="<?= base_url('admin/grievance') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-support"></i>
        <div data-i18n="Grievance Redressal">Grievance Redressal</div>
      </a>
    </li>

    <!-- Investor Charter -->
    <li class="menu-item <?= (strpos(current_url(), 'investor-charter') !== false) ? 'active' : '' ?>">
      <a href="<?= base_url('admin/investor-charter') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-certification"></i>
        <div data-i18n="Investor Charter">Investor Charter</div>
      </a>
    </li>

    <!-- Legal Section -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Legal</span>
    </li>

    <!-- Privacy Policy -->
    <li class="menu-item <?= (strpos(current_url(), 'privacy-policy') !== false) ? 'active' : '' ?>">
      <a href="<?= base_url('admin/privacy-policy') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-lock"></i>
        <div data-i18n="Privacy Policy">Privacy Policy</div>
      </a>
    </li>

    <!-- Refund and Cancellation -->
    <li class="menu-item <?= (strpos(current_url(), 'refund-cancellation') !== false) ? 'active' : '' ?>">
      <a href="<?= base_url('admin/refund-cancellation') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-money"></i>
        <div data-i18n="Refund and Cancellation">Refund and Cancellation</div>
      </a>
    </li>

    <!-- Terms and Conditions -->
    <li class="menu-item <?= (strpos(current_url(), 'terms-conditions') !== false) ? 'active' : '' ?>">
      <a href="<?= base_url('admin/terms-conditions') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file-blank"></i>
        <div data-i18n="Terms and Conditions">Terms and Conditions</div>
      </a>
    </li>

    <!-- UPI ID -->
    <li class="menu-item <?= (strpos(current_url(), 'otp-page') !== false) ? 'active' : '' ?>">
      <a href="<?= base_url('admin/upi-id') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-key"></i>
        <div data-i18n="UPI ID">UPI ID</div>
      </a>
    </li>

    <!-- Substack Updates -->
    <li class="menu-item <?= (strpos(current_url(), 'substack-updates') !== false) ? 'active' : '' ?>">
      <a href="<?= base_url('admin/substack-updates') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-news"></i>
        <div data-i18n="Substack Updates">Substack Updates</div>
      </a>
    </li>

    <!-- User Management Section -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">User Management</span>
    </li>

    <!-- User Management Dropdown -->
    <li class="menu-item <?= (strpos(current_url(), 'users') !== false || strpos(current_url(), 'admin-users') !== false) ? 'active open' : '' ?>">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="User Management">User Management</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item <?= (strpos(current_url(), 'users') !== false && strpos(current_url(), 'admin-users') === false) ? 'active' : '' ?>">
          <a href="<?= base_url('admin/users') ?>" class="menu-link">
            <i class="menu-icon tf-icons bx bx-group"></i>
            <div data-i18n="Front Users">Front Users</div>
          </a>
        </li>
        <li class="menu-item <?= (strpos(current_url(), 'admin-users') !== false) ? 'active' : '' ?>">
          <a href="<?= base_url('admin/admin-users') ?>" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user-pin"></i>
            <div data-i18n="Admin Users">Admin Users</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Administration Section -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Administration</span>
    </li>

    <!-- Site Settings -->
    <li class="menu-item <?= (strpos(current_url(), 'settings') !== false) ? 'active' : '' ?>">
      <a href="<?= base_url('admin/settings') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Site Settings">Site Settings</div>
      </a>
    </li>

  </ul>
</aside>