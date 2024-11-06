// Function to toggle the form visibility
function toggleForm(show, isRegister) {
    const wrapper = document.querySelector('.wrapper');
    const overlay = document.getElementById('overlay-id');

    if (show) {
        wrapper.classList.add('show');
        overlay.classList.add('show'); // Show overlay
        if (isRegister) {
            wrapper.classList.add('active');
        } else {
            wrapper.classList.remove('active');
        }
    } else {
        wrapper.classList.remove('show');
        overlay.classList.remove('show'); // Hide overlay
        wrapper.classList.remove('active');
    }
}

// Add event listeners to trigger form toggle
document.getElementById('nav-signin-btn').addEventListener('click', () => toggleForm(true, false));
document.getElementById('nav-register-btn').addEventListener('click', () => toggleForm(true, true));

// Handle clicks outside the form to close it
document.addEventListener('click', (event) => {
    const wrapper = document.querySelector('.wrapper');
    if (!wrapper.contains(event.target) && !event.target.closest('.auth-links')) {
        toggleForm(false);
    }
});

// Sign In and Register
document.getElementById('login-btn').addEventListener('click', () => toggleForm(true, false));
document.getElementById('register-btn').addEventListener('click', () => toggleForm(true, true));

// Click outside the form to hide it
document.addEventListener('click', (event) => {
    const isClickInsideForm = event.target.closest('.wrapper');
    const isClickOnAuthLinks = event.target.closest('.auth-links');
    
    if (!isClickInsideForm && !isClickOnAuthLinks) {
        toggleForm(false);
    }
});

// Get all menu items and sections
const menuItems = document.querySelectorAll('.nav-links a');
const sections = document.querySelectorAll('section');

// Hide all sections initially except for home
function hideAllSections() {
    sections.forEach(section => {
        section.style.display = 'none';
    });
}

// Show the specified section
function showSection(sectionId) {
    document.getElementById(sectionId).style.display = 'block';
}

// Function to handle menu item click
menuItems.forEach(item => {
    item.addEventListener('click', (event) => {
        event.preventDefault();
        const sectionId = event.target.getAttribute('data-section');
        hideAllSections();
        showSection(sectionId);

        // Update active state
        menuItems.forEach(i => i.classList.remove('active'));
        event.target.classList.add('active');
    });
});

// Handle logo click to show home section and hide others
document.getElementById('logo').addEventListener('click', (event) => {
    event.preventDefault();
    hideAllSections();
    showSection('home');

    // Remove active class from other items
    menuItems.forEach(i => i.classList.remove('active'));
});

// Firebase configuration
const firebaseConfig = {
    apiKey: "YOUR_API_KEY",
    authDomain: "YOUR_PROJECT_ID.firebaseapp.com",
    projectId: "YOUR_PROJECT_ID",
    storageBucket: "YOUR_PROJECT_ID.appspot.com",
    messagingSenderId: "YOUR_MESSAGING_SENDER_ID",
    appId: "YOUR_APP_ID"
};
firebase.initializeApp(firebaseConfig);
const auth = firebase.auth();

// Google login function
function googleLogin() {
    const provider = new firebase.auth.GoogleAuthProvider();
    auth.signInWithPopup(provider)
        .then((result) => {
            const user = result.user;
            console.log("User Info:", user);
            // Redirect or handle successful login as needed
            window.location.href = '/dashboard'; // Replace with your target page
        })
        .catch((error) => {
            console.error("Error during Google Sign-In:", error);
        });
}

// Function to toggle password visibility
function togglePasswordVisibility(inputId, iconElement) {
    const passwordInput = document.getElementById(inputId);
    const icon = iconElement.querySelector('i'); // Get the <i> tag inside the clicked span

    // Toggle password visibility based on the current state
    if (passwordInput.type === 'text') {
        passwordInput.type = 'password';  // Hide password
        icon.classList.remove('fa-eye-slash');  // Remove 'fa-eye-slash'
        icon.classList.add('fa-eye');  // Add 'fa-eye' to show that it's hidden
    } else {
        passwordInput.type = 'text';  // Show password
        icon.classList.remove('fa-eye');  // Remove 'fa-eye'
        icon.classList.add('fa-eye-slash');  // Add 'fa-eye-slash' to show that it's revealed
    }
}

document.getElementById('register-form').addEventListener('submit', function (e) {
    e.preventDefault();

    // Client-side validation for password strength and matching passwords
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');

    let valid = true;

    // Password strength check (at least 8 characters, with uppercase, lowercase, number, and special character)
    const strongPasswordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
    if (!strongPasswordPattern.test(passwordInput.value)) {
        alert("Password must be at least 8 characters, with uppercase, lowercase, number, and special character.");
        valid = false;
    }

    // Confirm password check
    if (passwordInput.value !== confirmPasswordInput.value) {
        alert("Passwords do not match.");
        valid = false;
    }

    if (valid) {
        // If client-side validation passes, submit the form via AJAX
        const formData = new FormData(document.getElementById('register-form'));

        fetch('register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);  // Show success message
                window.location.href = 'login.html'; // Redirect on success
            } else if (data.status === 'error') {
                alert(data.message);  // Show error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred. Please try again.");
        });
    }
});
