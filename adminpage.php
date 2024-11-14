<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Excursion Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="adminpage.css">
</head>
<body>
    
<!-- Top Header -->
<div class="top-header">
    <span class="toggle-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></span>
    <div class="d-flex align-items-center">
        <!-- Search Box -->
        <input type="text" class="form-control me-2 search-input" placeholder="Search Dashboard" onkeyup="searchDashboard()">
        <i class="fas fa-envelope me-3"></i>
        <i class="fas fa-bell me-3"></i>
        <!-- Profile Dropdown -->
        <div class="dropdown">
            <img src="https://via.placeholder.com/30" class="rounded-circle" alt="Profile" id="profilePic" data-bs-toggle="dropdown" aria-expanded="false">
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</a></li>
                <li><a class="dropdown-item" href="#" onclick="logout()">Logout</a></li>
            </ul>
        </div>
        <span id="userName"></span>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editProfileForm" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="userId" name="user_id">
                    <div class="mb-3">
                        <label for="profilePicture" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="profilePicture" name="profile_picture">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>


    <!-- Sidebar -->
    <div id="sidebar" class="bg-light">
        <h5 class="text-center mt-3"><i class="fas fa-school"></i> <span>School</span></h5>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="showSection('dashboard')">
                    <i class="fas fa-tachometer-alt icon"></i><span> Dashboard</span>
                </a>
            </li>
            <a class="nav-link" href="#" onclick="showSection('trips')">
                <i class="fas fa-location-dot icon"></i><span> Trips & Event</span>
            </a>            
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="showSection('document')">
                    <i class="fas fa-file-alt icon"></i><span> Document</span>
                </a>
            </li>
            <li class="nav-item">
    <a class="nav-link" href="#" onclick="toggleCollapse('management-submenu')">
        <i class="fas fa-user-cog icon"></i><span> Management</span>
        <i id="management-arrow" class="fas fa-chevron-down ms-auto"></i> <!-- Arrow icon -->
    </a>
    <ul id="management-submenu" class="nav flex-column ms-3 collapse">
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="showSection('users')">
                <i class="fas fa-users icon"></i><span> Users</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="showSection('class')">
                <i class="fas fa-chalkboard-teacher icon"></i><span> Class</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="showSection('student-data')">
                <i class="fas fa-user-graduate icon"></i><span> Student Data</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="showSection('payment')">
                <i class="fas fa-wallet icon"></i><span> Payment</span>
            </a>
        </li>
    </ul>
