<?php

namespace App\Services;

use CodeIgniter\I18n\Time;

class LoggerService
{
    protected $logFile;
    protected $errorLogFile;
    
    public function __construct()
    {
        $this->logFile = WRITEPATH . 'logs/auth_debug_' . date('Y-m-d') . '.log';
        $this->errorLogFile = WRITEPATH . 'logs/auth_errors_' . date('Y-m-d') . '.log';
    }
    
    public function logAuthAttempt($data)
    {
        $logEntry = [
            'timestamp' => Time::now()->toDateTimeString(),
            'type' => 'auth_attempt',
            'data' => $data
        ];
        
        $this->writeLog($this->logFile, $logEntry);
    }
    
    public function logError($message, $context = [], $exception = null)
    {
        $logEntry = [
            'timestamp' => Time::now()->toDateTimeString(),
            'type' => 'error',
            'message' => $message,
            'context' => $context,
            'exception' => $exception ? [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString()
            ] : null
        ];
        
        $this->writeLog($this->errorLogFile, $logEntry);
        
        // Also log to CI's default log
        log_message('error', $message, $context);
    }
    
    public function logDatabaseQuery($query, $params = [], $executionTime = null)
    {
        $logEntry = [
            'timestamp' => Time::now()->toDateTimeString(),
            'type' => 'database',
            'query' => $query,
            'params' => $params,
            'execution_time' => $executionTime
        ];
        
        $this->writeLog($this->logFile, $logEntry);
    }
    
    public function logEmailAttempt($to, $subject, $success, $error = null)
    {
        $logEntry = [
            'timestamp' => Time::now()->toDateTimeString(),
            'type' => 'email',
            'to' => $to,
            'subject' => $subject,
            'success' => $success,
            'error' => $error
        ];
        
        $this->writeLog($this->logFile, $logEntry);
    }
    
    private function writeLog($file, $data)
    {
        $logLine = json_encode($data) . "\n";
        file_put_contents($file, $logLine, FILE_APPEND | LOCK_EX);
    }
    
    public function getRecentErrors($limit = 50)
    {
        if (!file_exists($this->errorLogFile)) {
            return [];
        }
        
        $lines = array_slice(file($this->errorLogFile, FILE_IGNORE_NEW_LINES), -$limit);
        $errors = [];
        
        foreach ($lines as $line) {
            $error = json_decode($line, true);
            if ($error) {
                $errors[] = $error;
            }
        }
        
        return array_reverse($errors);
    }
}