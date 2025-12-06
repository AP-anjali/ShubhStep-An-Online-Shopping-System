<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHUBHSTEP | Customer support form data</title>
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

        .content .thank-you {
            text-align: center;
            font-size: 18px;
        }
        .content .thank-you {
            color: #454545;
            margin-top: 1rem;
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
            <h1>New Customer Support Form Submission From "SHUBHSTEP"</h1>
        </div>
        <div class="content">
            <div style = "display: flex; gap: 1rem;">
                <h2>Name : </h2>
                <h2 style="color: #333333;">&nbsp; {{ $data['name'] }}</h2>
            </div>

            <div style = "display: flex; gap: 1rem;">
                <h2>E-mail : </h2>
                <h2 style="color: #333333;">&nbsp; {{ $data['email'] }}</h2>
            </div>

            <div style = "display: flex; gap: 1rem;">
                <h2>Phone Number : </h2>
                <h2 style="color: #333333;">&nbsp; {{ $data['phone_no'] }}</h2>
            </div>

            <div style = "display: flex; gap: 1rem;">
                <h2>Message : </h2>
                <h2 style="color: #333333;">&nbsp; {{ $data['message'] }}</h2>
            </div>

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
