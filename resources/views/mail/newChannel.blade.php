<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Your New Channel</title>
    <style>
        /* Add your custom CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fbfbfb;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #206bc4;
            color: #fff;
            text-align: center;
            padding: 20px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .content {
            padding: 20px;
        }
        p {
            color: #777;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
            color: #555;
        }
        .password-container {
            display: flex;
            align-items: center;
        }
        code {
            background-color: #f7f7f7;
            padding: 2px 4px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-right: 5px;
            user-select: all; /* Allows easy text selection */
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Your New Channel!</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>We are excited to have you as a part of our community. Your new channel has been created, and here are your login credentials:</p>
            <ul><br>
                <li><strong>Email:</strong> {{ @$mailData['email'] }}</li>
                <li class="password-container">
                    <strong>Password:</strong>
                    <code id="password">{{ @$mailData['password'] }}</code>
                    <p class="text-muted">(Click to copy your password)</p>
                </li>
            </ul>
            <p>Thank you for joining us. If you have any questions or need assistance, feel free to reach out to us.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} MU-Updates</p>
        </div>
    </div>

    <script>
        // JavaScript to copy the password when clicked
        const passwordElement = document.getElementById('password');
        passwordElement.addEventListener('click', () => {
            const tempInput = document.createElement('input');
            tempInput.value = passwordElement.textContent;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            alert('Password has been copied to clipboard');
        });
    </script>
</body>
</html>
