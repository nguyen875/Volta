<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Product.php';

class ProductDAO {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    // CREATE
    public function create(Product $product) {
        $sql = "INSERT INTO PRODUCT (ProductName, Description, Price, DiscountRate, Quantity, Publisher, 
                Size, PageNum, Category, Keywords, Format, Author, Language, YearOfPublication, Status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $product->getProductName(),
            $product->getDescription(),
            $product->getPrice(),
            $product->getDiscountRate(),
            $product->getQuantity(),
            $product->getPublisher(),
            $product->getSize(),
            $product->getPageNum(),
            $product->getCategory(),
            $product->getKeywords(),
            $product->getFormat(),
            $product->getAuthor(),
            $product->getLanguage(),
            $product->getYearOfPublication(),
            $product->getStatus()
        ]);
        
        // Get last inserted ID
        return $this->db->lastInsertId();
    }
    
    // READ ALL
    public function getAll($search = '', $limit = null, $offset = 0) {
        $sql = "SELECT * FROM PRODUCT WHERE Status != 'Deleted'";
        
        // Add search condition if search term provided
        if (!empty($search)) {
            $sql .= " AND (ProductName LIKE :search OR Author LIKE :search OR Description LIKE :search)";
        }
        
        $sql .= " ORDER BY Product_ID DESC";
        
        // Add pagination if limit is set
        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }
        
        $stmt = $this->db->prepare($sql);
        
        if (!empty($search)) {
            $searchTerm = "%{$search}%";
            $stmt->bindValue(':search', $searchTerm);
        } 
        
        if ($limit !== null) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        
        foreach ($result as $row) {
            $products[] = new Product(
                $row['Product_ID'],
                $row['ProductName'],
                $row['Description'],
                $row['Price'],
                $row['DiscountRate'],
                $row['Quantity'],
                $row['Publisher'],
                $row['Size'],
                $row['PageNum'],
                $row['Category'],
                $row['Keywords'],
                $row['Format'],
                $row['Author'],
                $row['Language'],
                $row['YearOfPublication'],
                $row['Status']
            );
        }
        return $products;
    }
    
    // Get total count for pagination
    public function getTotalCount($search = '') {
        $sql = "SELECT COUNT(*) as total FROM `PRODUCT` WHERE `Status` = 'Available'";
        
        if (!empty($search)) {
            $sql .= " AND (`ProductName` LIKE :search OR `Author` LIKE :search OR `Category` LIKE :search)";
        }
        
        $stmt = $this->db->prepare($sql);
        
        if (!empty($search)) {
            $searchParam = "%{$search}%";
            $stmt->execute([':search' => $searchParam]);
        } else {
            $stmt->execute();
        }
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'];
    }

    // READ ONE
    public function getById($id) {
        $sql = "SELECT * FROM PRODUCT WHERE Product_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return new Product(
                $result['Product_ID'],
                $result['ProductName'],
                $result['Description'],
                $result['Price'],
                $result['DiscountRate'],
                $result['Quantity'],
                $result['Publisher'],
                $result['Size'],
                $result['PageNum'],
                $result['Category'],
                $result['Keywords'],
                $result['Format'],
                $result['Author'],
                $result['Language'],
                $result['YearOfPublication'],
                $result['Status']
            );
        }
        return null;
    }
    
    // UPDATE
    public function update(Product $product) {
        try {
            $sql = "UPDATE PRODUCT SET 
                    ProductName = ?, Description = ?, Price = ?, DiscountRate = ?, Quantity = ?, 
                    Publisher = ?, Size = ?, PageNum = ?, Category = ?, Keywords = ?, Format = ?, 
                    Author = ?, Language = ?, YearOfPublication = ?, Status = ? 
                    WHERE Product_ID = ?";
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $product->getProductName(),
                $product->getDescription(),
                $product->getPrice(),
                $product->getDiscountRate(),
                $product->getQuantity(),
                $product->getPublisher(),
                $product->getSize(),
                $product->getPageNum(),
                $product->getCategory(),
                $product->getKeywords(),
                $product->getFormat(),
                $product->getAuthor(),
                $product->getLanguage(),
                $product->getYearOfPublication(),
                $product->getStatus(),
                $product->getId()
            ]);
            
            return $result;
        } catch (Exception $e) {
            error_log("ProductDAO update error: " . $e->getMessage());
            return false;
        }
    }
    
    // DELETE (Soft delete)
    public function delete($id) {
        try {
            $sql = "UPDATE PRODUCT SET Status = 'Deleted' WHERE Product_ID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("ProductDAO delete error: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Get last inserted product ID
     */
    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }
    
    /**
     * Add image to product
     */
    public function addImage($productId, $imagePath) {
        try {
            $sql = "INSERT INTO IMAGE (Product_ID, ImageUrl) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$productId, $imagePath]);
        } catch (Exception $e) {
            error_log("ProductDAO addImage error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get first image of a product
     */
    public function getFirstImage($productId) {
        try {
            $sql = "SELECT ImageUrl FROM IMAGE WHERE Product_ID = ? ORDER BY Image_ID ASC LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$productId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['ImageUrl'] : null;
        } catch (Exception $e) {
            error_log("getFirstImage error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get product images
     */
    public function getProductImages($productId) {
        try {
            $sql = "SELECT Image_ID as id, ImageUrl as path FROM IMAGE WHERE Product_ID = ? ORDER BY Image_ID ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$productId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("getProductImages error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Delete image
     */
    public function deleteImage($imageId) {
        try {
            $sql = "SELECT ImageUrl FROM IMAGE WHERE Image_ID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$imageId]);
            $image = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($image) {
                $sql = "DELETE FROM IMAGE WHERE Image_ID = ?";
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute([$imageId]);
                
                if ($result) {
                    $filePath = __DIR__ . '/../../' . $image['ImageUrl'];
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
                
                return $result;
            }
            
            return false;
        } catch (Exception $e) {
            error_log("deleteImage error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Set primary image
     */
    public function setPrimaryImage($productId, $imageId) {
        // Placeholder - can be implemented with is_primary column
        return true;
    }
}
