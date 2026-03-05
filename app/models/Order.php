<?php
class Order {
    private $id;
    private $userId;
    private $addressId;
    private $status;
    private $totalPrice;
    private $createdAt;

    public function __construct(
        $id = null,
        $userId = null,
        $addressId = null,
        $status = 'pending',
        $totalPrice = 0.00,
        $createdAt = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->addressId = $addressId;
        $this->status = $status;
        $this->totalPrice = $totalPrice;
        $this->createdAt = $createdAt ?? date('Y-m-d H:i:s');
    }

    // Getters
    public function getId() { return $this->id; }
    public function getUserId() { return $this->userId; }
    public function getAddressId() { return $this->addressId; }
    public function getStatus() { return $this->status; }
    public function getTotalPrice() { return $this->totalPrice; }
    public function getCreatedAt() { return $this->createdAt; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setUserId($userId) { $this->userId = $userId; }
    public function setAddressId($addressId) { $this->addressId = $addressId; }
    public function setStatus($status) { $this->status = $status; }
    public function setTotalPrice($totalPrice) { $this->totalPrice = $totalPrice; }
    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }
}
