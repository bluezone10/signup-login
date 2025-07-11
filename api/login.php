<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/BaseAPI.php';
session_start();
/**
 * Login API endpoint
 * Handles user authentication with proper validation and response
 */
class LoginAPI extends BaseAPI {
    
    /**
     * Handle login request
     */
    public function handleLogin() {
        try {
            // Only accept POST requests
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->sendResponse(false, 'Method not allowed', [], 405);
            }
            
            // Get input data
            $input = $this->getInputData();
            
            // Get and validate input
            $email = strtolower(trim($input['email'] ?? ''));
            $password = $input['password'] ?? '';
            $rememberMe = isset($input['rememberMe']) && $input['rememberMe'];
            
            // Basic validation
            if (empty($email)) {
                $this->sendResponse(false, 'Email address is required', [], 400);
            }
            
            if (empty($password)) {
                $this->sendResponse(false, 'Password is required', [], 400);
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->sendResponse(false, 'Please enter a valid email address', [], 400);
            }
            
            // Rate limiting for login attempts
            $this->rateLimit($email, 5, 900); // 5 attempts per 15 minutes
            
            // Create user instance and find by email
            $user = new User();
            
            if (!$user->findByEmail($email)) {
                $this->sendResponse(false, 'Invalid email or password', [], 401);
            }
            
            // Check if user account is active
            if ($user->status !== 'active') {
                $this->sendResponse(false, 'Your account has been suspended. Please contact support.', [], 403);
            }
            
            // Verify password
            if (!$user->verifyPassword($password)) {
                $this->sendResponse(false, 'Invalid email or password', [], 401);
            }
            
            // Update last login time
            $user->updateLastLogin();
            
            // Start session
          
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_name'] = $user->getFullName();
            $_SESSION['login_time'] = time();
            
            // Set remember me cookie if requested
            if ($rememberMe) {
                $cookieValue = base64_encode($user->id . ':' . hash('sha256', $user->email . $user->password));
                setcookie('remember_user', $cookieValue, time() + (30 * 24 * 60 * 60), '/', '', false, true); // 30 days
            }
            
            // Log successful login
            $this->logRequest('login_success', [
                'user_id' => $user->id,
                'email' => $user->email,
                'remember_me' => $rememberMe
            ]);
            
            // Return success response
            $this->sendResponse(true, 'Welcome back, ' . $user->firstName . '!', [
                'user' => [
                    'id' => $user->id,
                    'fullName' => $user->getFullName(),
                    'email' => $user->email,
                    'emailVerified' => $user->emailVerified
                ],
                'redirect' => 'main/dashboard.php',
                'session' => [
                    'started' => true,
                    'remember_me' => $rememberMe
                ]
            ], 200);
            
        } catch (Exception $e) {
            error_log("Login API error: " . $e->getMessage());
            $this->sendResponse(false, 'An internal error occurred. Please try again later.', [], 500);
        }
    }
    
    /**
     * Handle logout request
     */
    public function handleLogout() {
        try {
      
            // Log logout attempt
            $userId = $_SESSION['user_id'] ?? 'unknown';
            $this->logRequest('logout', ['user_id' => $userId]);
            
            // Clear session
            session_unset();
            session_destroy();
            
            // Clear remember me cookie
            if (isset($_COOKIE['remember_user'])) {
                setcookie('remember_user', '', time() - 3600, '/', '', false, true);
            }
            
            $this->sendResponse(true, 'You have been successfully logged out', [
                'redirect' => 'index.php'
            ]);
            
        } catch (Exception $e) {
            error_log("Logout API error: " . $e->getMessage());
            $this->sendResponse(false, 'An error occurred during logout', [], 500);
        }
    }
    
    /**
     * Check if user is authenticated
     */
    public function handleAuthCheck() {
        try {
          
            if (isset($_SESSION['user_id'])) {
                $user = new User();
                if ($user->findById($_SESSION['user_id'])) {
                    $this->sendResponse(true, 'User is authenticated', [
                        'authenticated' => true,
                        'user' => [
                            'id' => $user->id,
                            'fullName' => $user->getFullName(),
                            'email' => $user->email,
                            'emailVerified' => $user->emailVerified
                        ]
                    ]);
                }
            }
            
            $this->sendResponse(false, 'User is not authenticated', [
                'authenticated' => false
            ], 401);
            
        } catch (Exception $e) {
            error_log("Auth check error: " . $e->getMessage());
            $this->sendResponse(false, 'Error checking authentication', [], 500);
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
$api = new LoginAPI();

// Route based on action parameter
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'login':
    case '':
        $api->handleLogin();
        break;
    case 'logout':
        $api->handleLogout();
        break;
    case 'check_auth':
        $api->handleAuthCheck();
        break;
    default:
        $api->handleInvalidAction();
}

?> 