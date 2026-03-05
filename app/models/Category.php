<?php
class Category {
    private $id;
    private $name;
    private $slug;

    public function __construct(
        $id = null,
        $name = '',
        $slug = ''
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getSlug() { return $this->slug; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setSlug($slug) { $this->slug = $slug; }
}
