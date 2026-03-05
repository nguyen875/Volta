<?php
class Discount {
    private $id;
    private $code;
    private $type;
    private $value;
    private $minOrder;
    private $usesRemaining;
    private $expiresAt;

    public function __construct(
        $id = null,
        $code = '',
        $type = 'percent',
        $value = 0.00,
        $minOrder = 0.00,
        $usesRemaining = null,
        $expiresAt = null
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->type = $type;
        $this->value = $value;
        $this->minOrder = $minOrder;
        $this->usesRemaining = $usesRemaining;
        $this->expiresAt = $expiresAt;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getCode() { return $this->code; }
    public function getType() { return $this->type; }
    public function getValue() { return $this->value; }
    public function getMinOrder() { return $this->minOrder; }
    public function getUsesRemaining() { return $this->usesRemaining; }
    public function getExpiresAt() { return $this->expiresAt; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setCode($code) { $this->code = $code; }
    public function setType($type) { $this->type = $type; }
    public function setValue($value) { $this->value = $value; }
    public function setMinOrder($minOrder) { $this->minOrder = $minOrder; }
    public function setUsesRemaining($usesRemaining) { $this->usesRemaining = $usesRemaining; }
    public function setExpiresAt($expiresAt) { $this->expiresAt = $expiresAt; }
}
