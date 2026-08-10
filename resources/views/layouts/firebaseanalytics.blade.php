<!--para que no cuente visitas  en firebase estando en localhost-->
@if(!str_contains(url('/'), 'localhost') && !str_contains(url('/'), '127.0.0.1:8000'))
<!-- The core Firebase JS SDK is always required and must be listed firstttt -->
<script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-analytics.js"></script>

<script>
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional

  const firebaseConfig = {
  apiKey: "AIzaSyDz7FUkBtpZt9PBYoLXrxyOizg7BDVOmr4",
  authDomain: "oii-on.firebaseapp.com",
  projectId: "oii-on",
  storageBucket: "oii-on.firebasestorage.app",
  messagingSenderId: "574205217743",
  appId: "1:574205217743:web:259fe9d810e921d08760ba",
  measurementId: "G-D2Y68ZNJ9D"
};
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
</script>
@endif

