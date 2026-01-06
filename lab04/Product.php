<?php
class Product
{
    /*
    Class Product
    - Mục đích: mô tả một sản phẩm/bài hàng với id, name, price và qty.
    - Thuộc tính private:
        $id    : mã sản phẩm (ví dụ 'P001')
        $name  : tên sản phẩm
        $price : giá một đơn vị (float)
        $qty   : số lượng (int)
    - Constructor: truyền id, name, price, qty; price ép kiểu float, qty ép kiểu int.
    - Getter: getId(), getName(), getPrice(), getQty().
    - Method amount(): trả về price * qty (tổng tiền của sản phẩm).
    - Sử dụng: tạo new Product('P001','Name',120,2) rồi gọi amount() để tính tổng cho dòng.
    */
    private $id;
    private $name;
    private $price;
    private $qty;

    public function __construct($id, $name, $price, $qty)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = (float)$price;
        $this->qty = (int)$qty;
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getPrice() { return $this->price; }
    public function getQty() { return $this->qty; }
    public function amount() { return $this->price * $this->qty; }
}


