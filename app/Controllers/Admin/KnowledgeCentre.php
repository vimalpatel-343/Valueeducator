<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KnowledgeCategoryModel;
use App\Models\KnowledgeItemModel;

class KnowledgeCentre extends BaseController
{
    protected $categoryModel;
    protected $itemModel;

    public function __construct()
    {
        $this->categoryModel = new KnowledgeCategoryModel();
        $this->itemModel = new KnowledgeItemModel();
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
}