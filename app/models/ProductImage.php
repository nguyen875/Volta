<?php
class ProductImage {
    private $id;
    private $productId;
    private $url;
    private $isPrimary;

    public function __construct(
        $id = null,
        $productId = null,
        $url = '',
        $isPrimary = false
    ) {
        $this->id = $id;
        $this->productId = $productId;
        $this->url = $url;
        $this->isPrimary = $isPrimary;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getProductId() { return $this->productId; }
    public function getUrl() { return $this->url; }
    public function getIsPrimary() { return $this->isPrimary; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setProductId($productId) { $this->productId = $productId; }
    public function setUrl($url) { $this->url = $url; }
    public function setIsPrimary($isPrimary) { $this->isPrimary = $isPrimary; }
}
