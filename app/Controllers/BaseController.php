<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['url', 'form'];

    protected $siteSettings;
    protected $ProductModel;
    protected $userSubscriptions = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Ensure session is started
        if (!session()->isInitialized) {
            session()->start();
        }
        
        // Load the Text Helper
        helper('text');
        
        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');

        // Load site settings model
        $this->siteSettings = new \App\Models\SiteSettingsModel();
        $this->ProductModel = new \App\Models\ProductModel();

        // Get user subscriptions if logged in
        if (session()->get('isLoggedIn')) {
            $userSubscriptionModel = new \App\Models\UserSubscriptionModel();
            $this->userSubscriptions = $userSubscriptionModel->getUserSubscriptions(session()->get('userId'));
        }
    }

    protected function getSiteSettings()
    {
        return $this->siteSettings->getSettings();
    }

    protected function fetchProducts()
    {
        return $this->ProductModel->getActiveProducts();
    }

    protected function getUserSubscriptions()
    {
        return $this->userSubscriptions;
    }

    protected function generatePageUrl($page)
    {
        $params = $this->request->getGet();
        $params['page'] = $page;
        
        return base_url('admin/users') . '?' . http_build_query($params);
    }

    protected function checkProductAccess($productSlug)
    {
        if (!session()->get('isLoggedIn')) {
            return false;
        }

        $userId = session()->get('userId');
        $userSubscriptionModel = new \App\Models\UserSubscriptionModel();
        return $userSubscriptionModel->hasActiveSubscriptionBySlug($userId, $productSlug);
    }
}
