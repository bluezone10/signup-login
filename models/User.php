<?php

require_once __DIR__ . '/../config/Database.php';

/**
 * User model class
 * Handles all user-related database operations
 */
class User {
    private $db;
    private $table = 'users';
    
    // User properties
    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $password;
    public $emailVerified;
    public $status;
    public $createdAt;
    public $updatedAt;
    public $lastLogin;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Create a new user
     */
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (first_name, last_name, email, phone, password, created_at) 
                  VALUES (?, ?, ?, ?, ?, NOW())";
        
        try {
            $stmt = $this->db->prepare($query);
            
            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $this->db->getError());
            }
            
            // Hash password before storing
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
            
            $stmt->bind_param(
                "sssss",
                $this->firstName,
                $this->lastName,
                $this->email,
                $this->phone,
                $hashedPassword
            );
            
            if ($stmt->execute()) {
                $this->id = $this->db->getLastInsertId();
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                throw new Exception("Failed to create user: " . $stmt->error);
            }
            
        } catch (Exception $e) {
            error_log("User creation error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Find user by email
     */
    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = ? LIMIT 1";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->mapRowToProperties($row);
                $stmt->close();
                return true;
            }
            
            $stmt->close();
            return false;
            
        } catch (Exception $e) {
            error_log("Find user by email error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Find user by ID
     */
    public function findById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->mapRowToProperties($row);
                $stmt->close();
                return true;
            }
            
            $stmt->close();
            return false;
            
        } catch (Exception $e) {
            error_log("Find user by ID error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if email exists
     */
    public function emailExists($email) {
        $query = "SELECT id FROM " . $this->table . " WHERE email = ? LIMIT 1";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $exists = $result->num_rows > 0;
            $stmt->close();
            return $exists;
            
        } catch (Exception $e) {
            error_log("Email exists check error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update user information
     */
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET first_name = ?, last_name = ?, email = ?, phone = ?, updated_at = NOW() 
                  WHERE id = ?";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param(
                "ssssi",
                $this->firstName,
                $this->lastName,
                $this->email,
                $this->phone,
                $this->id
            );
            
            $result = $stmt->execute();
            $stmt->close();
            return $result;
            
        } catch (Exception $e) {
            error_log("User update error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update user password
     */
    public function updatePassword($newPassword) {
        $query = "UPDATE " . $this->table . " SET password = ?, updated_at = NOW() WHERE id = ?";
        
        try {
            $stmt = $this->db->prepare($query);
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt->bind_param("si", $hashedPassword, $this->id);
            
            $result = $stmt->execute();
            $stmt->close();
            return $result;
            
        } catch (Exception $e) {
            error_log("Password update error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verify password
     */
    public function verifyPassword($password) {
        if (!$this->password) {
            return false;
        }
        return password_verify($password, $this->password);
    }
    
    /**
     * Update last login time
     */
    public function updateLastLogin() {
        $query = "UPDATE " . $this->table . " SET last_login = NOW() WHERE id = ?";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $this->id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
            
        } catch (Exception $e) {
            error_log("Last login update error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get user's full name
     */
    public function getFullName() {
        return trim($this->firstName . ' ' . $this->lastName);
    }
    
    /**
     * Get user data as array (excluding password)
     */
    public function toArray($includePassword = false) {
        $data = [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'fullName' => $this->getFullName(),
            'email' => $this->email,
            'phone' => $this->phone,
            'emailVerified' => $this->emailVerified,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'lastLogin' => $this->lastLogin
        ];
        
        if ($includePassword) {
            $data['password'] = $this->password;
        }
        
        return $data;
    }
    
    /**
     * Validate user data
     */
    public function validate() {
        $errors = [];
        
        if (empty($this->firstName) || strlen($this->firstName) < 2) {
            $errors[] = "First name must be at least 2 characters long";
        }
        
        if (empty($this->lastName) || strlen($this->lastName) < 2) {
            $errors[] = "Last name must be at least 2 characters long";
        }
        
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Valid email address is required";
        }
        
        if (empty($this->phone) || strlen(preg_replace('/\D/', '', $this->phone)) < 10) {
            $errors[] = "Valid phone number is required";
        }
        
        if (empty($this->password) || strlen($this->password) < 8) {
            $errors[] = "Password must be at least 8 characters long";
        }
        
        if (!preg_match('/[A-Za-z]/', $this->password) || !preg_match('/[0-9]/', $this->password)) {
            $errors[] = "Password must contain both letters and numbers";
        }
        
        return $errors;
    }
    
    /**
     * Map database row to object properties
     */
    private function mapRowToProperties($row) {
        $this->id = $row['id'];
        $this->firstName = $row['first_name'];
        $this->lastName = $row['last_name'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
        $this->password = $row['password'];
        $this->emailVerified = $row['email_verified'];
        $this->status = $row['status'];
        $this->createdAt = $row['created_at'];
        $this->updatedAt = $row['updated_at'];
        $this->lastLogin = $row['last_login'];
    }
}

?> 