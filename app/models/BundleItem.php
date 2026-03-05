<?php
class BundleItem {
    private $id;
    private $bundleId;
    private $productId;

    public function __construct(
        $id = null,
        $bundleId = null,
        $productId = null
    ) {
        $this->id = $id;
        $this->bundleId = $bundleId;
        $this->productId = $productId;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getBundleId() { return $this->bundleId; }
    public function getProductId() { return $this->productId; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setBundleId($bundleId) { $this->bundleId = $bundleId; }
    public function setProductId($productId) { $this->productId = $productId; }
}
