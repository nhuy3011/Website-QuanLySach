<?php
class BookService {
    private $bookModel;

    public function __construct($bookModel) {
        $this->bookModel = $bookModel;
    }

    public function search($keyword = '') {
        if (empty(trim($keyword))) {
            return $this->bookModel->getAll();
        }
        return $this->bookModel->search($keyword);
    }

    public function filter($categoryId = null) {
        if (empty($categoryId)) {
            return $this->bookModel->getAll();
        }
        return $this->bookModel->filterByCategory($categoryId);
    }
}
?>