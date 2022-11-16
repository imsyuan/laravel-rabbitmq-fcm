importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

const firebaseConfig = {
    apiKey: "AIzaSyB4zPR1tKA4qYVvQwvRxfu0ydndeEsKIzE",
    authDomain: "laravel-rabbitmq-fcm.firebaseapp.com",
    projectId: "laravel-rabbitmq-fcm",
    storageBucket: "laravel-rabbitmq-fcm.appspot.com",
    messagingSenderId: "950008601718",
    appId: "1:950008601718:web:0020b7c50b08eedc579357",
    measurementId: "G-3WL8XV7EBL"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});
