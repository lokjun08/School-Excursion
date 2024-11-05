const wrapper = document.querySelector('.wrapper');

// Function to toggle the form
function toggleForm(show, isRegister) {
    const wrapper = document.querySelector('.wrapper');
    const overlay = document.getElementById('overlay-id');

    if (show) {
        wrapper.classList.add('show');
        overlay.classList.add('show'); // show overlay
        if (isRegister) {
            wrapper.classList.add('active');
        } else {
            wrapper.classList.remove('active');
        }
    } else {
        wrapper.classList.remove('show');
        overlay.classList.remove('show'); // hide overlay
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


// Sign In 和 Register 
document.getElementById('nav-signin-btn').addEventListener('click', () => toggleForm(true, false));
document.getElementById('nav-register-btn').addEventListener('click', () => toggleForm(true, true));

// switch page signin signup
document.getElementById('login-btn').addEventListener('click', () => toggleForm(true, false));
document.getElementById('register-btn').addEventListener('click', () => toggleForm(true, true));

// Click outside the form to hide it
document.addEventListener('click', (event) => {
    // Check if the click is outside of both the form container and the auth links
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

 // Function to display a message based on login status
 function displayLoginMessage() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    // Select a placeholder or create an alert for login status message
    const messageContainer = document.createElement('div');
    messageContainer.style.padding = "10px";
    messageContainer.style.margin = "10px 0";
    messageContainer.style.textAlign = "center";

    // Display success or error message based on the status
    if (status === 'success') {
        messageContainer.style.backgroundColor = "#d4edda";
        messageContainer.style.color = "#155724";
        messageContainer.textContent = "Login successful! Welcome back.";
    } else if (status === 'failed') {
        messageContainer.style.backgroundColor = "#f8d7da";
        messageContainer.style.color = "#721c24";
        messageContainer.textContent = "Login failed. Please check your email or password and try again.";
    }

    // Append the message container at the top of the form
    const wrapper = document.getElementById('wrapper-id');
    if (wrapper && messageContainer.textContent) {
        wrapper.insertBefore(messageContainer, wrapper.firstChild);
    }
}

// Call the function when the page loads
window.onload = displayLoginMessage;

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