</li>

            <li class="nav-item">
                <a class="nav-link" href="#" onclick="showSection('calendar')">
                    <i class="fas fa-calendar icon"></i><span> Calendar</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="showSection('chart')">
                    <i class="fas fa-chart-bar icon"></i><span> Chart & Report</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="showSection('settings')">
                    <i class="fas fa-cog icon"></i><span> Settings</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="logout()">
                    <i class="fas fa-sign-out-alt icon"></i><span> Logout</span>
                </a>
            </li>
        </ul>
    </div>


    <!-- Main Content -->
    <div id="main-content" class="container-fluid">
        <!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editProfileForm" method="POST" action="update_profile.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Hidden field to store user ID -->
          <input type="hidden" name="user_id" id="user_id" value="<?php echo $userId; ?>">

          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <!-- Add more fields as necessary -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>

       <!-- Dashboard Section -->
 <div id="dashboard" class="content-section active">
    <div class="row mt-4 card-container">
         <!-- Cards for Key Stats -->
         <div class="col-md-3">
             <div class="card card-stat bg-purple">
                 <h5><i class="fas fa-bus"></i> Total Excursions</h5>
                 <h3>25</h3>
                 <p>Jan - Dec 2024</p>
             </div>
         </div>
         <div class="col-md-3">
             <div class="card card-stat bg-pink">
                 <h5><i class="fas fa-users"></i> Students Participated</h5>
                 <h3>1200</h3>
                 <p>Jan - Dec 2024</p>
             </div>
         </div>
         <div class="col-md-3">
             <div class="card card-stat bg-orange">
                 <h5><i class="fas fa-check-circle"></i> Parental Approvals</h5>
                 <h3>1100</h3>
                 <p>Jan - Dec 2024</p>
             </div>
         </div>
         <div class="col-md-3">
             <div class="card card-stat bg-blue">
                 <h5><i class="fas fa-thumbs-up"></i> Feedback</h5>
                 <h3>98%</h3>
                 <p>Overall Satisfaction</p>
             </div>
         </div>
     </div>

     <!-- Monthly Overview and Upcoming Excursions -->
     <div class="row">
         <div class="col-md-6">
             <div class="card">
                 <div class="card-body">
                     <h5><i class="fas fa-chart-line"></i> Participation Over Time</h5>
                     <p>Total Excursions by Month</p>
                     <canvas id="monthlyOverviewChart" style="height: 250px;"></canvas> <!-- Dynamic Chart -->
                 </div>
             </div>
         </div>
         <div class="col-md-6">
             <div class="card">
                 <div class="card-body">
                     <h5><i class="fas fa-calendar-alt"></i> Upcoming Excursions</h5>
                     <div class="row">
                         <div class="col-8">
                             <h6><strong>Science Museum</strong></h6>
                             <p>15th Nov, 45 students</p>
                         </div>
                     </div>
                     <div class="row mt-3">
                         <div class="col-8">
                             <h6><strong>Zoo Trip</strong></h6>
                             <p>20th Nov, 60 students</p>
                         </div>
                     </div>
                     <div class="row mt-3">
                         <div class="col-8">
                             <h6><strong>Historic Fort</strong></h6>
                             <p>30th Nov, 40 students</p>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <!-- To-Do List and Permission Status -->
     <div class="row mt-4">
         <div class="col-md-6">
             <div class="card">
                 <div class="card-body">
                     <h5><i class="fas fa-tasks"></i> To-Do List</h5>
                     <ul id="toDoList" class="list-group">
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                             Send permission slip reminders
                             <button class="btn btn-sm btn-danger">Delete</button>
                         </li>
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                             Confirm bus bookings
                             <button class="btn btn-sm btn-danger">Delete</button>
                         </li>
                     </ul>
                     <input type="text" id="newTask" class="form-control mt-2" placeholder="Add new task...">
                     <button class="btn btn-primary mt-2 w-100" onclick="addTask()">Add Task</button>
                 </div>
             </div>
         </div>
         <div class="col-md-6">
             <div class="card">
                 <div class="card-body">
                     <h5><i class="fas fa-check-square"></i> Permission Status</h5>
                     <ul class="list-group">
                         <li class="list-group-item">
                             <strong>Science Museum</strong>
                             <div class="progress mt-2">
                                 <div class="progress-bar" role="progressbar" style="width: 84%;">38/45 Approved</div>
                             </div>
                         </li>
                         <li class="list-group-item">
                             <strong>Zoo Trip</strong>
                             <div class="progress mt-2">
                                 <div class="progress-bar bg-success" role="progressbar" style="width: 83%;">50/60 Approved</div>
                             </div>
                         </li>
                         <li class="list-group-item">
                             <strong>Historic Fort</strong>
                             <div class="progress mt-2">
                                 <div class="progress-bar bg-info" role="progressbar" style="width: 88%;">35/40 Approved</div>
                             </div>
                         </li>
                     </ul>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <!-- Users Section -->
<div id="users" class="content-section">
    <h3>Users</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>

    <!-- Filters Section -->
    <div class="mt-3">
        <p>Search by Filter:</p>
        <input type="text" id="filterUserName" class="form-control d-inline-block w-25" placeholder="Filter by Name">
        <input type="email" id="filterUserEmail" class="form-control d-inline-block w-25" placeholder="Filter by Email">
        <select id="filterUserRole" class="form-select d-inline-block w-25">
            <option value="">Filter by Role</option>
            <!-- Populated Dynamically -->
        </select>
        <button class="btn btn-secondary" onclick="filterUsers()">Apply Filters</button>
    </div>

    <!-- User List -->
    <div id="userList" class="mt-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <!-- Populated Dynamically -->
            </tbody>
        </table>
    </div>

    <!-- Add/Edit User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add/Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm" onsubmit="return saveUser();">
                        <input type="hidden" id="userId" name="id">
                        <div class="mb-3">
                            <label for="userName" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="userName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="userEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="userRole" class="form-label">Role</label>
                            <select id="userRole" class="form-select" name="role" required>
                                <option value="Admin">Admin</option>
                                <option value="Teacher">Teacher</option>
                                <option value="Parent">Parent</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Save User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


 <!-- Trips & Events Section -->
