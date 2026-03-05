<?php
class Address {
    private $id;
    private $userId;
    private $label;
    private $street;
    private $city;
    private $country;
    private $isDefault;

    public function __construct(
        $id = null,
        $userId = null,
        $label = '',
        $street = '',
        $city = '',
        $country = '',
        $isDefault = false
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->label = $label;
        $this->street = $street;
        $this->city = $city;
        $this->country = $country;
        $this->isDefault = $isDefault;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getUserId() { return $this->userId; }
    public function getLabel() { return $this->label; }
    public function getStreet() { return $this->street; }
    public function getCity() { return $this->city; }
    public function getCountry() { return $this->country; }
    public function getIsDefault() { return $this->isDefault; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setUserId($userId) { $this->userId = $userId; }
    public function setLabel($label) { $this->label = $label; }
    public function setStreet($street) { $this->street = $street; }
    public function setCity($city) { $this->city = $city; }
    public function setCountry($country) { $this->country = $country; }
    public function setIsDefault($isDefault) { $this->isDefault = $isDefault; }
}
