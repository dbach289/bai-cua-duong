<?php
require_once '../app/models/StudentModel.php';

class StudentController {
    private $model;

    public function __construct() {
        $this->model = new StudentModel();
    }

    public function index() {
        require '../app/views/layout.php';
    }

    public function api() {
        header('Content-Type: application/json');
        $action = $_GET['action'] ?? 'list';

        if ($action === 'list') {
            echo json_encode([
                'success' => true,
                'data' => $this->model->all()
            ]);
        }

        if ($action === 'create') {
            $this->model->create($_POST);
            echo json_encode(['success' => true]);
        }

        if ($action === 'delete') {
            $this->model->delete($_POST['id']);
            echo json_encode(['success' => true]);
        }
    }
}
