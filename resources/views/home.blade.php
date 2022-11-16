@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="http://localhost:9001/producer" target="_blank">點我建立訊息</a>
                <div class="card mt-3">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="module">
        // Import the functions you need from the SDKs you need
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.14.0/firebase-app.js";
        import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging.js";
        import axios from 'https://cdn.skypack.dev/axios';

        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "AIzaSyB4zPR1tKA4qYVvQwvRxfu0ydndeEsKIzE",
            authDomain: "laravel-rabbitmq-fcm.firebaseapp.com",
            projectId: "laravel-rabbitmq-fcm",
            storageBucket: "laravel-rabbitmq-fcm.appspot.com",
            messagingSenderId: "950008601718",
            appId: "1:950008601718:web:0020b7c50b08eedc579357",
            measurementId: "G-3WL8XV7EBL"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const messaging = getMessaging(app);

        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then(reg => console.log('完成 SW 設定!', reg))
                .catch(err => console.log('Error!', err));
        }

        getToken(messaging, {vapidKey: "BLahmMLfMpwq3g2MsNg_gL5h9M5j5cAEUNAeIyoYkpp0IbdQxtk81_JV5SUl_gzBKI4s7gJp2VLLUSwv1q_-wYA"})
        .then(function (token){
            axios.post("{{ route('fcmToken') }}",{
                _method:"PATCH",
                token
            }).then(({data})=>{
                console.log(data)
            }).catch(({response:{data}})=>{
                console.error(data)
            })
        }).catch(function (err) {
            console.log(`Token Error :: ${err}`);
        });

    </script>

@endsection

