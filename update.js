// Import the functions you need from the Firebase SDKs
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-app.js";
import { getAuth, GoogleAuthProvider, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-auth.js";

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyCXaTbOMOUV5tGSgk2xP6MpSZReC696u_s",
  authDomain: "login-213c5.firebaseapp.com",
  projectId: "login-213c5",
  storageBucket: "login-213c5.appspot.com", // Fixed storage bucket URL
  messagingSenderId: "372133720102",
  appId: "1:372133720102:web:9d8fa9b5eeb3d408b476e7"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const provider = new GoogleAuthProvider();

let cachedProfilePicture = null;

function updateUserProfile(user) {
  const userName = user.displayName;
  const userEmail = user.email;
  const userProfilePicture = user.photoURL;

  document.getElementById("userName").textContent = userName;
  document.getElementById("userEmail").textContent = userEmail;

  // Check if the profile picture URL is the same or if it's new
  if (userProfilePicture && userProfilePicture !== cachedProfilePicture) {
    document.getElementById("userProfilePicture").src = userProfilePicture;
    cachedProfilePicture = userProfilePicture; // Update the cached value
  } else {
    document.getElementById("userProfilePicture").alt = "No profile picture available";
  }

  console.log("Profile Picture URL:", userProfilePicture); // Log to confirm URL
}



// Listen for authentication state changes
onAuthStateChanged(auth, (user) => {
  if (user) {
    // User is signed in, show profile details
    updateUserProfile(user);
  } else {
    // User is signed out, redirect to login or prompt user
    alert("Please create an account or log in.");
    window.location.href = "path/to/login.html"; // Redirect to login page if not signed in
  }
});

// Optional: Sign-in function if you have a Google sign-in button
const googleLoginButton = document.getElementById("google-login-btn");
if (googleLoginButton) {
  googleLoginButton.addEventListener("click", () => {
    auth.signInWithPopup(auth, provider)
      .then((result) => {
        console.log("User signed in:", result.user);
      })
      .catch((error) => {
        console.error("Error signing in:", error);
      });
  });
}
