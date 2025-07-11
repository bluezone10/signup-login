<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/BaseAPI.php';

/**
 * Signup API endpoint
 * Handles user registration with proper validation and response
 */
class SignupAPI extends BaseAPI {
    

    
    /**
     * Handle signup request
     */
    public function handleSignup() {
        try {
            // Only accept POST requests
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->sendResponse(false, 'Method not allowed', [], 405);
            }
            
            // Get input data
            $input = $this->getInputData();
            
            // Create user instance
            $user = new User();
            
            // Set user properties
            $user->firstName = trim($input['firstName'] ?? '');
            $user->lastName = trim($input['lastName'] ?? '');
            $user->email = strtolower(trim($input['email'] ?? ''));
            $user->phone = preg_replace('/\D/', '', $input['phone'] ?? ''); // Clean phone number
            $user->password = $input['password'] ?? '';
            
            // Validate user data
            $validationErrors = $user->validate();
            if (!empty($validationErrors)) {
                $this->sendResponse(false, implode(', ', $validationErrors), [], 400);
            }
            
            // Check if email already exists
            if ($user->emailExists($user->email)) {
                $this->sendResponse(false, 'Email address is already registered', [], 409);
            }
            
            // Create user
            if ($user->create()) {
                // Start session for auto-login
                session_start();
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_name'] = $user->getFullName();
                $_SESSION['login_time'] = time();
                
                // Return success response
                $this->sendResponse(true, 'Account created successfully! Welcome to our catering service.', [
                    'user' => [
                        'id' => $user->id,
                        'fullName' => $user->getFullName(),
                        'email' => $user->email
                    ],
                    'redirect' => 'index.php'
                ], 201);
                
            } else {
                $this->sendResponse(false, 'Failed to create account. Please try again.', [], 500);
            }
            
        } catch (Exception $e) {
            error_log("Signup API error: " . $e->getMessage());
            $this->sendResponse(false, 'An internal error occurred. Please try again later.', [], 500);
        }
    }
    
    /**
     * Handle email check request
     */
    public function handleEmailCheck() {
        try {
            $input = $this->getInputData();
            $email = strtolower(trim($input['email'] ?? ''));
            
            if (empty($email)) {
                $this->sendResponse(false, 'Email is required', [], 400);
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->sendResponse(false, 'Invalid email format', [], 400);
            }
            
            $user = new User();
            $exists = $user->emailExists($email);
            
            $this->sendResponse(true, '', ['exists' => $exists]);
            
        } catch (Exception $e) {
            error_log("Email check API error: " . $e->getMessage());
            $this->sendResponse(false, 'An error occurred while checking email', [], 500);
        }
    }
    
    /**
     * Handle invalid action request
     */
    public function handleInvalidAction() {
        $this->sendResponse(false, 'Invalid action specified', [], 400);
    }

}

// Handle the request
$api = new SignupAPI();

// Route based on action parameter
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'check_email':
        $api->handleEmailCheck();
        break;
    case 'signup':
    case '':
        $api->handleSignup();
        break;
    default:
        $api->handleInvalidAction();
}

?> 