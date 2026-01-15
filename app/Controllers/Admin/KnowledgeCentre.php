<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KnowledgeCategoryModel;
use App\Models\KnowledgeItemModel;
use App\Models\SectorModel;
use App\Models\ReportModel;
use App\Models\TopicModel;

class KnowledgeCentre extends BaseController
{
    protected $categoryModel;
    protected $itemModel;
    protected $sectorModel;
    protected $reportModel;
    protected $topicModel;

    public function __construct()
    {
        $this->categoryModel = new KnowledgeCategoryModel();
        $this->itemModel = new KnowledgeItemModel();
        $this->sectorModel = new SectorModel();
        $this->reportModel = new ReportModel();
        $this->topicModel = new TopicModel();
    }

    // Categories Management
    public function categories()
    {
        $data = [
            'categories' => $this->categoryModel->findAll(),
            'title' => 'Knowledge Categories'
        ];
        
        return view('admin/knowledge/categories/index', $data);
    }

    public function createCategory()
    {
        $data = [
            'title' => 'Create Knowledge Category',
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/knowledge/categories/create', $data);
    }

    public function storeCategory()
    {
        $rules = [
            'fld_title' => 'required|min_length[3]|max_length[100]',
            'fld_image' => 'uploaded[fld_image]|max_size[fld_image,1024]|is_image[fld_image]|mime_in[fld_image,image/jpg,image/jpeg,image/png,image/svg]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Generate slug
        $slug = $this->categoryModel->generateSlug($this->request->getVar('fld_title'));

        // Handle image upload
        $image = $this->request->getFile('fld_image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getName();
            $image->move(FCPATH . 'uploads/knowledge/categories', $newName);
            $imageName = 'uploads/knowledge/categories/' . $newName;
        } else {
            $imageName = null;
        }

        // Save category
        $categoryData = [
            'fld_title' => $this->request->getVar('fld_title'),
            'fld_slug' => $slug,
            'fld_image' => $imageName,
            'fld_status' => $this->request->getVar('fld_status') ? 1 : 0
        ];

        $this->categoryModel->insert($categoryData);

        return redirect()->to('/admin/knowledge-centre/categories')->with('success', 'Category created successfully');
    }

    public function editCategory($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to('/admin/knowledge-centre/categories')->with('error', 'Category not found');
        }

        $data = [
            'category' => $category,
            'title' => 'Edit Knowledge Category',
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/knowledge/categories/edit', $data);
    }

    public function updateCategory($id)
    {
        $rules = [
            'fld_title' => 'required|min_length[3]|max_length[100]'
        ];

        // Only validate image if a new one is uploaded
        if ($this->request->getFile('fld_image')->getName()) {
            $rules['fld_image'] = 'max_size[fld_image,1024]|is_image[fld_image]|mime_in[fld_image,image/jpg,image/jpeg,image/png,image/svg]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $category = $this->categoryModel->find($id);
        
        // Generate new slug if title changed
        if ($category['fld_title'] !== $this->request->getVar('fld_title')) {
            $slug = $this->categoryModel->generateSlug($this->request->getVar('fld_title'));
        } else {
            $slug = $category['fld_slug'];
        }

        // Handle image upload
        $image = $this->request->getFile('fld_image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Delete old image if exists
            if ($category['fld_image'] && file_exists(FCPATH . $category['fld_image'])) {
                unlink(FCPATH . $category['fld_image']);
            }
            
            $newName = $image->getName();
            $image->move(FCPATH . 'uploads/knowledge/categories', $newName);
            $imageName = 'uploads/knowledge/categories/' . $newName;
        } else {
            $imageName = $category['fld_image'];
        }

        // Update category
        $categoryData = [
            'fld_title' => $this->request->getVar('fld_title'),
            'fld_slug' => $slug,
            'fld_image' => $imageName,
            'fld_status' => $this->request->getVar('fld_status') ? 1 : 0
        ];

        $this->categoryModel->update($id, $categoryData);

        return redirect()->to('/admin/knowledge-centre/categories')->with('success', 'Category updated successfully');
    }

    public function deleteCategory($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to('/admin/knowledge-centre/categories')->with('error', 'Category not found');
        }

        // Check if category has items
        $itemsCount = $this->itemModel->where('fld_category_id', $id)->countAllResults();
        if ($itemsCount > 0) {
            return redirect()->to('/admin/knowledge-centre/categories')->with('error', 'Cannot delete category. It has associated items.');
        }

        // Delete image if exists
        if ($category['fld_image'] && file_exists(FCPATH . $category['fld_image'])) {
            unlink(FCPATH . $category['fld_image']);
        }

        // Delete category
        $this->categoryModel->delete($id);

        return redirect()->to('/admin/knowledge-centre/categories')->with('success', 'Category deleted successfully');
    }

    // Items Management
    public function items()
    {
        $data = [
            'items' => $this->itemModel->getItemsWithCategory(),
            'categories' => $this->categoryModel->where('fld_status', 1)->findAll(),
            'title' => 'Knowledge Items'
        ];
        
        return view('admin/knowledge/items/index', $data);
    }

    public function createItem()
    {
        $data = [
            'categories' => $this->categoryModel->where('fld_status', 1)->findAll(),
            'title' => 'Create Knowledge Item',
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/knowledge/items/create', $data);
    }

    public function storeItem()
    {
        $rules = [
            'fld_category_id' => 'required|integer',
            'fld_title' => 'required|min_length[3]|max_length[255]',
            'fld_video_url' => 'required|valid_url',
            'fld_duration' => 'permit_empty|max_length[20]',
            'fld_description' => 'required|min_length[10]',
            'fld_posted_at' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Save item
        $itemData = [
            'fld_category_id' => $this->request->getVar('fld_category_id'),
            'fld_title' => $this->request->getVar('fld_title'),
            'fld_video_url' => $this->request->getVar('fld_video_url'),
            'fld_duration' => $this->request->getVar('fld_duration'),
            'fld_description' => $this->request->getVar('fld_description'),
            'fld_posted_at' => $this->request->getVar('fld_posted_at'),
            'fld_status' => $this->request->getVar('fld_status') ? 1 : 0
        ];

        $this->itemModel->insert($itemData);

        return redirect()->to('/admin/knowledge-centre/items')->with('success', 'Item created successfully');
    }

    public function editItem($id)
    {
        $item = $this->itemModel->getItemWithCategory($id);
        
        if (!$item) {
            return redirect()->to('/admin/knowledge-centre/items')->with('error', 'Item not found');
        }

        $data = [
            'item' => $item,
            'categories' => $this->categoryModel->where('fld_status', 1)->findAll(),
            'title' => 'Edit Knowledge Item',
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/knowledge/items/edit', $data);
    }

    public function updateItem($id)
    {
        $rules = [
            'fld_category_id' => 'required|integer',
            'fld_title' => 'required|min_length[3]|max_length[255]',
            'fld_video_url' => 'required|valid_url',
            'fld_duration' => 'permit_empty|max_length[20]',
            'fld_description' => 'required|min_length[10]',
            'fld_posted_at' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Update item
        $itemData = [
            'fld_category_id' => $this->request->getVar('fld_category_id'),
            'fld_title' => $this->request->getVar('fld_title'),
            'fld_video_url' => $this->request->getVar('fld_video_url'),
            'fld_duration' => $this->request->getVar('fld_duration'),
            'fld_description' => $this->request->getVar('fld_description'),
            'fld_posted_at' => $this->request->getVar('fld_posted_at'),
            'fld_status' => $this->request->getVar('fld_status') ? 1 : 0
        ];

        $this->itemModel->update($id, $itemData);

        return redirect()->to('/admin/knowledge-centre/items')->with('success', 'Item updated successfully');
    }

    public function deleteItem($id)
    {
        $item = $this->itemModel->find($id);
        
        if (!$item) {
            return redirect()->to('/admin/knowledge-centre/items')->with('error', 'Item not found');
        }

        // Delete item
        $this->itemModel->delete($id);

        return redirect()->to('/admin/knowledge-centre/items')->with('success', 'Item deleted successfully');
    }

    public function sectors()
    {
        $data['title'] = 'Sectors Management';
        $data['sectors'] = $this->sectorModel->getAllSectors()->paginate(20);
        $data['pager'] = $this->sectorModel->pager;
        
        return view('admin/knowledge/sectors/index', $data);
    }
    
    public function createSector()
    {
        $data['title'] = 'Create Sector';
        
        return view('admin/knowledge/sectors/create', $data);
    }
    
    public function storeSector()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]',
            'used_for' => 'required|in_list[1,2,3]',
            'sort_order' => 'required|numeric'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $image = $this->request->getFile('image');
        $icon = $this->request->getFile('icon');
        
        $imagePath = '';
        $iconPath = '';
        
        // Handle image upload
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move('uploads/sector_image', $newName);
            $imagePath = 'uploads/sector_image/' . $newName;
        }
        
        // Handle icon upload
        if ($icon && $icon->isValid() && !$icon->hasMoved()) {
            $newName = $icon->getRandomName();
            $icon->move('uploads/sector_icon', $newName);
            $iconPath = 'uploads/sector_icon/' . $newName;
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'image' => $imagePath,
            'icon' => $iconPath,
            'active' => $this->request->getPost('active') ? 1 : 0,
            'used_for' => $this->request->getPost('used_for'),
            'sort_order' => $this->request->getPost('sort_order'),
            'created_by' => session()->get('adminId'),
            'created_ip' => $this->request->getIPAddress(),
            'created_datetime' => date('Y-m-d H:i:s'),
            'modified_by' => session()->get('adminId'),
            'modified_ip' => $this->request->getIPAddress(),
            'modified_datetime' => date('Y-m-d H:i:s')
        ];
        
        $this->sectorModel->insert($data);
        
        return redirect()->to('/admin/knowledge-centre/sectors')->with('success', 'Sector created successfully');
    }
    
    public function editSector($id)
    {
        $data['title'] = 'Edit Sector';
        $data['sector'] = $this->sectorModel->find($id);
        
        if (empty($data['sector'])) {
            return redirect()->to('/admin/knowledge-centre/sectors')->with('error', 'Sector not found');
        }
        
        return view('admin/knowledge/sectors/edit', $data);
    }
    
    public function updateSector($id)
    {
        $sector = $this->sectorModel->find($id);
        
        if (empty($sector)) {
            return redirect()->to('/admin/knowledge-centre/sectors')->with('error', 'Sector not found');
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]',
            'used_for' => 'required|in_list[1,2,3]',
            'sort_order' => 'required|numeric'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $image = $this->request->getFile('image');
        $icon = $this->request->getFile('icon');
        
        $data = [
            'name' => $this->request->getPost('name'),
            'active' => $this->request->getPost('active') ? 1 : 0,
            'used_for' => $this->request->getPost('used_for'),
            'sort_order' => $this->request->getPost('sort_order'),
            'modified_by' => session()->get('adminId'),
            'modified_ip' => $this->request->getIPAddress(),
            'modified_datetime' => date('Y-m-d H:i:s')
        ];
        
        // Handle image upload
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Delete old image if exists
            if (!empty($sector['image']) && file_exists($sector['image'])) {
                unlink($sector['image']);
            }
            
            $newName = $image->getRandomName();
            $image->move('uploads/sector_image', $newName);
            $data['image'] = 'uploads/sector_image/' . $newName;
        }
        
        // Handle icon upload
        if ($icon && $icon->isValid() && !$icon->hasMoved()) {
            // Delete old icon if exists
            if (!empty($sector['icon']) && file_exists($sector['icon'])) {
                unlink($sector['icon']);
            }
            
            $newName = $icon->getRandomName();
            $icon->move('uploads/sector_icon', $newName);
            $data['icon'] = 'uploads/sector_icon/' . $newName;
        }
        
        $this->sectorModel->update($id, $data);
        
        return redirect()->to('/admin/knowledge-centre/sectors')->with('success', 'Sector updated successfully');
    }
    
    public function deleteSector($id)
    {
        $sector = $this->sectorModel->find($id);
        
        if (empty($sector)) {
            return redirect()->to('/admin/knowledge-centre/sectors')->with('error', 'Sector not found');
        }
        
        // Delete image and icon if they exist
        if (!empty($sector['image']) && file_exists($sector['image'])) {
            unlink($sector['image']);
        }
        
        if (!empty($sector['icon']) && file_exists($sector['icon'])) {
            unlink($sector['icon']);
        }
        
        $this->sectorModel->delete($id);
        
        return redirect()->to('/admin/knowledge-centre/sectors')->with('success', 'Sector deleted successfully');
    }
    
    public function reports()
    {
        $data['title'] = 'Reports Management';
        
        // Set pagination configuration
        $perPage = 20;
        $data['reports'] = $this->reportModel->getReportsWithSector($perPage);
        $data['pager'] = $this->reportModel->pager;
        
        // Prepare reports with market cap labels
        foreach ($data['reports'] as &$report) {
            $report['market_cap_label'] = $this->reportModel->getMarketCapLabel($report['market_cap']);
        }
        
        return view('admin/knowledge/reports/index', $data);
    }

    public function createReport()
    {
        $data['title'] = 'Create Report';
        $data['sectors'] = $this->sectorModel->where('used_for', 2)->findAll(); // Only sectors used for reports
        $data['marketCaps'] = $this->reportModel->getMarketCapOptions();
        
        return view('admin/knowledge/reports/create', $data);
    }

    public function storeReport()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'company_name' => 'required|min_length[2]|max_length[255]',
            'sector_id' => 'required|integer',
            'market_cap' => 'required|in_list[1,2,3,4,5]',
            'description' => 'required|min_length[10]',
            'sort_order' => 'required|numeric'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $logo = $this->request->getFile('logo');
        $logoPath = '';
        
        // Handle logo upload
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $newName = $logo->getRandomName();
            $logo->move('uploads/report_logo', $newName);
            $logoPath = 'uploads/report_logo/' . $newName;
        }
        
        $data = [
            'company_name' => $this->request->getPost('company_name'),
            'sector_id' => $this->request->getPost('sector_id'),
            'market_cap' => $this->request->getPost('market_cap'),
            'description' => $this->request->getPost('description'),
            'logo' => $logoPath,
            'active' => $this->request->getPost('active') ? 1 : 0,
            'recommended' => $this->request->getPost('recommended') ? 1 : 0,
            'sort_order' => $this->request->getPost('sort_order'),
            'created_by' => session()->get('adminId'),
            'created_ip' => $this->request->getIPAddress(),
            'created_datetime' => date('Y-m-d H:i:s'),
            'modified_by' => session()->get('adminId'),
            'modified_ip' => $this->request->getIPAddress(),
            'modified_datetime' => date('Y-m-d H:i:s')
        ];
        
        $this->reportModel->insert($data);
        
        return redirect()->to('/admin/knowledge-centre/reports')->with('success', 'Report created successfully');
    }

