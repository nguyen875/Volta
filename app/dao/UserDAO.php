<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserDAO {
    private $db;
    
    public function __construct() {
        $this->db = getDB(); // PDO instance
    }
    
    // CREATE
    public function create(User $user) {
        $sql = "INSERT INTO LOGIN (Name, Email, Password, Role) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $user->getUsername(),
            $user->getEmail(),
            password_hash($user->getPassword(), PASSWORD_DEFAULT),
            $user->getRole()
        ]);
    }
    
    // READ - Get all users with pagination and search
    public function getAll($search = '', $limit = null, $offset = 0) {
        $sql = "SELECT * FROM LOGIN";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " WHERE (Name LIKE :search OR Email LIKE :search)";
            $params[':search'] = "%{$search}%";
        }

        $sql .= " ORDER BY UID DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        if ($limit !== null) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        
        foreach ($result as $row) {
            $users[] = new User(
                $row['UID'],
                $row['Name'],
                $row['Email'],
                $row['Role']
            );
        }
        return $users;
    }

    // Get total count for pagination
    public function getTotalCount($search = '') {
        $sql = "SELECT COUNT(*) as total FROM LOGIN";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " WHERE (Name LIKE :search OR Email LIKE :search)";
            $params[':search'] = "%{$search}%";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return (int)$row['total'];
    }
    
    // READ - Get by ID
    public function getById($id) {
        $sql = "SELECT * FROM LOGIN WHERE UID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            return new User(
                $row['UID'],
                $row['Name'],
                $row['Email'],
                $row['Role']
            );
        }
        return null;
    }
    
    // UPDATE
    public function update(User $user) {
        $sql = "UPDATE LOGIN SET Name = ?, Email = ?, Role = ? WHERE UID = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $user->getUsername(),
            $user->getEmail(),
            $user->getRole(),
            $user->getId()
        ]);
    }
    
    // DELETE
    public function delete($id) {
        try {
            // Delete from ADMIN table if exists
            $sql = "DELETE FROM ADMIN WHERE UID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            
            // Delete from CUSTOMER table if exists
            $sql = "DELETE FROM CUSTOMER WHERE UID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            
            // Delete from LOGIN table
            $sql = "DELETE FROM LOGIN WHERE UID = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
            
        } catch (Exception $e) {
            error_log("UserDAO delete error: " . $e->getMessage());
            throw $e;
        }
    }
}