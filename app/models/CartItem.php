<?php
class CartItem {
    private $id;
    private $userId;
    private $productId;
    private $quantity;
    private $addedAt;

    public function __construct(
        $id = null,
        $userId = null,
        $productId = null,
        $quantity = 1,
        $addedAt = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->addedAt = $addedAt ?? date('Y-m-d H:i:s');
    }

    // Getters
    public function getId() { return $this->id; }
    public function getUserId() { return $this->userId; }
    public function getProductId() { return $this->productId; }
    public function getQuantity() { return $this->quantity; }
    public function getAddedAt() { return $this->addedAt; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setUserId($userId) { $this->userId = $userId; }
    public function setProductId($productId) { $this->productId = $productId; }
    public function setQuantity($quantity) { $this->quantity = $quantity; }
    public function setAddedAt($addedAt) { $this->addedAt = $addedAt; }
}
