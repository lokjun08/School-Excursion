<?php
// Include database connection
include('db_connect.php');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

// Handle actions
$action = $_GET['action'] ?? '';
switch ($action) {
    case 'fetch':
        fetchUsers();
        break;
    case 'filter':
        filterUsers();
        break;
    case 'fetch_single':
        fetchSingleUser();
        break;
    case 'add':
        addUser();
        break;
    case 'edit':
        editUser();
        break;
    case 'delete':
        deleteUser();
        break;
    default:
        echo json_encode(['error' => 'Invalid action']);
        break;
}

// Fetch all users
function fetchUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['users' => $users]);
}

// Filter users based on input
function filterUsers() {
    global $pdo;
    $name = $_GET['name'] ?? '';
    $email = $_GET['email'] ?? '';
    $role = $_GET['role'] ?? '';

    $sql = "SELECT * FROM users WHERE name LIKE :name AND email LIKE :email AND role LIKE :role";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => "%$name%",
        ':email' => "%$email%",
        ':role' => "%$role%"
    ]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['users' => $users]);
}

// Fetch a single user for editing
function fetchSingleUser() {
    global $pdo;
    $id = $_GET['id'] ?? 0;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['user' => $user]);
}

// Add a new user
function addUser() {
    global $pdo;
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'];
    $email = $data['email'];
    $role = $data['role'];
    $password = password_hash('Password123!', PASSWORD_DEFAULT); // Default password

    $stmt = $pdo->prepare("INSERT INTO users (name, email, role, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $role, $password]);

    echo json_encode(['success' => true]);
}

// Edit an existing user
function editUser() {
    global $pdo;
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $name = $data['name'];
    $email = $data['email'];
    $role = $data['role'];

    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->execute([$name, $email, $role, $id]);

    echo json_encode(['success' => true]);
}

// Delete a user
function deleteUser() {
    global $pdo;
    $id = $_GET['id'] ?? 0;
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true]);
}
?>
