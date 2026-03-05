<?php
class OrderItem {
    private $id;
    private $orderId;
    private $productId;
    private $quantity;
    private $unitPrice;

    public function __construct(
        $id = null,
        $orderId = null,
        $productId = null,
        $quantity = 1,
        $unitPrice = 0.00
    ) {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getOrderId() { return $this->orderId; }
    public function getProductId() { return $this->productId; }
    public function getQuantity() { return $this->quantity; }
    public function getUnitPrice() { return $this->unitPrice; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setOrderId($orderId) { $this->orderId = $orderId; }
    public function setProductId($productId) { $this->productId = $productId; }
    public function setQuantity($quantity) { $this->quantity = $quantity; }
    public function setUnitPrice($unitPrice) { $this->unitPrice = $unitPrice; }
}
