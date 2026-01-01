<?php

namespace App\Models;

use CodeIgniter\Model;

class YoutubeVideoModel extends Model
{
    protected $table = 've_youtube_videos';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['fld_product_id', 'fld_title', 'fld_description', 'fld_video_id', 'fld_total_views', 'fld_posted_at', 'fld_status'];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
    
    // Get all active YouTube videos with pagination
    public function getActiveVideos($limit=3, $offset=0)
    {
        return $this->where('fld_status', 1)
                    ->orderBy('fld_posted_at', 'DESC')
                    ->findAll($limit, $offset);
    }
    
    // Get all videos with pagination for admin
    public function getAllVideos($limit=20, $offset=0)
    {
        $videos = $this->orderBy('fld_posted_at', 'DESC')
                      ->findAll($limit, $offset);
        
        // Process each video to get product titles and general status
        foreach ($videos as &$video) {
            $video['product_titles'] = $this->getProductTitles($video['fld_product_id']);
            $video['is_general'] = $this->isGeneral($video['fld_product_id']);
        }
        
        return $videos;
    }
    
    // Count all videos for pagination
    public function countAllVideos()
    {
        return $this->countAll();
    }
    
    // Get videos by product ID
    public function getVideosByProduct($productId, $limit=3)
    {
        return $this->where("FIND_IN_SET('$productId', fld_product_id) > 0")
                    ->where('fld_status', 1)
                    ->orderBy('fld_posted_at', 'DESC')
                    ->findAll($limit);
    }
    
    // Get general videos (marked with 0)
    public function getGeneralVideos($limit=3)
    {
        return $this->where('fld_product_id', '0')
                    ->where('fld_status', 1)
                    ->orderBy('fld_posted_at', 'DESC')
                    ->findAll($limit);
    }
    
    // Get video by ID with associated products
    public function getVideoById($id)
    {
        $video = $this->find($id);
        
        if ($video) {
            // Convert comma-separated product IDs to array
            $video['products'] = $this->getProductIds($video['fld_product_id']);
            $video['is_general'] = $this->isGeneral($video['fld_product_id']);
        }
        
        return $video;
    }
    
    // Check if video is marked as general
    private function isGeneral($productIds)
    {
        if ($productIds === '0' || strpos($productIds, '0,') === 0) {
            return true;
        }
        return false;
    }
    
    // Convert comma-separated product IDs to array
    private function getProductIds($productIds)
    {
        if (empty($productIds)) {
            return [];
        }
        
        // Remove "0," prefix if it exists (for General + Products)
        if (strpos($productIds, '0,') === 0) {
            $productIds = substr($productIds, 2);
        }
        
        // Skip if it's just "0"
        if ($productIds === '0') {
            return [];
        }
        
        return $productIds ? explode(',', $productIds) : [];
    }
    
    // Get product titles from comma-separated product IDs
    private function getProductTitles($productIds)
    {
        if ($productIds === '0') {
            return 'General';
        }

        if (empty($productIds)) {
            return '';
        }

        $ids = explode(',', $productIds);

        $hasGeneral = in_array('0', $ids);

        // Remove 0 so DB query works
        $ids = array_diff($ids, ['0']);

        $titles = [];

        if (!empty($ids)) {
            $db = \Config\Database::connect();
            $products = $db->table('ve_products')
                ->select('fld_title')
                ->whereIn('id', $ids)
                ->get()
                ->getResultArray();

            $titles = array_column($products, 'fld_title');
        }

        // If only 0 existed
        if ($hasGeneral && empty($titles)) {
            return 'General';
        }

        // If 0 + products
        if ($hasGeneral) {
            array_unshift($titles, 'General');
        }

        return implode(', ', $titles);
    }
    
    // Create new video
    public function createVideo($data, $assignments = [])
    {
        // Process assignments
        $productIds = [];
        $isGeneral = false;
        
        foreach ($assignments as $assignment) {
            if ($assignment === 'general') {
                $isGeneral = true;
            } else {
                // It's a product ID
                $productIds[] = $assignment;
            }
        }
        
        // Build the product_id string
        if ($isGeneral && !empty($productIds)) {
            // General + Products: prefix with "0,"
            $data['fld_product_id'] = '0,' . implode(',', $productIds);
        } elseif ($isGeneral) {
            // General only
            $data['fld_product_id'] = '0';
        } elseif (!empty($productIds)) {
            // Products only
            $data['fld_product_id'] = implode(',', $productIds);
        } else {
            // Default to General
            $data['fld_product_id'] = '0';
        }
        
        return $this->insert($data);
    }
    
    // Update video
    public function updateVideo($id, $data, $assignments = [])
    {
        // Process assignments
        $productIds = [];
        $isGeneral = false;
        
        foreach ($assignments as $assignment) {
            if ($assignment === 'general') {
                $isGeneral = true;
            } else {
                // It's a product ID
                $productIds[] = $assignment;
            }
        }
        
        // Build the product_id string
        if ($isGeneral && !empty($productIds)) {
            // General + Products: prefix with "0,"
            $data['fld_product_id'] = '0,' . implode(',', $productIds);
        } elseif ($isGeneral) {
            // General only
            $data['fld_product_id'] = '0';
        } elseif (!empty($productIds)) {
            // Products only
            $data['fld_product_id'] = implode(',', $productIds);
        } else {
            // Default to General
            $data['fld_product_id'] = '0';
        }
        
        return $this->update($id, $data);
    }
    
    // Delete video
    public function deleteVideo($id)
    {
        return $this->delete($id);
    }
    
    // Get video details from YouTube API
    public function getVideoDetailsFromAPI($videoId)
    {
        $apiKey = 'AIzaSyArRr5L8UAFAUSz_Z9OmPkg6VaYYKcdUD4'; // Replace with your YouTube API key
        $url = 'https://www.googleapis.com/youtube/v3/videos?id=' . $videoId . '&key=' . $apiKey . '&part=snippet,statistics';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        
        if (isset($data['items'][0])) {
            $videoDetails = $data['items'][0];
            
            return [
                'title' => $videoDetails['snippet']['title'],
                'description' => $videoDetails['snippet']['description'],
                'total_views' => $videoDetails['statistics']['viewCount'],
                'posted_at' => date('Y-m-d H:i:s', strtotime($videoDetails['snippet']['publishedAt']))
            ];
        }
        
        return false;
    }

    public function getLatestVideos($limit = 3)
    {
        try {
            return $this->where('fld_status', 1)
                        ->orderBy('fld_posted_at', 'DESC')
                        ->findAll($limit);
        } catch (\Exception $e) {
            // Log the error
            log_message('error', 'Error in YoutubeVideoModel::getLatestVideos: ' . $e->getMessage());
            return [];
        }
    }
    
    // Helper function to format view count
    public function formatViewCount($views)
    {
        if ($views >= 1000000) {
            return round($views / 1000000, 1) . 'M';
        } else if ($views >= 1000) {
            return round($views / 1000, 1) . 'K';
        } else {
            return $views;
        }
    }
    
    // Helper function to get YouTube embed URL
    public function getEmbedUrl($videoId)
    {
        return 'https://www.youtube.com/embed/' . $videoId;
    }
    
    // Helper function to get time elapsed string
    public function getTimeElapsed($datetime)
    {
        $now = new \DateTime();
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}