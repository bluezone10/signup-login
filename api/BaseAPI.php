<?php

/**
 * Base API class
 * Provides common functionality for all API endpoints
 */
abstract class BaseAPI {
    
    /**
     * Send JSON response
     */
    protected function sendResponse($success, $message, $data = [], $statusCode = 200) {
        http_response_code($statusCode);
        
        $response = [
            'success' => $success,
            'message' => $message,
            'timestamp' => date('c'),
            'data' => $data
        ];
        
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }
    
    /**
     * Send error response
     */
    protected function sendError($message, $statusCode = 400, $errorCode = null) {
        $data = [];
        if ($errorCode) {
            $data['error_code'] = $errorCode;
        }
        
        $this->sendResponse(false, $message, $data, $statusCode);
    }
    
    /**
     * Send success response
     */
    protected function sendSuccess($message, $data = [], $statusCode = 200) {
        $this->sendResponse(true, $message, $data, $statusCode);
    }
    
    /**
     * Validate HTTP method
     */
    protected function validateMethod($allowedMethods) {
        $method = $_SERVER['REQUEST_METHOD'];
        if (!in_array($method, $allowedMethods)) {
            $this->sendError('Method not allowed', 405);
        }
    }
    
    /**
     * Get input data from request
     */
    protected function getInputData() {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        
        if (strpos($contentType, 'application/json') !== false) {
            // Handle JSON input
            $input = json_decode(file_get_contents('php://input'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->sendError('Invalid JSON format', 400);
            }
            return $input;
        } else {
            // Handle form data
            return $_POST;
        }
    }
    
    /**
     * Validate required fields
     */
    protected function validateRequired($data, $required) {
        $missing = [];
        foreach ($required as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                $missing[] = $field;
            }
        }
        
        if (!empty($missing)) {
            $this->sendError('Missing required fields: ' . implode(', ', $missing), 400);
        }
    }
    
    /**
     * Sanitize string input
     */
    protected function sanitizeString($input) {
        return trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
    }
    
    /**
     * Validate email format
     */
    protected function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Validate phone number
     */
    protected function validatePhone($phone) {
        $cleanPhone = preg_replace('/\D/', '', $phone);
        return strlen($cleanPhone) >= 10;
    }
    
    /**
     * Check if user is authenticated
     */
    protected function requireAuth() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->sendError('Authentication required', 401);
        }
        return $_SESSION['user_id'];
    }
    
    /**
     * Rate limiting (basic implementation)
     */
    protected function rateLimit($identifier, $maxRequests = 60, $timeWindow = 3600) {
        // This is a basic implementation
        // In production, you'd want to use Redis or a database for this
 
        $key = "rate_limit_" . md5($identifier);
        $now = time();
        
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = ['count' => 1, 'start' => $now];
            return true;
        }
        
        $data = $_SESSION[$key];
        
        if ($now - $data['start'] > $timeWindow) {
            // Reset window
            $_SESSION[$key] = ['count' => 1, 'start' => $now];
            return true;
        }
        
        if ($data['count'] >= $maxRequests) {
            $this->sendError('Rate limit exceeded. Please try again later.', 429);
        }
        
        $_SESSION[$key]['count']++;
        return true;
    }
    
    /**
     * Log API request
     */
    protected function logRequest($action, $data = []) {
        $logData = [
            'timestamp' => date('c'),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'method' => $_SERVER['REQUEST_METHOD'],
            'action' => $action,
            'data' => $data
        ];
        
        error_log("API Request: " . json_encode($logData));
    }
}

?> 