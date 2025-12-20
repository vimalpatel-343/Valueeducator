<?php

namespace App\Models;

use CodeIgniter\Model;

class InvestmentPhilosophyModel extends Model
{
    protected $table = 've_investment_philosophy';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['fld_title', 'fld_image', 'fld_description', 'fld_status'];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
    
    // Get all active investment philosophies with related data
    public function getActivePhilosophies()
    {
        $philosophies = $this->where('fld_status', 1)->findAll();
        
        // Add services and images to each philosophy
        foreach ($philosophies as &$philosophy) {
            $philosophy['services'] = $this->getServicesByPhilosophyId($philosophy['id']);
            $philosophy['images'] = $this->getImagesByPhilosophyId($philosophy['id']);
        }
        
        return $philosophies;
    }
    
    // Get philosophy by ID with related data
    public function getPhilosophyById($id)
    {
        $philosophy = $this->find($id);
        
        if ($philosophy) {
            $philosophy['services'] = $this->getServicesByPhilosophyId($id);
            $philosophy['images'] = $this->getImagesByPhilosophyId($id);
        }
        
        return $philosophy;
    }
    
    // Get services by philosophy ID
    public function getServicesByPhilosophyId($philosophyId)
    {
        $serviceModel = new InvestmentPhilosophyServiceModel();
        return $serviceModel->where('philosophy_id', $philosophyId)->findAll();
    }
    
    // Get images by philosophy ID
    public function getImagesByPhilosophyId($philosophyId)
    {
        $imageModel = new InvestmentPhilosophyImageModel();
        return $imageModel->where('philosophy_id', $philosophyId)->orderBy('display_order', 'ASC')->findAll();
    }
    
    // Create new philosophy with services and images
    public function createPhilosophy($data, $services = [], $images = [])
    {
        // Start transaction
        $this->transStart();
        
        // Insert philosophy
        $philosophyId = $this->insert($data);
        
        // Insert services
        if (!empty($services)) {
            $serviceModel = new InvestmentPhilosophyServiceModel();
            foreach ($services as $service) {
                $service['philosophy_id'] = $philosophyId;
                $serviceModel->insert($service);
            }
        }
        
        // Insert images
        if (!empty($images)) {
            $imageModel = new InvestmentPhilosophyImageModel();
            foreach ($images as $index => $image) {
                $imageData = [
                    'philosophy_id' => $philosophyId,
                    'image_path' => $image,
                    'display_order' => $index
                ];
                $imageModel->insert($imageData);
            }
        }
        
        // Complete transaction
        $this->transComplete();
        
        return $philosophyId;
    }
    
    // Update philosophy with services and images
    public function updatePhilosophy($id, $data, $services = [], $images = [])
    {
        // Start transaction
        $this->transStart();
        
        // Update philosophy
        $this->update($id, $data);
        
        // Update services - delete existing and insert new
        $serviceModel = new InvestmentPhilosophyServiceModel();
        $serviceModel->where('philosophy_id', $id)->delete();
        
        if (!empty($services)) {
            foreach ($services as $service) {
                $service['philosophy_id'] = $id;
                $serviceModel->insert($service);
            }
        }
        
        // Update images - delete existing and insert new
        $imageModel = new InvestmentPhilosophyImageModel();
        $imageModel->where('philosophy_id', $id)->delete();
        
        if (!empty($images)) {
            foreach ($images as $index => $image) {
                $imageData = [
                    'philosophy_id' => $id,
                    'image_path' => $image,
                    'display_order' => $index
                ];
                $imageModel->insert($imageData);
            }
        }
        
        // Complete transaction
        $this->transComplete();
        
        return true;
    }
    
    // Delete philosophy with related data
    public function deletePhilosophy($id)
    {
        // Start transaction
        $this->transStart();
        
        // Get philosophy to delete images
        $philosophy = $this->find($id);
        
        // Delete services
        $serviceModel = new InvestmentPhilosophyServiceModel();
        $serviceModel->where('philosophy_id', $id)->delete();
        
        // Delete images and files
        $imageModel = new InvestmentPhilosophyImageModel();
        $existingImages = $imageModel->where('philosophy_id', $id)->findAll();
        
        foreach ($existingImages as $image) {
            if (file_exists($image['image_path'])) {
                unlink($image['image_path']);
            }
        }
        
        $imageModel->where('philosophy_id', $id)->delete();
        
        // Delete main image
        if (!empty($philosophy['fld_image']) && file_exists($philosophy['fld_image'])) {
            unlink($philosophy['fld_image']);
        }
        
        // Delete philosophy
        $this->delete($id);
        
        // Complete transaction
        $this->transComplete();
        
        return true;
    }
}

// Create new models for services and images
class InvestmentPhilosophyServiceModel extends Model
{
    protected $table = 've_investment_philosophy_services';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['philosophy_id', 'icon_name', 'service_title', 'service_description'];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
}

class InvestmentPhilosophyImageModel extends Model
{
    protected $table = 've_investment_philosophy_images';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['philosophy_id', 'image_path', 'display_order'];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
}