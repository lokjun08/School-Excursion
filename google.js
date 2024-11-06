// Import the functions you need from the Firebase SDKs
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-app.js";
import { getAuth, GoogleAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-auth.js";

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyCXaTbOMOUV5tGSgk2xP6MpSZReC696u_s",
  authDomain: "login-213c5.firebaseapp.com",
  projectId: "login-213c5",
  storageBucket: "login-213c5.firebasestorage.app",
  messagingSenderId: "372133720102",
  appId: "1:372133720102:web:9d8fa9b5eeb3d408b476e7"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const provider = new GoogleAuthProvider();

// Get Google login buttons
const googleLoginButtons = document.querySelectorAll("#google-login-btn");

googleLoginButtons.forEach(button => {
  button.addEventListener("click", function() {
    signInWithPopup(auth, provider)
      .then((result) => {
        const user = result.user;
        
        // Send Google user data to server
        fetch('google_register.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ name: user.displayName, email: user.email })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            window.location.href = 'logged.html';  // Redirect on successful registration
          } else {
            alert(data.message || "Error during registration. Please try again.");
          }
        });
      })
      .catch((error) => {
        console.error("Error during login:", error.code, error.message);
      });
  });
});

// Hash a new password before storing it
$password = 'examplePassword';
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Verify the password during login
if (password_verify($userInputPassword, $storedHashedPassword)) {
    document.write("Password is correct!");
} else {
  document.write("Password is correct!");
}