    public function editReport($id)
    {
        $data['title'] = 'Edit Report';
        $data['report'] = $this->reportModel->find($id);
        $data['sectors'] = $this->sectorModel->where('used_for', 2)->findAll(); // Only sectors used for reports
        $data['marketCaps'] = $this->reportModel->getMarketCapOptions();
        
        if (empty($data['report'])) {
            return redirect()->to('/admin/knowledge-centre/reports')->with('error', 'Report not found');
        }
        
        return view('admin/knowledge/reports/edit', $data);
    }

    public function updateReport($id)
    {
        $report = $this->reportModel->find($id);
        
        if (empty($report)) {
            return redirect()->to('/admin/knowledge-centre/reports')->with('error', 'Report not found');
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'company_name' => 'required|min_length[2]|max_length[255]',
            'sector_id' => 'required|integer',
            'market_cap' => 'required|in_list[1,2,3,4,5]',
            'description' => 'required|min_length[10]',
            'sort_order' => 'required|numeric'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $logo = $this->request->getFile('logo');
        
        $data = [
            'company_name' => $this->request->getPost('company_name'),
            'sector_id' => $this->request->getPost('sector_id'),
            'market_cap' => $this->request->getPost('market_cap'),
            'description' => $this->request->getPost('description'),
            'active' => $this->request->getPost('active') ? 1 : 0,
            'recommended' => $this->request->getPost('recommended') ? 1 : 0,
            'sort_order' => $this->request->getPost('sort_order'),
            'modified_by' => session()->get('adminId'),
            'modified_ip' => $this->request->getIPAddress(),
            'modified_datetime' => date('Y-m-d H:i:s')
        ];
        
        // Handle logo upload
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            // Delete old logo if exists
            if (!empty($report['logo']) && file_exists($report['logo'])) {
                unlink($report['logo']);
            }
            
            $newName = $logo->getRandomName();
            $logo->move('uploads/report_logo', $newName);
            $data['logo'] = 'uploads/report_logo/' . $newName;
        }
        
        $this->reportModel->update($id, $data);
        
        return redirect()->to('/admin/knowledge-centre/reports')->with('success', 'Report updated successfully');
    }

