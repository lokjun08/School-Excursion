// Function to toggle the form visibility
function toggleForm(show) {
    const wrapper = document.querySelector('.wrapper');
    const overlay = document.getElementById('overlay-id');

    if (show) {
        wrapper.classList.add('show');
        overlay.classList.add('show');
    } else {
        wrapper.classList.remove('show');
        overlay.classList.remove('show');
    }
}

// Event listener to show the sign-in form
document.getElementById('nav-signin-btn').addEventListener('click', () => toggleForm(true));

// Close form when clicking outside
document.getElementById('overlay-id').addEventListener('click', () => toggleForm(false));

// Get all menu items and sections
const menuItems = document.querySelectorAll('.nav-links a');
const sections = document.querySelectorAll('section');

// Hide all sections except for home initially
function hideAllSections() {
    sections.forEach(section => {
        section.style.display = 'none';
    });
}

// Show a specific section
function showSection(sectionId) {
    document.getElementById(sectionId).style.display = 'block';
}

// Initialize by showing only the home section
hideAllSections();
showSection('home');

// Handle menu item clicks to show sections
menuItems.forEach(item => {
    item.addEventListener('click', (event) => {
        event.preventDefault();
        const sectionId = event.target.getAttribute('data-section');
        hideAllSections();
        showSection(sectionId);
    });
});

// Handle logo click to show the home section
document.getElementById('logo').addEventListener('click', (event) => {
    event.preventDefault();
    hideAllSections();
    showSection('home');
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

});

