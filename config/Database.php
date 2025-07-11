<?php

/**
 * Database connection class using Singleton pattern
 * Handles database connection and basic operations
 */
class Database {
    private static $instance = null;
    private $connection;
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'catering';
    
    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct() {
        try {
            $this->connection = new mysqli(
                $this->host, 
                $this->username, 
                $this->password, 
                $this->database
            );
            
            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            }
            
            // Set charset to utf8mb4 for better unicode support
            $this->connection->set_charset("utf8mb4");
            
        } catch (Exception $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Get database instance (Singleton pattern)
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Get the mysqli connection
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Prepare and execute a query with parameters
     */
    public function prepare($query) {
        return $this->connection->prepare($query);
    }
    
    /**
     * Execute a simple query
     */
    public function query($query) {
        return $this->connection->query($query);
    }
    
    /**
     * Get last inserted ID
     */
    public function getLastInsertId() {
        return $this->connection->insert_id;
    }
    
    /**
     * Get connection error
     */
    public function getError() {
        return $this->connection->error;
    }
    
    /**
     * Escape string for safe SQL
     */
    public function escapeString($string) {
        return $this->connection->real_escape_string($string);
    }
    
    /**
     * Start transaction
     */
    public function beginTransaction() {
        return $this->connection->autocommit(false);
    }
    
    /**
     * Commit transaction
     */
    public function commit() {
        $result = $this->connection->commit();
        $this->connection->autocommit(true);
        return $result;
    }
    
    /**
     * Rollback transaction
     */
    public function rollback() {
        $result = $this->connection->rollback();
        $this->connection->autocommit(true);
        return $result;
    }
    
    /**
     * Close connection
     */
    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
    
    /**
     * Prevent cloning of the instance
     */
    public function __clone() {
        throw new Exception("Cannot clone singleton Database instance");
    }
    
    /**
     * Prevent unserialization of the instance
     */
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton Database instance");
    }
}

?> 