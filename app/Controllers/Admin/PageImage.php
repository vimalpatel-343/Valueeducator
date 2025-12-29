<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PageImageModel;

class PageImage extends BaseController
{
    protected $pageImageModel;
    
    // Predefined pages and sections
    protected $predefinedSections = [
        'home' => [
            'main_image' => 'Main Image',
            'join_substack' => 'Join our Substack',
            'shashank_image' => 'Value Educator Shashank image',
            'founder_image' => 'Our Founder'
        ],
        'about_us' => [
            'beyond_mainstream' => 'Beyond the Mainstream',
            'scuttlebutt_research' => 'Scuttlebutt Research',
            'investing_smarter' => 'Investing Smarter',
            'no_fomo' => 'No FOMO, No Overheated Markets',
            'passionate_team' => 'Passionate, Committed Team',
            'integrity_transparency' => 'Integrity & Transparency',
            'integrity_first' => 'Integrity First',
            'focused_precision' => 'Focused Precision',
            'team_synergy' => 'Team Synergy',
            'relentless_drive' => 'Relentless Drive',
            'vision' => 'Our Vision',
            'mission' => 'Our Mission'
        ],
        'investment_philosophy' => [
            'main_image' => 'Main Image'
        ],
        'emerging_titans' => [
            'main_image' => 'Main Image',
            'investment_horizon' => 'Investment Horizon',
            'minimum_investment' => 'Minimum Investment',
            'rebalance_frequency' => 'Rebalance Frequency',
            'next_rebalance' => 'Next Rebalance',
            'pricing_image_1' => 'Pricing Image 1',
            'pricing_image_2' => 'Pricing Image 2'
        ],
        'tiny_titans' => [
            'main_image' => 'Main Image',
            'scuttlebutt_notes' => 'Scuttlebutt notes',
            'minimum_investment' => 'Minimum Investment',
            'management_interview' => 'Management Interview',
            'pricing_image_1' => 'Pricing Image 1',
            'pricing_image_2' => 'Pricing Image 2'
        ],
        'other' => [
            'factsheet_icon' => 'Factsheet icon (25X25)',
            'chat_with_us' => 'Chat With Us (25X25)',
            'call_our_experts' => 'Call Our Experts (25X25)',
            'dashboard' => 'Dashboard (25X25)',
            'portfolio' => 'Portfolio (25X25)',
            'knowledge_centre' => 'Knowledge Centre (25X25)'
        ]
    ];
    
    public function __construct()
    {
        $this->pageImageModel = new PageImageModel();
        helper(['form', 'url']);
    }
    
    // Show all page images in a single view
    public function index()
    {
        $data['title'] = 'Page Images Management';
        $data['predefinedSections'] = $this->predefinedSections;
        
        // Get existing images
        $existingImages = $this->pageImageModel->findAll();
        $data['existingImages'] = [];
        
        foreach ($existingImages as $image) {
            $data['existingImages'][$image['page_name']][$image['section_name']] = $image;
        }
        
        return view('admin/page_images/index', $data);
    }
    
    // Update page images
    public function update()
    {
        foreach ($this->predefinedSections as $page => $sections) 
        {
            foreach ($sections as $section => $label) 
            {
                // Check if a new image is uploaded for this section
                if ($this->request->getFile("{$page}_{$section}")->getName()) 
                {
                    $imageFile = $this->request->getFile("{$page}_{$section}");
                    
                    if ($imageFile->isValid() && !$imageFile->hasMoved()) 
                    {
                        // Get existing image record
                        $existingImage = $this->pageImageModel->getImageByPageSection($page, $section);

                        // Keep original uploaded filename
                        $originalName = $imageFile->getName();

                        $uploadPath = 'uploads/page_images/';
                        $imagePath  = $uploadPath . $originalName;

                        // Delete old image if exists AND name is different
                        if ($existingImage && file_exists($existingImage['image_path'])) {
                            unlink($existingImage['image_path']);
                        }

                        // Move image (overwrite = true)
                        $imageFile->move($uploadPath, $originalName, true);

                        $imageData = [
                            'page_name'    => $page,
                            'section_name' => $section,
                            'image_path'   => $imagePath,
                            'image_alt'    => $this->request->getPost("alt_{$page}_{$section}"),
                            'status'       => 1
                        ];

                        if ($existingImage) {
                            // Update record
                            $this->pageImageModel->update($existingImage['id'], $imageData);
                        } else {
                            // Insert record
                            $this->pageImageModel->insert($imageData);
                        }
                    }

                } 
                elseif ($this->request->getPost("alt_{$page}_{$section}")) 
                {
                    // Only update alt text if no new image is uploaded
                    $existingImage = $this->pageImageModel->getImageByPageSection($page, $section);
                    
                    if ($existingImage) 
                    {
                        $this->pageImageModel->update($existingImage['id'], [
                            'image_alt' => $this->request->getPost("alt_{$page}_{$section}")
                        ]);
                    }
                }
            }
        }
        
        return redirect()->to('/admin/page-images')->with('success', 'Page images updated successfully');
    }
}