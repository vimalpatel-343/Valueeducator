<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public $fromEmail = 'noreply@valueeducator.com';
    public $fromName = 'Value Educator';
    public $recipients = '';
    
    /**
     * The "user agent"
     */
    public $userAgent = 'CodeIgniter';
    
    /**
     * The mail sending protocol: mail, sendmail, smtp
     */
    public $protocol = 'smtp';
    
    /**
     * The server path to Sendmail.
     */
    public $mailPath = '/usr/sbin/sendmail';
    
    /**
     * SMTP Server Address
     */
    public $SMTPHost = 'smtp.example.com';
    
    /**
     * SMTP Username
     */
    public $SMTPUser = 'noreply@valueeducator.com';
    
    /**
     * SMTP Password
     */
    public $SMTPPass = 'your-password';
    
    /**
     * SMTP Port
     */
    public $SMTPPort = 587;
    
    /**
     * SMTP Timeout (in seconds)
     */
    public $SMTPTimeout = 5;
    
    /**
     * Enable persistent SMTP connections
     */
    public $SMTPKeepAlive = false;
    
    /**
     * SMTP Encryption. Either tls or ssl
     */
    public $SMTPCrypto = 'tls';
    
    /**
     * Enable word-wrap
     */
    public $wordWrap = true;
    
    /**
     * Character count to wrap at
     */
    public $wrapChars = 76;
    
    /**
     * Type of mail, either 'text' or 'html'
     */
    public $mailType = 'text';
    
    /**
     * Character set (utf-8, iso-8859-1, etc.)
     */
    public $charset = 'UTF-8';
    
    /**
     * Whether to validate email addresses
     */
    public $validate = true;
    
    /**
     * Email priority. 1 = highest. 5 = lowest. 3 = normal
     */
    public $priority = 3;
    
    /**
     * Newline character. \r\n or \n (Use \r\n for RFC compliance)
     */
    public $CRLF = "\r\n";
    
    /**
     * Newline character. \r\n or \n (Use \r\n for RFC compliance)
     */
    public $newline = "\r\n";
    
    /**
     * Enable BCC Batch Mode.
     */
    public $BCCBatchMode = false;
    
    /**
     * Number of emails in each BCC batch
     */
    public $BCCBatchSize = 200;
    
    /**
     * Enable notify message from server
     */
    public $DSN = false;
}