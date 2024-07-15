<!DOCTYPE html>
<html>
<head>
    <title>Account Details</title>
</head>
<style>
    .card{
        background-color: rgb(225, 240, 253);
        padding: 15px;
        border-radius: 0.5rem;
    }
</style>
<body>
    <center>
        <div style="width: 75vw; text-align:start">
            <div style="display: flex; justify-content:center; align-items:center; padding:10px; width:75%">
                <div class="card">
                    <strong>Hello {{ $details->role }}</strong>;
                    <center>
                        <h5>Thank you for joining our platform <strong style="color:rgb(104, 104, 247)">{{env('APP_NAME')}}</strong></h5>
                    </center>
                    <p>Your {{ $details->role }} account has been created and is ready to be accessed <br> Below is your Login Credentials</p>
                    <i><p>You can change or maintain it upon login </p></i>
                    <div style="display: flex; align-items:center">
                        <p>Name: &ensp;<h3 style="color:rgb(104, 104, 247)">{{ $details->name}} or {{$details->email}}</h3></p>
                    </div>
                    <div style="display: flex; align-items:center">
                        <p>Password: &ensp;<h3 style="color:rgb(104, 104, 247)">{{ $details->password }}</h3></p>
                    </div>
                </div>
            </div>
        </div>
    </center>
</body>
</html>