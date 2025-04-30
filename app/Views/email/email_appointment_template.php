<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
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
            <h2><?= $title ?></h2>
        </div>
        <div class="content">
            <p>Dear <?= $patient_name ?>,</p>
            <p>
                This is a friendly reminder about your upcoming appointment with <?= $doctor_name ?> at
                <?= $appointment_date ?> on <?= $appointment_time ?>.
            </p>
            <p>
                For a smoother visit, please arrive 10-15 minutes..
            </p>
            <p>We look forward to seeing you!</p>
            <p>Sincerely,<br>Health Care</p>
        </div>
        <div class="footer">
            <p>This email is automatically sent. Please do not reply to this email.</p>
            <p>Copyright &copy; <?= date('Y') ?> Health Care</p>
        </div>
    </div>
</body>

</html>