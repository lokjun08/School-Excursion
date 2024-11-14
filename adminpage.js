 // Fetch and display all excursions by default, or apply filters if selected
 function filterExcursions() {
    const name = document.getElementById('filterName').value;
    const date = document.getElementById('filterDate').value;
    const teacher = document.getElementById('filterTeacher').value;

    let queryParams = '';
    if (name) queryParams += `name=${name}&`;
    if (date) queryParams += `date=${date}&`;
    if (teacher) queryParams += `teacher=${teacher}&`;

    fetch(`filter_excursion.php?${queryParams}`)
.then(response => response.json())
.then(data => {
    console.log("Fetched Data:", data); // Log fetched data to verify
    const excursionTableBody = document.getElementById('excursionTableBody');
    excursionTableBody.innerHTML = '';
    data.forEach(excursion => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${excursion.name}</td>
            <td>${excursion.type}</td>
            <td>${excursion.date}</td>
            <td>${excursion.location}</td>
            <td>${excursion.teacher_name}</td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="editExcursion(${excursion.id})">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteExcursion(${excursion.id})">Delete</button>
            </td>
        `;
        excursionTableBody.appendChild(row);
    });
})
.catch(error => console.error('Error:', error));

}

// Load all excursions initially when the page loads
document.addEventListener('DOMContentLoaded', filterExcursions);

function saveExcursion() {
    const formData = new FormData(document.getElementById('excursionForm'));

    fetch('save_excursion.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert('Excursion created successfully.'); // Show success alert
        document.getElementById('excursionForm').reset(); // Reset form fields
        var addEventModal = bootstrap.Modal.getInstance(document.getElementById('addEventModal'));
        addEventModal.hide(); // Hide the modal
        filterExcursions(); // Refresh the excursion list
    })
    .catch(error => console.error('Error:', error));

    return false; // Prevent default form submission
}


    function hideSelectTeacherOption() {
        var teacherSelect = document.getElementById('teacher_id');
        var firstOption = teacherSelect.options[0];
        if (teacherSelect.value !== "") {
            firstOption.style.display = 'none';
        } else {
            firstOption.style.display = 'block';
        }
    }

    function loadExcursionRequests() {
        fetch('fetch_pending_excursions.php')
            .then(response => response.json())
            .then(data => {
                let requestsHtml = '';
                data.forEach(request => {
                    requestsHtml += `
                        <div class="request-item">
                            <p><strong>${request.name}</strong> by ${request.teacher_name} on ${request.date}</p>
                            <button class="btn btn-info btn-sm" onclick="viewRequest(${request.id})">View</button>
                        </div>
                    `;
                });
                document.getElementById('excursionRequestList').innerHTML = requestsHtml;
            })
            .catch(error => console.error('Error loading excursion requests:', error));
    }
    
    function viewRequest(requestId) {
        fetch(`get_excursion_request.php?id=${requestId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('excursionDetails').innerText = `
                    Name: ${data.name}\n
                    Date: ${data.date}\n
                    Location: ${data.location}\n
                    Teacher: ${data.teacher_name}
                `;
                document.getElementById('rejectionReasonSection').style.display = 'none';
                document.getElementById('rejectionReason').value = '';
                document.getElementById('approveRejectModal').dataset.requestId = requestId;
                new bootstrap.Modal(document.getElementById('approveRejectModal')).show();
            })
            .catch(error => console.error('Error fetching excursion request:', error));
    }
    
    function submitExcursionDecision(decision) {
        const requestId = document.getElementById('approveRejectModal').dataset.requestId;
        const reason = decision === 'rejected' ? document.getElementById('rejectionReason').value : '';
    
        if (decision === 'rejected' && !reason) {
            alert('Please provide a reason for rejection.');
            document.getElementById('rejectionReasonSection').style.display = 'block';
            return;
        }
    
        fetch('process_excursion_decision.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: requestId, decision, reason })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            new bootstrap.Modal(document.getElementById('approveRejectModal')).hide();
            loadExcursionRequests(); // Refresh the list of requests
            filterExcursions(); // Refresh the excursion list if approved
        })
        .catch(error => console.error('Error processing excursion decision:', error));
    }
    
    
    // Fetch user details on page load and display in profile section
        document.addEventListener("DOMContentLoaded", function() {
            fetchUserProfile();
        });

        function fetchUserProfile() {
            fetch('get_user_details.php')
                .then(response => response.json())
                .then(user => {
                    document.getElementById('profileName').textContent = user.name;
                    document.getElementById('user_id').value = user.id;
                    document.getElementById('username').value = user.name;
                    document.getElementById('email').value = user.email;

                    // Optionally set a profile image if available
                    if (user.profile_image) {
                        document.getElementById('profileImage').src = user.profile_image;
                    }
                })
                .catch(error => console.error('Error fetching profile:', error));
        }

        function saveProfile() {
            const formData = new FormData(document.getElementById('editProfileForm'));

            fetch('update_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert('Profile updated successfully');
                fetchUserProfile();  // Refresh the displayed profile info
                var modal = bootstrap.Modal.getInstance(document.getElementById('editProfileModal'));
                modal.hide(); // Hide the modal after save
            })
            .catch(error => console.error('Error updating profile:', error));

            return false; // Prevent default form submission
        }

        function logout() {
            // Implement logout functionality here
            alert('Logging out...');
        }
    
    function filterExcursions() {
        const name = document.getElementById('filterName').value;
        const date = document.getElementById('filterDate').value;
        const teacher = document.getElementById('filterTeacher').value;
    
        // Construct query string based on filter inputs (only if filters are applied)
        let queryParams = '';
        if (name) queryParams += `name=${name}&`;
        if (date) queryParams += `date=${date}&`;
        if (teacher) queryParams += `teacher=${teacher}&`;
    
        // Fetch all excursions if no filters are applied
        fetch(`filter_excursion.php?${queryParams}`)
            .then(response => response.json())
            .then(data => {
                const excursionTableBody = document.getElementById('excursionTableBody');
                excursionTableBody.innerHTML = ''; // Clear existing rows
    
                data.forEach(excursion => {
                    const row = document.createElement('tr');
    
                    row.innerHTML = `
                        <td>${excursion.name}</td>
                        <td>${excursion.type}</td>
                        <td>${excursion.date}</td>
                        <td>${excursion.location}</td>
                        <td>${excursion.teacher_name}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editExcursion(${excursion.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteExcursion(${excursion.id})">Delete</button>
                        </td>
                    `;
                    excursionTableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error:', error));
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        filterExcursions(); // Fetch and display all excursions by default
    });
    
    function deleteExcursion(id) {
        if (confirm('Are you sure you want to delete this excursion?')) {
            fetch(`delete_excursion.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}`
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                filterExcursions(); // Refresh the list after deletion
            })
            .catch(error => console.error('Error:', error));
        }
    }
    
    
    function editExcursion(id) {
        fetch(`get_excursion.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('excursionId').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('type').value = data.type;
                document.getElementById('date').value = data.date;
                document.getElementById('location').value = data.location;
                document.getElementById('teacher_id').value = data.teacher_id;
                new bootstrap.Modal(document.getElementById('addEventModal')).show();
            })
            .catch(error => console.error('Error:', error));
    }
    
    document.getElementById('approveBtn').onclick = function() {
        changeExcursionStatus('approved');
    };
    
    document.getElementById('rejectBtn').onclick = function() {
        changeExcursionStatus('rejected');
    };
    
    function changeExcursionStatus(status) {
        const id = document.getElementById('excursionId').value;
        fetch(`update_excursion_status.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&status=${status}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
    
    
            function toggleSidebar() {
                document.getElementById('sidebar').classList.toggle('collapsed');
                document.getElementById('main-content').classList.toggle('collapsed');
            }
            
            //excursion table list
            function showSection(sectionId) {
                const sections = document.querySelectorAll('.content-section');
                sections.forEach(section => {
                    section.classList.remove('active');
                });
    
                const activeSection = document.getElementById(sectionId);
                if (activeSection) activeSection.classList.add('active');
            }
    
            function logout() {
                // Add logic to log out the user
                alert('Logging out...');
            }
    
            function searchDashboard() {
        const query = document.querySelector('.search-input').value.toLowerCase();
        const items = document.querySelectorAll('.dashboard-item'); // Adjust selector as needed
    
        items.forEach(item => {
            if (item.textContent.toLowerCase().includes(query)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }
    
    
        document.addEventListener('DOMContentLoaded', () => {
        populateTeacherDropdown();
    
    });
    
    
    document.addEventListener('DOMContentLoaded', function() {
            fetchTeachers();
    
            function fetchTeachers() {
                $.ajax({
                    url: 'get_teachers.php',
                    method: 'GET',
                    success: function(data) {
                        const teachers = JSON.parse(data);
                        let options = '<option value="">Select Teacher</option>';
                        teachers.forEach(teacher => {
                            options += `<option value="${teacher.id}">${teacher.name}</option>`;
                        });
                        document.getElementById('teacher_id').innerHTML = options;
                    },
                    error: function(error) {
                        console.error('Error fetching teachers:', error);
                    }
                });
            }
        });

        function toggleCollapse(submenuId) {
            const submenu = document.getElementById(submenuId);
            submenu.classList.toggle('collapse');
        }

        function fetchUsers() {
            fetch('fetch_users.php')
                .then(response => response.json())
                .then(users => {
                    const userTableBody = document.getElementById('userTableBody');
                    userTableBody.innerHTML = '';
                    users.forEach(user => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.role}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editUser(${user.id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Delete</button>
                            </td>
                        `;
                        userTableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching users:', error));
        }
        
        document.addEventListener('DOMContentLoaded', fetchUsers);
        
        function editUser(id) {
            fetch(`get_user.php?id=${id}`)
                .then(response => response.json())
                .then(user => {
                    document.getElementById('userId').value = user.id;
                    document.getElementById('userName').value = user.name;
                    document.getElementById('userEmail').value = user.email;
                    document.getElementById('userRole').value = user.role;
                    new bootstrap.Modal(document.getElementById('addUserModal')).show();
                })
                .catch(error => console.error('Error fetching user:', error));
        }
        
        function saveUser() {
            const formData = new FormData(document.getElementById('userForm'));
            const url = formData.get('id') ? 'edit_user.php' : 'add_user.php';
        
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Show success message
                fetchUsers(); // Refresh the user list
                document.getElementById('userForm').reset();
                bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide();
            })
            .catch(error => console.error('Error:', error));
        
            return false; // Prevent default form submission
        }
        
        
        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                fetch('delete_user.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${id}`
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    fetchUsers(); // Refresh the user list
                })
                .catch(error => console.error('Error deleting user:', error));
            }
        }

        function filterUsers() {
            const name = document.getElementById('filterUserName').value;
            const email = document.getElementById('filterUserEmail').value;
            const role = document.getElementById('filterUserRole').value;
         
            fetch(`fetch_users.php?name=${name}&email=${email}&role=${role}`)
                .then(response => response.json())
                .then(users => {
                    const userTableBody = document.getElementById('userTableBody');
                    userTableBody.innerHTML = '';
                    users.forEach(user => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.role}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editUser(${user.id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Delete</button>
                            </td>
                        `;
                        userTableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error:', error));
         }
         
         function showSection(sectionId) {
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.classList.remove('active');
            });
        
            const activeSection = document.getElementById(sectionId);
            if (activeSection) activeSection.classList.add('active');
        
            // If the "Users" section is active, fetch user data
            if (sectionId === 'users') {
                fetchUsers();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            showSection('users'); // Automatically load the "Users" section on page load
        });
        
        function toggleCollapse(submenuId) {
            const submenu = document.getElementById(submenuId);
            const arrowIcon = document.getElementById('management-arrow');
        
            submenu.classList.toggle('collapse');
            if (submenu.classList.contains('collapse')) {
                arrowIcon.classList.remove('fa-chevron-up');
                arrowIcon.classList.add('fa-chevron-down');
            } else {
                arrowIcon.classList.remove('fa-chevron-down');
                arrowIcon.classList.add('fa-chevron-up');
            }
        }
        
        // Fetch and display user details on page load
function loadUserProfile() {
    fetch('get_user_details.php')
        .then(response => response.json())
        .then(user => {
            if (!user.error) {
                document.getElementById('profilePic').src = user.profile_picture || 'https://via.placeholder.com/30';
                document.getElementById('userName').textContent = user.name;
                
                // Fill modal fields for editing
                document.getElementById('userId').value = user.id;
                document.getElementById('username').value = user.name;
                document.getElementById('email').value = user.email;
            } else {
                console.error('User not found');
            }
        })
        .catch(error => console.error('Error fetching user details:', error));
}

document.addEventListener('DOMContentLoaded', loadUserProfile);

// Submit profile changes
document.getElementById('editProfileForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);

    fetch('update_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Show success message
        loadUserProfile(); // Refresh profile details
        bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
    })
    .catch(error => console.error('Error updating profile:', error));
});
