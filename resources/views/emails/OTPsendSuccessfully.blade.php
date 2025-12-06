<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login OTP Mail</title>
    <style>

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 600px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #8789ff;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 20px;
            line-height: 1.6;
        }
        .content h2 {
            color: #8789ff;
            font-size: 20px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .texxt {
            font-size: 16px;
            color: #333333;
            margin: 10px 0;
            font-weight: 550;
        }

        .text {
            font-size: 14px;
            text-align: center;
            color: #758594;
            font-weight: 550;
        }

        .content .thank-you {
            text-align: center;
            font-size: 18px;
        }
        .content .thank-you {
            color: #454545;
            font-weight: 600;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #8789ff;
            color: #ffffff;
            font-size: 16px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Login OTP Mail From "SHUBHSTEP"</h1>
        </div>
        <div class="content">
            <h2>Dear Customer !</h2>
            <p class = "texxt">Your OTP for login is:</p>
            <h2 style = "font-size : 1.7rem; text-align : center; margin-top: 0;">{{ $OTP }}</h2>
            <p class = "texxt">Please use this OTP to log in to your account. If you did not request this OTP, please ignore this email.</p>
            <p class = "texxt">NOTE : This OTP is valid for only 10 minutes.</p>
            <p class = "text">This email was sent automatically. Please do not reply to this email.</p>
            <div class="thank-you">
                &#10084; <span>THANK YOU!</span> &#10084;
            </div>
        </div>
        <div class="footer">
            &copy; 2024 SHUBHSTEP. All rights reserved.
        </div>
    </div>
</body>
</html>