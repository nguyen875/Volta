<?php
class User {
    private $id;
    private $email;
    private $passwordHash;
    private $fullName;
    private $phone;
    private $createdAt;

    public function __construct(
        $id = null,
        $email = '',
        $passwordHash = '',
        $fullName = '',
        $phone = '',
        $createdAt = null
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->fullName = $fullName;
        $this->phone = $phone;
        $this->createdAt = $createdAt ?? date('Y-m-d H:i:s');
    }

    // Getters
    public function getId() { return $this->id; }
    public function getEmail() { return $this->email; }
    public function getPasswordHash() { return $this->passwordHash; }
    public function getFullName() { return $this->fullName; }
    public function getPhone() { return $this->phone; }
    public function getCreatedAt() { return $this->createdAt; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setEmail($email) { $this->email = $email; }
    public function setPasswordHash($passwordHash) { $this->passwordHash = $passwordHash; }
    public function setFullName($fullName) { $this->fullName = $fullName; }
    public function setPhone($phone) { $this->phone = $phone; }
    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }
}