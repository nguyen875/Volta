<?php
class Product {
    private $id;
    private $categoryId;
    private $name;
    private $slug;
    private $description;
    private $price;
    private $stock;
    private $badge;
    private $isActive;
    private $createdAt;

    public function __construct(
        $id = null,
        $categoryId = null,
        $name = '',
        $slug = '',
        $description = '',
        $price = 0.00,
        $stock = 0,
        $badge = 'none',
        $isActive = true,
        $createdAt = null
    ) {
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->slug = $slug;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->badge = $badge;
        $this->isActive = $isActive;
        $this->createdAt = $createdAt ?? date('Y-m-d H:i:s');
    }

    // Getters
    public function getId() { return $this->id; }
    public function getCategoryId() { return $this->categoryId; }
    public function getName() { return $this->name; }
    public function getSlug() { return $this->slug; }
    public function getDescription() { return $this->description; }
    public function getPrice() { return $this->price; }
    public function getStock() { return $this->stock; }
    public function getBadge() { return $this->badge; }
    public function getIsActive() { return $this->isActive; }
    public function getCreatedAt() { return $this->createdAt; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setCategoryId($categoryId) { $this->categoryId = $categoryId; }
    public function setName($name) { $this->name = $name; }
    public function setSlug($slug) { $this->slug = $slug; }
    public function setDescription($description) { $this->description = $description; }
    public function setPrice($price) { $this->price = $price; }
    public function setStock($stock) { $this->stock = $stock; }
    public function setBadge($badge) { $this->badge = $badge; }
    public function setIsActive($isActive) { $this->isActive = $isActive; }
    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }
}
