
    
    // Save profile changes
    function saveProfile() {
        const formData = new FormData(document.getElementById('editProfileForm'));
    
        fetch('update_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Display success message
            bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
            // Optionally update displayed user info here
        })
        .catch(error => console.error('Error updating profile:', error));
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
                // Clear session storage or cookies if any
                sessionStorage.clear();  // Clears all session storage
                localStorage.clear();    // Clears local storage (if you used it)
            
                // Optionally, you can remove specific cookies (if you are using them):
                // document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                
                // Redirect to the login page or another page after logout
                window.location.href = "login.html";  // Replace with your login page URL
            
                // Show a logout message (optional)
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
            console.log("Editing user with ID:", id); // Debugging to verify the id being passed
            fetch(`get_user.php?id=${id}`)
                .then(response => response.json())
                .then(user => {
                    if (user.error) {
                        alert(user.error);
                        return;
                    }
                    document.getElementById('userId').value = user.id;
                    document.getElementById('userName').value = user.name;
                    document.getElementById('userEmail').value = user.email;
        
                    const roleSelect = document.getElementById('userRole');
                    roleSelect.value = user.role || '';
        
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
            // Get all sections and remove the 'active' class
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.classList.remove('active');
            });
        
            // Activate the selected section
            const activeSection = document.getElementById(sectionId);
            if (activeSection) activeSection.classList.add('active');
        
            // Fetch user data if the "Users" section is active
            if (sectionId === 'users') {
                fetchUsers();
            }
        
            // Re-render the calendar if the "Calendar" section is active
            if (sectionId === "calendar") {
                const calendarEl = document.getElementById("fullCalendar");
                if (calendarEl) {
                    // Initialize or render the calendar
                    const calendar = FullCalendar.getCalendar(calendarEl); // Retrieve existing calendar instance
                    if (calendar) {
                        calendar.render(); // Re-render the calendar
                    } else {
                        // If no calendar instance exists, create it
                        const newCalendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: "dayGridMonth",
                            events: "/get_excursions.php",
                            eventClick: function (info) {
                                alert(`Excursion: ${info.event.title}\nStart: ${info.event.start}\nEnd: ${info.event.end}`);
                            }
                        });
                        newCalendar.render(); // Render the new calendar
                    }
                }
            }
        }
        

        document.addEventListener('DOMContentLoaded', () => {
            showSection('dashboard'); // 
        });
       
        document.addEventListener('DOMContentLoaded', () => {
            fetchExcursions();
        
            document.querySelector('#excursionForm').addEventListener('submit', (e) => {
                e.preventDefault();
                saveExcursion();
            });
        });
        
        function fetchExcursions() {
            fetch('excursion_handler.php', {
                method: 'POST',
                body: new URLSearchParams({ action: 'fetch' })
            })
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#excursionTableBody');
                tableBody.innerHTML = '';
                data.forEach(item => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.type}</td>
                            <td>${item.start_date}</td>
                            <td>${item.end_date}</td>
                            <td>${item.location}</td>
                            <td>${item.num_participation || 0}</td>
                            <td>${item.teacher_name || 'Unassigned'}</td>
                            <td>
                                <button onclick="editExcursion(${item.id})" class="btn btn-sm btn-primary">Edit</button>
                                <button onclick="deleteExcursion(${item.id})" class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            });
        }
        
        function saveExcursion() {
            const form = document.querySelector('#excursionForm');
            const formData = new FormData(form);
            formData.append('action', 'save');
        
            fetch('excursion_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data === 'success') {
                    alert('Excursion saved successfully!');
                    fetchExcursions();
                    form.reset();
                    bootstrap.Modal.getInstance(document.querySelector('#addEventModal')).hide();
                }
            });
        }
        
        function editExcursion(id) {
            fetch('excursion_handler.php', {
                method: 'POST',
                body: new URLSearchParams({ action: 'fetch' })
            })
            .then(response => response.json())
            .then(data => {
                const excursion = data.find(e => e.id == id);
                if (excursion) {
                    const form = document.querySelector('#excursionForm');
                    form.elements['id'].value = excursion.id;
                    form.elements['name'].value = excursion.name;
                    form.elements['description'].value = excursion.description;
                    form.elements['type'].value = excursion.type;
                    form.elements['start_date'].value = excursion.start_date;
                    form.elements['end_date'].value = excursion.end_date;
                    form.elements['location'].value = excursion.location;
                    form.elements['teacher_id'].value = excursion.assigned_teacher_id;
                    new bootstrap.Modal(document.querySelector('#addEventModal')).show();
                }
            });
        }
        
        function deleteExcursion(id) {
            if (confirm('Are you sure you want to delete this excursion?')) {
                fetch('excursion_handler.php', {
                    method: 'POST',
                    body: new URLSearchParams({ action: 'delete', id: id })
                })
                .then(response => response.text())
                .then(data => {
                    if (data === 'success') {
                        alert('Excursion deleted successfully!');
                        fetchExcursions();
                    }
                });
            }
        }
        
        function filterExcursions() {
            const name = document.querySelector('#filterName').value;
            const date = document.querySelector('#filterDate').value;
            const teacher = document.querySelector('#filterTeacher').value;
        
            fetch('excursion_handler.php', {
                method: 'POST',
                body: new URLSearchParams({
                    action: 'filter',
                    name: name,
                    date: date,
                    teacher: teacher
                })
            })
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#excursionTableBody');
                tableBody.innerHTML = '';
                data.forEach(item => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.type}</td>
                            <td>${item.start_date}</td>
                            <td>${item.end_date}</td>
                            <td>${item.location}</td>
                            <td>${item.num_participation || 0}</td>
                            <td>${item.teacher_name || 'Unassigned'}</td>
                            <td>
                                <button onclick="editExcursion(${item.id})" class="btn btn-sm btn-primary">Edit</button>
                                <button onclick="deleteExcursion(${item.id})" class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            });
        }
        
        function loadExcursionRequests() {
            fetch('excursion_handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=fetch_requests'
            })
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('excursionRequestsTableBody');
                    tableBody.innerHTML = '';
        
                    data.forEach(request => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${request.excursion_name}</td>
                            <td>${request.description}</td>
                            <td>${request.type}</td>
                            <td>${request.start_date}</td>
                            <td>${request.end_date}</td>
                            <td>${request.teacher_name}</td>
                            <td>${request.status}</td>
                            <td>
                                <button class="btn btn-success" onclick="approveRequest(${request.id})">Approve</button>
                                <button class="btn btn-danger" onclick="rejectRequest(${request.id})">Reject</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
        
                    // Show the modal
                    const modal = new bootstrap.Modal(document.getElementById('excursionRequestsModal'));
                    modal.show();
                });
        }

        function approveRequest(requestId) {
            fetch('excursion_handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=approve_request&id=${requestId}`
            })
                .then(response => response.text())
                .then(data => {
                    if (data === 'success') {
                        alert('Request approved.');
                        loadExcursionRequests();
                    }
                });
        }
        
        function rejectRequest(requestId) {
            const reason = prompt('Enter rejection reason:');
            if (!reason) return;
        
            fetch('excursion_handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=reject_request&id=${requestId}&reason=${encodeURIComponent(reason)}`
            })
                .then(response => response.text())
                .then(data => {
                    if (data === 'success') {
                        alert('Request rejected.');
                        loadExcursionRequests();
                    }
                });
        }
        // When the students are selected, calculate the number of students
document.getElementById('students').addEventListener('change', function() {
    var selectedStudents = document.getElementById('students').selectedOptions;
    var numParticipants = selectedStudents.length; // Count the number of selected students
    document.getElementById('num_participation').value = numParticipants; // Set the number of participants
});

document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById("fullCalendar");

    if (calendarEl) {
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            events: "/get_excursions.php", // Ensure this endpoint returns correct event data
            eventClick: function (info) {
                alert(`Event: ${info.event.title}\nStart: ${info.event.start}\nEnd: ${info.event.end}`);
            }
        });
        calendar.render();
    }
});









