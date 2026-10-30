
<?php

class Category
{
    // Các thuộc tính tương ứng với cột trong bảng categorys
    private $id;
    private $name;
    private $description;

    // Khởi tạo đối tượng thể loại
    public function __construct($id, $name, $description = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    // Lấy mã thể loại
    public function getId()
    {
        return $this->id;
    }

    // Lấy tên thể loại
    public function getName()
    {
        return $this->name;
    }

    // Lấy mô tả thể loại
    public function getDescription()
    {
        return $this->description;
    }

    // Thay đổi mã thể loại
    public function setId($id)
    {
        $this->id = $id;
    }

    // Thay đổi tên thể loại
    public function setName($name)
    {
        $this->name = $name;
    }

    // Thay đổi mô tả thể loại
    public function setDescription($description)
    {
        $this->description = $description;
    }
}

?>
