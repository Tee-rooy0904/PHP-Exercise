<?php
include_once '../Model/faculty_model.php';
include(__DIR__ . '/../db.php');

class FacultyController {
    private $model;

    public function __construct($db) {
        $this->model = new FacultyModel($db);
    }

    public function createFaculty($data) {
        if ($this->validateInput($data)) {
            return $this->model->create(...$data);
        }
        return false;
    }

    // Add this method
    private function validateInput($data) {
        return !empty($data) && 
               is_array($data) && 
               count($data) === 8;  // We expect 8 fields
    }

    // Add these methods
    public function updateFaculty($data) {
        if (count($data) === 9) { // 9 fields including ID
            return $this->model->update(...$data);
        }
        return false;
    }

    public function deleteFaculty($id) {
        return $this->model->delete($id);
    }

    public function getFaculties() {
        return $this->model->read();
    }
}

// Initialize controller
$controller = new FacultyController($conn);

// Get all faculties for display
$faculties = $controller->getFaculties();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'create') {
        $controller->createFaculty([
            $_POST['first_name'],
            $_POST['middle_name'],
            $_POST['last_name'],
            $_POST['age'],
            $_POST['gender'],
            $_POST['address'],
            $_POST['position'],
            $_POST['salary']
        ]);
        header('Location: ../View/faculty_view.php');
        exit();
    } elseif ($_POST['action'] == 'update') {
        $controller->updateFaculty([$_POST['id'], $_POST['first_name'], $_POST['middle_name'], $_POST['last_name'], $_POST['age'], $_POST['gender'], $_POST['address'], $_POST['position'], $_POST['salary']]);
        header('Location: ../View/faculty_view.php');
        exit();
    }
}

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'delete' && isset($_GET['id'])) {
        $controller->deleteFaculty($_GET['id']);
        header("Location: ../View/faculty_view.php");
        exit();
    }
    // Add other actions here if needed
}

// Remove this line to prevent duplicate rendering
// include('../View/faculty_view.php');
?>