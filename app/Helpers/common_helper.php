<?php
if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
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

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}

if (!function_exists('time_ago')) {
    function time_ago($time) {
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");

        $now = time();
        $difference = $now - $time;
        $tense = "ago";

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] ago";
    }
}

if (!function_exists('timeElapsedString')) {
    function timeElapsedString($datetime, $full = false)
    {
        $now = new \DateTime;
        $ago = new \DateTime('@' . $datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];

        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}

function shortNumber($num)
{
    if ($num >= 1000000000) {
        return round($num / 1000000000, 1) . 'B';
    } elseif ($num >= 1000000) {
        return round($num / 1000000, 1) . 'M';
    } elseif ($num >= 1000) {
        return round($num / 1000, 1) . 'K';
    }

    return $num;
}

function format_price($price)
{
    // Convert to float
    $price = floatval($price);

    // Round to 1 decimal
    $rounded = round($price, 1);

    // Remove trailing .0 if whole number
    if (intval($rounded) == $rounded) {
        return intval($rounded);
    }

    return $rounded;
}

if (!function_exists('short_text')) {
    function short_text(string $text, int $limit = 20, string $end = '...'): string
    {
        $text = strip_tags($text);

        if (str_word_count($text) <= $limit) {
            return $text;
        }

        $words = explode(' ', $text);
        return implode(' ', array_slice($words, 0, $limit)) . $end;
    }
}

if (!function_exists('checkUserKycStatus')) {
    function checkUserKycStatus($userId)
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);
        
        if (!$user) {
            return false;
        }
        
        $currentDate = date('Y-m-d');
        
        // Check if KYC is completed and still valid
        if ($user['fld_kyc_status'] == 1 && 
            $user['fld_kyc_start_date'] <= $currentDate && 
            $user['fld_kyc_end_date'] >= $currentDate) {
            return true;
        }
        
        return false;
    }
}