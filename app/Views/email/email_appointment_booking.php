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
      <p>Dear <strong><?= $patient_name ?></strong>,</p>

      <p>Thank you for booking your appointment with <strong>Healthcare Hospital</strong>.</p>

      <p>We are pleased to confirm your appointment with the following details:</p>

      <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
        <tr>
          <td style="padding: 8px; font-weight: bold;">Patient Name:</td>
          <td style="padding: 8px;"><?= $patient_name ?></td>
        </tr>
        <tr style="background-color: #f9f9f9;">
          <td style="padding: 8px; font-weight: bold;">Doctor:</td>
          <td style="padding: 8px;"><?= $doctor_name ?></td>
        </tr>
        <tr style="background-color: #f9f9f9;">
          <td style="padding: 8px; font-weight: bold;">Date:</td>
          <td style="padding: 8px;"><?= $appointment_date ?></td>
        </tr>
        <tr>
          <td style="padding: 8px; font-weight: bold;">Time:</td>
          <td style="padding: 8px;"><?= $appointment_time ?></td>
        </tr>
        <tr style="background-color: #f9f9f9;">
          <td style="padding: 8px; font-weight: bold;">Location:</td>
          <td style="padding: 8px;">Rumah Sakit HealthCare
            Jl. Melati Raya No. 27
            Kelurahan Sukamaju, Kecamatan Serpong
            Tangerang Selatan, Banten 15310</td>
        </tr>
      </table>

      <p>Please arrive at least <strong>10-15 minutes early</strong> and bring any relevant documents or identification with you. If this is your first visit, we recommend arriving <strong>30 minutes early</strong> for registration.</p>

      <p>If you need to reschedule or have any questions, feel free to contact us at <a href="tel:0215557283">(021) 555-7283</a> or <a href="mailto:healthcare.hospital@yopmail.com">healthcare.hospital@yopmail.com</a>.</p>

      <p>We look forward to seeing you soon and supporting your health needs.</p>

      <p>Warm regards,<br>
        <strong>Administration</strong><br>
        Healthcare Hospital<br>
      </p>
    </div>
    <div class="footer">
      <p>This email is automatically sent. Please do not reply to this email.</p>
      <p>Copyright &copy; <?= date('Y') ?> Health Care</p>
    </div>
  </div>
</body>

</html>