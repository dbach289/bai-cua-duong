<?php
class Student
{
    /*
    Class Student
    - Mục đích: biểu diễn một sinh viên đơn lẻ với các thuộc tính id, name, gpa.
    - Thuộc tính private:
        $id   : mã sinh viên (ví dụ 'SV001')
        $name : tên sinh viên (ví dụ 'Nguyễn Văn A')
        $gpa  : điểm trung bình (số thực)
    - Constructor: truyền vào id, name, gpa.
    - Getter: getId(), getName(), getGpa() để lấy giá trị các thuộc tính.
    - Method rank(): trả về xếp loại theo quy tắc:
        GPA >= 3.2 -> 'Giỏi'
        GPA >= 2.5 -> 'Khá'
        Ngược lại   -> 'Trung bình'
    - Sử dụng: tạo đối tượng new Student('SV001','Name',3.2) và gọi các getter hoặc rank().
    */
    private $id;
    private $name;
    private $gpa;

    public function __construct($id, $name, $gpa)
    {
        $this->id = $id;
        $this->name = $name;
        $this->gpa = (float)$gpa;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getGpa()
    {
        return $this->gpa;
    }

    // Xếp loại theo đề bài
    public function rank()
    {
        if ($this->gpa >= 3.2) {
            return 'Giỏi';
        } elseif ($this->gpa >= 2.5) {
            return 'Khá';
        }
        return 'Trung bình';
    }
}


