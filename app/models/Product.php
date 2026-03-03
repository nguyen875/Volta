<?php
class Product {
    private $id;
    private $productName;
    private $description;
    private $price;
    private $discountRate;
    private $quantity;
    private $publisher;
    private $size;
    private $pageNum;
    private $category;
    private $keywords;
    private $format;
    private $author;
    private $language;
    private $yearOfPublication;
    private $status;
    
    public function __construct($id = null, $productName = '', $description = '', $price = 0, 
                                $discountRate = 0, $quantity = 0, $publisher = '', 
                                $size = '', $pageNum = 0, $category = '', 
                                $keywords = '', $format = '', $author = '', 
                                $language = '', $yearOfPublication = 0, $status = 'Available') {
        $this->id = $id;
        $this->productName = $productName;
        $this->description = $description;
        $this->price = $price;
        $this->discountRate = $discountRate;
        $this->quantity = $quantity;
        $this->publisher = $publisher;
        $this->size = $size;
        $this->pageNum = $pageNum;
        $this->category = $category;
        $this->keywords = $keywords;
        $this->format = $format;
        $this->author = $author;
        $this->language = $language;
        $this->yearOfPublication = $yearOfPublication;
        $this->status = $status;
    }
    
    // Getters
    public function getId() { return $this->id; }
    public function getProductName() { return $this->productName; }
    public function getDescription() { return $this->description; }
    public function getPrice() { return $this->price; }
    public function getDiscountRate() { return $this->discountRate; }
    public function getQuantity() { return $this->quantity; }
    public function getPublisher() { return $this->publisher; }
    public function getSize() { return $this->size; }
    public function getPageNum() { return $this->pageNum; }
    public function getCategory() { return $this->category; }
    public function getKeywords() { return $this->keywords; }
    public function getFormat() { return $this->format; }
    public function getAuthor() { return $this->author; }
    public function getLanguage() { return $this->language; }
    public function getYearOfPublication() { return $this->yearOfPublication; }
    public function getStatus() { return $this->status; }
    
    // Setters
    public function setId($id) { $this->id = $id; }
    public function setProductName($productName) { $this->productName = $productName; }
    public function setDescription($description) { $this->description = $description; }
    public function setPrice($price) { $this->price = $price; }
    public function setDiscountRate($discountRate) { $this->discountRate = $discountRate; }
    public function setQuantity($quantity) { $this->quantity = $quantity; }
    public function setPublisher($publisher) { $this->publisher = $publisher; }
    public function setSize($size) { $this->size = $size; }
    public function setPageNum($pageNum) { $this->pageNum = $pageNum; }
    public function setCategory($category) { $this->category = $category; }
    public function setKeywords($keywords) { $this->keywords = $keywords; }
    public function setFormat($format) { $this->format = $format; }
    public function setAuthor($author) { $this->author = $author; }
    public function setLanguage($language) { $this->language = $language; }
    public function setYearOfPublication($yearOfPublication) { $this->yearOfPublication = $yearOfPublication; }
    public function setStatus($status) { $this->status = $status; }
}
