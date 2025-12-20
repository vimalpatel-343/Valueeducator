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
    
    // Get all active YouTube videos
    public function getActiveVideos($limit=3)
    {
        return $this->where('fld_status', 1)
                    ->orderBy('fld_posted_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
    
    // Get videos by product ID
    public function getVideosByProduct($productId)
    {
        return $this->where('fld_product_id', $productId)->where('fld_status', 1)->findAll();
    }
    
    // Get general videos (not associated with any product)
    public function getGeneralVideos()
    {
        return $this->where('fld_product_id', NULL)->where('fld_status', 1)->findAll();
    }
    
    // Get video by ID
    public function getVideoById($id)
    {
        return $this->find($id);
    }
    
    // Create new video
    public function createVideo($data)
    {
        return $this->insert($data);
    }
    
    // Update video
    public function updateVideo($id, $data)
    {
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