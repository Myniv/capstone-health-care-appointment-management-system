<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .header {
            background-color: rgb(0, 0, 0);
            padding: 5px;
            text-align: center;
            color: white;
        }

        .content {
            padding: 20px;
        }

        .footer {
            background-color: rgb(0, 0, 0);
            padding: 5px;
            text-align: center;
            font-size: 12px;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Forgot Password</h2>
        </div>
        <div class="content">
            <p>Someone requested a password reset at this email address for <?= site_url() ?>.</p>

            <p>To reset the password use this code or URL and follow the instructions.</p>

            <p>Your Code: <?= $hash ?></p>

            <p>Visit the <a href="<?= url_to('reset-password') . '?token=' . $hash ?>">Reset Form</a>.</p>

            <br>

            <p>If you did not request a password reset, you can safely ignore this email.</p>

            <div class="footer">
                <p>This email is automatically sent. Please do not reply to this email.</p>
                <p>Copyright &copy; <?= date('Y') ?> Health Care</p>
            </div>
        </div>
</body>

</html>