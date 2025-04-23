<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\AppointmentModel;
use App\Models\SettingModel;
use App\Models\PatientModel;
use App\Models\DoctorModel;

class SendAppointmentReminders extends BaseCommand
{
    protected $group = 'Appointments';
    protected $name = 'reminder:send';
    protected $description = 'Send appointment reminders for H-7, H-3, and H-1';

    public function run(array $params)
    {
        $settingModel = new SettingModel();
        $appointmentModel = new AppointmentModel();
        $patientModel = new PatientModel();
        $doctorModel = new DoctorModel();

        $setting = $settingModel->where('key', 'reminder_days')->first();

        if (!$setting) {
            CLI::error('Reminder settings not found.');
            return;
        }

        $days = explode(',', $setting->value);
        $today = date('Y-m-d');

        foreach ($days as $day) {
            $targetDate = date('Y-m-d', strtotime("+$day days"));

            $appointments = $appointmentModel
                ->where('date', $targetDate)
                ->where('status', 'on going') // Optional
                ->orWhere('status', 'On Going') // Optional
                ->findAll();
            CLI::error("Appointments for $targetDate (H-$day): " . count($appointments));


            foreach ($appointments as $appt) {
                $patient = $patientModel->find($appt->patient_id);
                $doctor = $doctorModel->find($appt->doctor_id);

                if ($patient && $doctor) {
                    // $this->sendEmailReminder($patient, $doctor, $appt, $day);
                    $this->emailAppointmentTemplate($doctor, $patient, $day, $appt);
                    CLI::write("Reminder sent to {$patient->email} for appointment on {$appt->date} (H-$day)");
                }
            }
        }
    }

    protected function sendEmailReminder($patient, $doctor, $appointment, $day)
    {
        $email = \Config\Services::email();
        $email->setTo($patient->email);
        $email->setSubject("Reminder: Your Appointment in $day Day(s)");

        $message = "
            <p>Dear {$patient->first_name},</p>
            <p>This is a friendly reminder that you have an appointment scheduled in <strong>$day day(s)</strong>:</p>
            <ul>
                <li><strong>Date:</strong> {$appointment->date}</li>
                <li><strong>Doctor:</strong> Dr. {$doctor->first_name}</li>
                <li><strong>Reason:</strong> {$appointment->reason_for_visit}</li>
            </ul>
            <p>Thank you!</p>
        ";

        $email->setMessage($message);
        $email->setMailType('html');
        $email->send();
    }



    private function emailAppointmentTemplate($doctor, $patient, $day, $appointment)
    {
        $email = service('email');
        $email->setTo($patient->email);
        $email->setCC($doctor->email);
        $email->setSubject("Reminder: Your Appointment in $day Day(s)");

        $appointment_datetime = strtotime($appointment->date);

        // Example: Friday, April 25, 2025
        $appointment_date = date('l, F j, Y', $appointment_datetime);

        // Example: 12:00 AM
        $appointment_time = date('g:i A', $appointment_datetime);


        $data = [
            'title' => "Appointment Reminder",
            'patient_name' => $patient->first_name . " " . $patient->last_name,
            'doctor_name' => $doctor->first_name . " " . $doctor->last_name,
            'appointment_date' => $appointment_date,
            'appointment_time' => $appointment_time,
        ];

        $email->setMessage(view('email/email_appointment_template', $data));

        $email->send();
    }
}
