<?php
class Book
{
    /*
    Class Book
    - Mục đích: mô tả một cuốn sách với id, title và số lượng (qty).
    - Thuộc tính private:
        $id    : mã sách (ví dụ 'B001')
        $title : tiêu đề sách
        $qty   : số lượng bản hiện có (số nguyên)
    - Constructor: truyền id, title, qty. qty được ép kiểu thành int.
    - Getter: getId(), getTitle(), getQty().
    - Method isAvailable(): trả về true nếu qty > 0 (Available), false nếu qty == 0 (Out of stock).
    - Sử dụng: tạo new Book('B001','Title',2) và gọi các getter để hiển thị.
    */
    private $id;
    private $title;
    private $qty;

    public function __construct($id, $title, $qty)
    {
        $this->id = $id;
        $this->title = $title;
        $this->qty = (int)$qty;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getQty()
    {
        return $this->qty;
    }

    public function isAvailable()
    {
        return $this->qty > 0;
    }
}


