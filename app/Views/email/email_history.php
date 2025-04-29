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

        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 5px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
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
                Below is the summary of your appointment with Dr. <?= $doctor_name ?> on
                <?= $appointment_date ?> at <?= $appointment_time ?>.
            </p>

            <div>
                <p class="section-title">Reason for Visit</p>
                <p><?= $reason ?></p>

                <p class="section-title">Doctor's Notes</p>
                <p><?= nl2br($notes) ?></p>

                <p class="section-title">Prescriptions</p>
                <p><?= nl2br($prescriptions) ?></p>

            </div>

            <p>If you have any questions or need follow-up care, feel free to contact our clinic.</p>
            <p>Sincerely,<br>Health Care Team</p>
        </div>

        <div class="footer">
            <p>This email is automatically sent. Please do not reply to this email.</p>
            <p>Copyright &copy; <?= date('Y') ?> Health Care</p>
        </div>
    </div>
</body>

</html>