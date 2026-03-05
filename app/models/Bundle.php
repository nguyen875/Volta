<?php
class Bundle {
    private $id;
    private $name;
    private $description;
    private $bundlePrice;
    private $isActive;

    public function __construct(
        $id = null,
        $name = '',
        $description = '',
        $bundlePrice = 0.00,
        $isActive = true
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->bundlePrice = $bundlePrice;
        $this->isActive = $isActive;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getBundlePrice() { return $this->bundlePrice; }
    public function getIsActive() { return $this->isActive; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setDescription($description) { $this->description = $description; }
    public function setBundlePrice($bundlePrice) { $this->bundlePrice = $bundlePrice; }
    public function setIsActive($isActive) { $this->isActive = $isActive; }
}