    public function deleteReport($id)
    {
        $report = $this->reportModel->find($id);
        
        if (empty($report)) {
            return redirect()->to('/admin/knowledge-centre/reports')->with('error', 'Report not found');
        }
        
        // Delete logo if it exists
        if (!empty($report['logo']) && file_exists($report['logo'])) {
            unlink($report['logo']);
        }
        
        $this->reportModel->delete($id);
        
        return redirect()->to('/admin/knowledge-centre/reports')->with('success', 'Report deleted successfully');
    }

    // Topic Management Methods
    public function topics()
    {
        $data['title'] = 'Topics Management';
        $data['topics'] = $this->topicModel->getAllTopics();
        $data['pager'] = $this->topicModel->pager;
        
        return view('admin/knowledge/topics/index', $data);
    }
    
    public function createTopic()
    {
        $data['title'] = 'Create Topic';
        $data['sectors'] = $this->topicModel->getKnowledgeSectors();
        
        return view('admin/knowledge/topics/create', $data);
    }
    
    public function storeTopic()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'sector_id' => 'required|numeric',
            'name' => 'required|min_length[2]|max_length[255]',
            'description' => 'required',
            'sort_order' => 'required|numeric'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $icon = $this->request->getFile('icon');
        $iconPath = '';
        
        // Handle icon upload
        if ($icon && $icon->isValid() && !$icon->hasMoved()) {
            $newName = $icon->getRandomName();
            $icon->move('uploads/sector_pdf/icon', $newName);
            $iconPath = 'uploads/sector_pdf/icon/' . $newName;
        }
        
