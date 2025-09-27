<?php
// filepath: e:\visual code\php-training\sources\training-php\delete_user.php
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();

$error = '';

if (!empty($_GET['id']) && !empty($_GET['csrf_token'])) {
    $id = $_GET['id'];
    // Kiểm tra CSRF token
    if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_GET['csrf_token'])) {
        // Thử xóa user, kiểm tra kết quả
        if ($userModel->deleteUserById($id)) {
            header('location: list_users.php?success=1');
            exit;
        } else {
            $error = 'Xóa không thành công!';
        }
    } else {
        $error = 'CSRF token không hợp lệ!';
    }
} else {
    $error = 'Thiếu thông tin xóa!';
}

if ($error !== '') {
    // Hiển thị lỗi trực tiếp trên trang
    echo "<h3 style='color:red;'>$error</h3>";
    echo "<a href='list_users.php'>Quay lại danh sách</a>";
    exit;
}

header('location: list_users.php');
?>