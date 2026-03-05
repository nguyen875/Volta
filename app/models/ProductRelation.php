<?php
class ProductRelation {
    private $id;
    private $productId;
    private $relatedId;
    private $type;
    private $discountAmount;
    private $sortOrder;

    public function __construct(
        $id = null,
        $productId = null,
        $relatedId = null,
        $type = 'crosssell',
        $discountAmount = 0.00,
        $sortOrder = 0
    ) {
        $this->id = $id;
        $this->productId = $productId;
        $this->relatedId = $relatedId;
        $this->type = $type;
        $this->discountAmount = $discountAmount;
        $this->sortOrder = $sortOrder;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getProductId() { return $this->productId; }
    public function getRelatedId() { return $this->relatedId; }
    public function getType() { return $this->type; }
    public function getDiscountAmount() { return $this->discountAmount; }
    public function getSortOrder() { return $this->sortOrder; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setProductId($productId) { $this->productId = $productId; }
    public function setRelatedId($relatedId) { $this->relatedId = $relatedId; }
    public function setType($type) { $this->type = $type; }
    public function setDiscountAmount($discountAmount) { $this->discountAmount = $discountAmount; }
    public function setSortOrder($sortOrder) { $this->sortOrder = $sortOrder; }
}