<div id="trips" class="content-section">
    <h3>Trips & Events</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">Add New Excursion</button>
    <button class="btn btn-primary" onclick="loadExcursionRequests()">Check Excursion Requests</button>


    <!-- Filters Section -->
<div class="mt-3">
    <p>Search by Filter:</p>
    <input type="text" id="filterName" class="form-control d-inline-block w-25" placeholder="Filter by Name">
    <input type="date" id="filterDate" class="form-control d-inline-block w-25">
    <select id="filterTeacher" class="form-select d-inline-block w-25">
        <option value="">Filter by Teacher</option>
        <!-- Populated Dynamically -->
    </select>
    <button class="btn btn-secondary" onclick="filterExcursions()">Apply Filters</button>
</div>

<!-- Excursion List -->
<div id="excursionList" class="mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Date</th>
                <th>Location</th>
                <th>Teacher</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="excursionTableBody">
            <!-- Populated Dynamically -->
        </tbody>
    </table>
</div>

<!-- Add/Edit Excursion Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Add/Edit Excursion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="excursionForm" onsubmit="return saveExcursion();">
    <input type="hidden" id="excursionId" name="id">
    <div class="mb-3">
        <label for="name" class="form-label">Excursion Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="type" class="form-label">Excursion Type</label>
        <select id="type" class="form-select" name="type">
            <option value="Educational">Educational</option>
            <option value="Recreational">Recreational</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="date" class="form-label">Excursion Date</label>
        <input type="date" class="form-control" id="date" name="date" required>
    </div>
    <div class="mb-3">
        <label for="location" class="form-label">Location</label>
        <input type="text" class="form-control" id="location" name="location" required>
    </div>
    <div class="mb-3">
        <label for="teacher_id" class="form-label">Assign Teacher</label>
        <select class="form-select" id="teacher_id" name="teacher_id" required onchange="hideSelectTeacherOption()">
            <option value="">Select Teacher</option>
            <?php include 'get_teachers.php'; ?>
            <?php foreach ($teachers as $teacher): ?>
                <option value="<?= htmlspecialchars($teacher['id']) ?>"><?= htmlspecialchars($teacher['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Save Excursion</button>
</form>
            </div>
        </div>
    </div>
</div>


<!-- Approve/Reject Modal -->
<div class="modal fade" id="approveRejectModal" tabindex="-1" aria-labelledby="approveRejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveRejectModalLabel">Approve or Reject Excursion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="excursionDetails">Excursion details go here...</p>
                <div id="rejectionReasonSection" style="display: none;">
                    <label for="rejectionReason" class="form-label">Rejection Reason</label>
                    <textarea id="rejectionReason" class="form-control" placeholder="Provide a reason for rejection"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="submitExcursionDecision('rejected')">Reject</button>
                <button type="button" class="btn btn-success" onclick="submitExcursionDecision('approved')">Approve</button>
            </div>
        </div>
    </div>
</div>


 <div id="document" class="content-section">
     <h3>Document</h3>
     <p>Content for the document section.</p>
 </div>


 <div id="calendar" class="content-section">
     <h3>Calendar</h3>
     <p>Content for the calendar section.</p>
 </div>

 <div id="chart" class="content-section">
     <h3>Chart & Report</h3>
     <p>Content for the chart and report section.</p>
 </div>

 <div id="settings" class="content-section">
     <h3>Settings</h3>
     <p>Content for the settings section.</p>
 </div>
</div>
    <script src="adminpage.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

 
 