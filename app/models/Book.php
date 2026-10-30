
<?php

class Book
{
    private $id;
    private $title;
    private $author;
    private $isbn;
    private $publisher;
    private $publish_year;
    private $category_id;
    private $quantity;

    // Khởi tạo đối tượng sách
    public function __construct(
        $id,
        $title,
        $author,
        $isbn,
        $publisher,
        $publish_year,
        $category_id,
        $quantity
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->publisher = $publisher;
        $this->publish_year = $publish_year;
        $this->category_id = $category_id;
        $this->quantity = $quantity;
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

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function getPublisher()
    {
        return $this->publisher;
    }

    public function getPublishYear()
    {
        return $this->publish_year;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    // Setter: thay đổi dữ liệu trong đối tượng
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

    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    }

    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

    public function setPublishYear($publish_year)
    {
        $this->publish_year = $publish_year;
    }

    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
}

?>
