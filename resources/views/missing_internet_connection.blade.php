<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Missing Internet Connection</title>
    <link rel="stylesheet" href="{{ asset('cssfiles/missing_internet_connection.css') }}">
</head>
<body>
    <div class="main_container">
        <div class="image_container">
            <img src="{{ asset('img/missing_internet_connection2.png') }}" alt="missing_internet_connection pic" id = "missing_internet_connection_pic">
        </div>

        <div class="text_container">
            <h1>Missing Internet Connection !</h1>
            <div class="other_info_container">
                <h3>Sorry, This page may require internet connection, please connect to the internet and try again</h3>
                <h3 id = "second_line"><span>THANK YOU</span></h3>
                <button id = "refresh_btn" onclick = "location.reload();">REFRESH</button>
            </div>
        </div>
    </div>
</body>
</html>