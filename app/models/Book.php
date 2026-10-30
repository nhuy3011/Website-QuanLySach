<?php

class Book
{
    private $id;
    private $title;
    private $author;
    private $category_id;
    private $price;
    private $quantity;
    private $description;

    // Hàm khởi tạo đối tượng sách
    public function __construct(
        $id,
        $title,
        $author,
        $category_id,
        $price,
        $quantity,
        $description = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->category_id = $category_id;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->description = $description;
    }

    // Getter: lấy dữ liệu
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getDescription()
    {
        return $this->description;
    }

    // Setter: thay đổi dữ liệu
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
}

?>