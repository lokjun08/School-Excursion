<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    // Fetch approved excursions
    if ($action === 'fetch') {
        $sql = "SELECT excursions.*, teachers.name AS teacher_name FROM excursions 
                LEFT JOIN teachers ON excursions.assigned_teacher_id = teachers.id";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    // Save new or updated excursion
    elseif ($action === 'save') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $location = $_POST['location'];
        $teacher_id = $_POST['teacher_id'];

        if (empty($id)) {
            $stmt = $conn->prepare("INSERT INTO excursions (name, description, type, start_date, end_date, location, assigned_teacher_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssssi', $name, $description, $type, $start_date, $end_date, $location, $teacher_id);
        } else {
            $stmt = $conn->prepare("UPDATE excursions SET name=?, description=?, type=?, start_date=?, end_date=?, location=?, assigned_teacher_id=? WHERE id=?");
            $stmt->bind_param('ssssssii', $name, $description, $type, $start_date, $end_date, $location, $teacher_id, $id);
        }
        $stmt->execute();
        echo 'success';
    }

    // Delete an excursion
    elseif ($action === 'delete') {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM excursions WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        echo 'success';
    }

    // Filter excursions
    elseif ($action === 'filter') {
        $name = $_POST['name'];
        $date = $_POST['date'];
        $teacher = $_POST['teacher'];

        $sql = "SELECT excursions.*, teachers.name AS teacher_name FROM excursions 
                LEFT JOIN teachers ON excursions.assigned_teacher_id = teachers.id WHERE 1=1";

        if (!empty($name)) $sql .= " AND excursions.name LIKE '%$name%'";
        if (!empty($date)) $sql .= " AND excursions.start_date = '$date'";
        if (!empty($teacher)) $sql .= " AND teachers.id = $teacher";

        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    // Fetch pending requests
    elseif ($action === 'fetch_requests') {
        $sql = "SELECT excursion_requests.*, teachers.name AS teacher_name 
                FROM excursion_requests 
                LEFT JOIN teachers ON excursion_requests.teacher_id = teachers.id
                WHERE status = 'Pending'";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    // Approve an excursion request
    elseif ($action === 'approve_request') {
        $request_id = $_POST['id'];

        // Move request to excursions table
        $sql = "INSERT INTO excursions (name, description, type, start_date, end_date, location, assigned_teacher_id)
                SELECT excursion_name, description, type, start_date, end_date, location, teacher_id
                FROM excursion_requests
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $request_id);
        if ($stmt->execute()) {
            // Update request status
            $stmt = $conn->prepare("UPDATE excursion_requests SET status = 'Approved' WHERE id = ?");
            $stmt->bind_param('i', $request_id);
            $stmt->execute();
            echo 'success';
        } else {
            echo 'error';
        }
    }

    // Reject an excursion request
    elseif ($action === 'reject_request') {
        $request_id = $_POST['id'];
        $reason = $_POST['reason'];

        $stmt = $conn->prepare("UPDATE excursion_requests SET status = 'Rejected', rejection_reason = ? WHERE id = ?");
        $stmt->bind_param('si', $reason, $request_id);
        $stmt->execute();

        echo 'success';
    }

    elseif ($action === 'save') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $location = $_POST['location'];
        $teacher_id = $_POST['teacher_id'];
        $students = $_POST['students']; // Array of selected student IDs
    
        // Insert or update excursion
        if (empty($id)) {
            $stmt = $conn->prepare("INSERT INTO excursions (name, description, type, start_date, end_date, location, assigned_teacher_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssssi', $name, $description, $type, $start_date, $end_date, $location, $teacher_id);
            $stmt->execute();
            $excursion_id = $stmt->insert_id; // Get the ID of the newly inserted excursion
        } else {
            $stmt = $conn->prepare("UPDATE excursions SET name=?, description=?, type=?, start_date=?, end_date=?, location=?, assigned_teacher_id=? WHERE id=?");
            $stmt->bind_param('ssssssii', $name, $description, $type, $start_date, $end_date, $location, $teacher_id, $id);
            $stmt->execute();
            $excursion_id = $id; // Use the existing ID for update
        }
    
        // Insert selected students into the excursion_students table
        if (!empty($students)) {
            // Remove previous students if updating
            if (!empty($id)) {
                $stmt = $conn->prepare("DELETE FROM excursion_students WHERE excursion_id = ?");
                $stmt->bind_param('i', $excursion_id);
                $stmt->execute();
            }
    
            // Add new selected students
            $stmt = $conn->prepare("INSERT INTO excursion_students (excursion_id, student_id) VALUES (?, ?)");
            foreach ($students as $student_id) {
                $stmt->bind_param('ii', $excursion_id, $student_id);
                $stmt->execute();
            }
        }
    
        // Save the number of students participating (optional, could be derived from students count)
        $num_participation = count($students);
        $stmt = $conn->prepare("UPDATE excursions SET num_participation = ? WHERE id = ?");
        $stmt->bind_param('ii', $num_participation, $excursion_id);
        $stmt->execute();
    
        echo 'success';
    }
    
}
?>
