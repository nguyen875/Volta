<?php
class User {
    private $id;
    private $username;
    private $email;
    private $password;
    private $role;
    private $created_at;
    
    // Constructor
    public function __construct($id = null, $username = null, $email = null, $role = 'Customer', $password = null, $created_at = null) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
        // initialize created_at if not provided
        $this->created_at = $created_at ?? date('Y-m-d H:i:s');
    }
    
    // Getters
    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getRole() { return $this->role; }
    public function getCreatedAt() { return $this->created_at; }
    
    // Setters
    public function setId($id) { $this->id = $id; }
    public function setUsername($username) { $this->username = $username; }
    public function setEmail($email) { $this->email = $email; }
    public function setPassword($password) { $this->password = $password; }
    public function setRole($role) { $this->role = $role; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    
    // Find user by email (returns User or null)
    public static function findByEmail($email) {
        require_once __DIR__ . '/../../config/database.php';
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM `LOGIN` WHERE `Email` = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();
        if (!$row) return null;
        $user = new User(
            $row['UID'],
            $row['Name'],
            $row['Email'],
            $row['Role'],
            $row['Password'],
            $row['CreatedAt'] ?? null
        );
        return $user;
    }

    // Create a new customer (returns array ['success'=>bool, 'user'=>User|null, 'error'=>string|null])
    public static function createCustomer($username, $email, $password, $name = null, $avatar = null, $phone = null, $address = null) {
        require_once __DIR__ . '/../../config/database.php';
        $db = getDB();
        try {
            $db->beginTransaction();
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $created_at = date('Y-m-d H:i:s');
            $stmt = $db->prepare("INSERT INTO `LOGIN` (`Email`,`Password`,`Role`,`Name`,`Avatar`,`CreatedAt`) VALUES (:email,:pass,'Customer',:name,:avatar,:created_at)");
            $stmt->execute([
                ':email' => $email,
                ':pass' => $hash,
                ':name' => $username ?? $name ?? $email,
                ':avatar' => $avatar,
                ':created_at' => $created_at
            ]);
            $uid = $db->lastInsertId();
            $stmt2 = $db->prepare("INSERT INTO `CUSTOMER` (`UID`,`PhoneNum`,`Address`) VALUES (:uid,:phone,:addr)");
            $stmt2->execute([':uid' => $uid, ':phone' => $phone, ':addr' => $address]);
            $db->commit();
            $user = new User($uid, $username ?? $name ?? $email, $email, 'Customer', $hash, $created_at);
            return ['success' => true, 'user' => $user, 'error' => null];
        } catch (PDOException $e) {
            $db->rollBack();
            // Unique email constraint or other DB error
            if ($e->getCode() === '23000') {
                return ['success' => false, 'user' => null, 'error' => 'Email already registered'];
            }
            return ['success' => false, 'user' => null, 'error' => $e->getMessage()];
        }
    }
}