        $data = [
            'sector_id' => $this->request->getPost('sector_id'),
            'name' => $this->request->getPost('name'),
            'icon' => $iconPath,
            'description' => $this->request->getPost('description'),
            'sort_order' => $this->request->getPost('sort_order'),
            'active' => $this->request->getPost('active') ? 1 : 0,
            'created_by' => session()->get('adminId'),
            'created_ip' => $this->request->getIPAddress(),
            'created_datetime' => date('Y-m-d H:i:s')
        ];
        
        $this->topicModel->insert($data);
        
        return redirect()->to('/admin/knowledge-centre/topics')->with('success', 'Topic created successfully');
    }
    
    public function editTopic($id)
    {
        $data['title'] = 'Edit Topic';
        $data['topic'] = $this->topicModel->find($id);
        $data['sectors'] = $this->topicModel->getKnowledgeSectors();
        
        if (empty($data['topic'])) {
            return redirect()->to('/admin/knowledge-centre/topics')->with('error', 'Topic not found');
        }
        
        return view('admin/knowledge/topics/edit', $data);
    }
    
    public function updateTopic($id)
    {
        $topic = $this->topicModel->find($id);
        
        if (empty($topic)) {
            return redirect()->to('/admin/knowledge-centre/topics')->with('error', 'Topic not found');
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'sector_id' => 'required|numeric',
            'name' => 'required|min_length[2]|max_length[255]',
            'description' => 'required',
            'sort_order' => 'required|numeric'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $icon = $this->request->getFile('icon');
        
        $data = [
            'sector_id' => $this->request->getPost('sector_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'sort_order' => $this->request->getPost('sort_order'),
            'active' => $this->request->getPost('active') ? 1 : 0
        ];
        
        // Handle icon upload
        if ($icon && $icon->isValid() && !$icon->hasMoved()) {
            // Delete old icon if exists
            if (!empty($topic['icon']) && file_exists($topic['icon'])) {
                unlink($topic['icon']);
            }
            
            $newName = $icon->getRandomName();
            $icon->move('uploads/sector_pdf/icon', $newName);
            $data['icon'] = 'uploads/sector_pdf/icon/' . $newName;
        }
        
        $this->topicModel->update($id, $data);
        
        return redirect()->to('/admin/knowledge-centre/topics')->with('success', 'Topic updated successfully');
    }
    
    public function deleteTopic($id)
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/admin/knowledge-centre/topics')->with('error', 'Invalid request method');
        }
        
        if ($this->topicModel->deleteTopic($id)) {
            return redirect()->to('/admin/knowledge-centre/topics')->with('success', 'Topic deleted successfully');
        } else {
            return redirect()->to('/admin/knowledge-centre/topics')->with('error', 'Topic not found');
        }
    }
}