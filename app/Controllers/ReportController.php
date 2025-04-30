<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\EquipmentModel;
use App\Models\HistoryModel;
use App\Models\InventoryModel;
use App\Models\PatientModel;
use App\Models\RoomModel;
use App\Models\UserModel;
use CodeIgniter\Database\Config;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Roles;
use Myth\Auth\Models\GroupModel;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends BaseController
{
    protected $userModel;
    protected $groupModel;
    protected $appointmentModel;
    protected $doctorModel;
    protected $patientModel;
    protected $roomModel;
    protected $inventoryModel;
    protected $equipmentModel;
    protected $historyModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->appointmentModel = new AppointmentModel();
        $this->doctorModel = new DoctorModel();
        $this->roomModel = new RoomModel();
        $this->inventoryModel = new InventoryModel();
        $this->equipmentModel = new EquipmentModel();
        $this->patientModel = new PatientModel();
        $this->historyModel = new HistoryModel();
    }

    public function getReportUserPdf()
    {
        $params = new DataParams([
            "role" => $this->request->getGet("role"),
            "page" => $this->request->getGet("page_users"),
        ]);

        $result = $this->userModel->getFilteredUser($params);

        $data = [
            'users' => $result['users'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'groups' => $this->groupModel->findAll(),
            'params' => $params,
            'baseUrl' => base_url('report/user'),
        ];

        return view('page/report/v_report_user_pdf', $data);
    }

    public function reportUserPdf()
    {
        helper('tcpdf');
        $role = $this->request->getGet("role");

        $pdf = initTcpdf(user()->username, user()->username, "User Reports", "User Reports");

        $datas = $this->userModel->getUserByRole($role);
        // dd($datas);
        $roleName = 'All';
        $doctor = $this->doctorModel->getDoctorCountsByCategory();
        $patient = $this->patientModel->getPatientCountByType();
        if (!empty($role)) {
            $roleName = $this->groupModel->find($role)->name;
            if ($roleName == Roles::DOCTOR) {
                $patient = null;
            }
            if ($roleName == Roles::PATIENT) {
                $doctor = null;
            }
        }
        $this->generateUserPdfHtmlContent($pdf, $datas, "User Reports", $roleName, $patient, $doctor);

        // Output PDF
        $filename = 'User_Reports_' . $roleName . '_' . date('Y-m-d') . '.pdf';
        $pdf->Output($filename, 'I');
        exit;
    }

    private function generateUserPdfHtmlContent($pdf, $datas, $title, $subject, $patient, $doctor)
    {
        $titleReports = $title ?? 'User Reports';
        $subjectReports = $subject ?? '';

        $html = '<h2 style="text-align:center;">' . $titleReports . '</h2>
        <h4 style="text-align:center;">' . $subjectReports . '</h2>
      <table border="1" cellpadding="5" cellspacing="0" style="width:100%;">
        <thead>
          <tr style="background-color:#CCCCCC; font-weight:bold; text-align:center;">
            <th>No</th>
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Type</th>
          </tr>
         </thead>
         <tbody>';

        $no = 1;
        foreach ($datas as $data) {
            $html .= '
           <tr>
            <td style="text-align:center;">' . $no . '</td>
            <td>' . $data->username . '</td>
            <td>' . $data->first_name . ' ' . $data->last_name . '</td>
            <td>' . $data->email . '</td>
            <td>' . $data->role . '</td>
            <td>' . ($data->doctor_category ?? 'N/A') . '</td>
            <td>' . ($data->last_login ?? 'N/A') . '</td>
           </tr>';
            $no++;
        }

        $html .= '
        </tbody>
        </table>
                <h2 style="text-align:center; margin-top:40px;">Summary Demographic</h2>
        <div style="margin-top:5px; text-align:left;">';
        if ($subject == 'All' || $subject == Roles::ADMIN) {
            $html .= '
                <p><strong>Total Users:</strong> ' . count($datas) . '</p>';
        }

        if ($patient) {
            $html .= '<p style="margin-top:20px;"><strong>Total Patients:</strong> ' . $this->patientModel->countAll() . '</p>';

            $html .= '<ul style="margin-left:40px;">';
            foreach ($patient as $value) {
                $html .= '<li>Type <strong>' . htmlspecialchars($value->patient_type) . '</strong>: ' . $value->total . ' patients</li>';
            }
            $html .= '</ul>';
        }

        if ($doctor) {
            $html .= '<p style="margin-top:20px;"><strong>Total Doctors:</strong> ' . $this->doctorModel->countAll() . '</p>';

            $html .= '<ul style="margin-left:40px;">';
            foreach ($doctor as $value) {
                $html .= '<li>Category <strong>' . htmlspecialchars($value->category_name) . '</strong>: ' . $value->total . ' doctors</li>';
            }
            $html .= '</ul>';
        }

        $html .= '</div>';



        $html .= '
           <p style="margin-top:30px; text-align:right;">    
               Print Date: ' . date('d-m-Y H:i:s') . '<br> 
           </p>';
        $pdf->writeHTML($html, true, false, true, false, '');
    }

    public function getReportAppointmentPdf()
    {
        $params = new DataParams([
            "doctor" => $this->request->getGet("doctor"),
            "date" => $this->request->getGet("date"),
            "page" => $this->request->getGet("page_appointments"),
        ]);

        if (in_groups(Roles::DOCTOR)) {
            $doctorId = $this->doctorModel->where('user_id', user()->id)->first()->id;
            $params = new DataParams([
                "doctor" => $doctorId,
                "date" => $this->request->getGet("date"),
                "page" => $this->request->getGet("page_appointments"),
            ]);
        }

        $result = $this->appointmentModel->getSortedAppointment($params);

        $doctors = $this->doctorModel->findAll();

        $data = [
            'appointments' => $result['appointments'],
            'doctors' => $doctors,
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('report/appointment'),
        ];

        return view('page/report/v_report_appointment_pdf', $data);
    }

    public function reportAppointmentPdf()
    {
        helper('tcpdf');
        if (in_groups(Roles::ADMIN)) {
            $doctor = $this->request->getGet("doctor");
        } else if (in_groups(Roles::DOCTOR)) {
            $doctor = $this->doctorModel->where('user_id', user()->id)->first()->id;
        }
        // dd($doctor);

        $date = $this->request->getGet("date");

        $pdf = initTcpdf(user()->username, user()->username, "Appointment Reports", "Appointment Reports");

        $datas = $this->appointmentModel->getAllAppointmentsDoctor($doctor, $date);
        // dd($datas);

        $doctorName = 'All';
        if (!empty($doctor)) {
            $doctorFirstName = $this->doctorModel->find($doctor)->first_name;
            $doctorLastName = $this->doctorModel->find($doctor)->last_name;
            $doctorName = $doctorFirstName . ' ' . $doctorLastName;
        }

        $dateName = 'All';
        if (!empty($date)) {
            $dateName = $date;
        }
        $this->generateAppointmentPdfHtmlContent($pdf, $datas, "Appointment Reports", $doctorName);

        // Output PDF
        $filename = 'Appointment_Reports_' . $doctorName . '_' . 'month_' . $dateName . '_' . date('Y-m-d') . '.pdf';
        $pdf->Output($filename, 'I');
        exit;
    }

    private function generateAppointmentPdfHtmlContent($pdf, $datas, $title, $subject)
    {
        $titleReports = $title ?? 'Appointment Reports';
        $subjectReports = $subject ?? '';

        $html = '<h2 style="text-align:center;">' . $titleReports . '</h2>
        <h4 style="text-align:center;">' . $subjectReports . '</h2>
      <table border="1" cellpadding="5" cellspacing="0" style="width:100%;">
        <thead>
          <tr style="background-color:#CCCCCC; font-weight:bold; text-align:center;">
            <th>No</th>
            <th>Doctor</th>
            <th>Patient</th>
            <th>Rooms</th>
            <th>Date</th>
            <th>Reason</th>
            <th>Status</th>
          </tr>
         </thead>
         <tbody>';

        $no = 1;
        foreach ($datas as $data) {
            $html .= '
           <tr>
            <td style="text-align:center;">' . $no . '</td>
            <td>' . $data->doctorFirstName . ' ' . $data->doctorLastName . '</td>
            <td>' . $data->patientFirstName . ' ' . $data->patientLastName . '</td>
            <td>' . $data->roomName . '</td>
            <td>' . $data->date . '</td>
            <td>' . $data->reason . '</td>
            <td>' . $data->status . '</td>
           </tr>';
            $no++;
        }

        $html .= '
               </tbody>
           </table>
           
           <p style="margin-top:30px; text-align:left;">      
               Total Appointment: ' . count($datas) . ' 
           </p>
   
           <p style="margin-top:30px; text-align:right;">    
               Print Date: ' . date('d-m-Y H:i:s') . '<br> 
           </p>';
        $pdf->writeHTML($html, true, false, true, false, '');
    }

    public function getReportHistoryPdf()
    {
        $params = new DataParams([
            "doctor" => $this->request->getGet("doctor"),
            "date" => $this->request->getGet("date"),
            "page" => $this->request->getGet("page_histories"),
        ]);
        if (in_groups(Roles::DOCTOR)) {
            $doctorId = $this->doctorModel->where('user_id', user()->id)->first()->id;
            $params = new DataParams([
                "doctor" => $doctorId,
                "date" => $this->request->getGet("date"),
                "page" => $this->request->getGet("page_histories"),
            ]);
        }
        $doctors = $this->doctorModel->findAll();

        $result = $this->historyModel->getSortedHistory($params);

        $data = [
            'histories' => $result['histories'],
            'pager' => $result['pager'],
            'doctors' => $doctors,
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('report/history'),
        ];

        return view('page/report/v_report_history_pdf', $data);
    }

    public function reportHistoryPdf()
    {
        helper('tcpdf');
        if (in_groups(Roles::ADMIN)) {
            $doctor = $this->request->getGet("doctor");
        } else if (in_groups(Roles::DOCTOR)) {
            $doctor = $this->doctorModel->where('user_id', user()->id)->first()->id;
        };
        $date = $this->request->getGet("date");

        $pdf = initTcpdf(user()->username, user()->username, "History Reports", "History Reports");

        $datas = $this->historyModel->getAllHistoryDoctorPatient($doctor, $date);

        $doctorName = 'All';
        if (!empty($doctor)) {
            $doctorFirstName = $this->doctorModel->find($doctor)->first_name;
            $doctorLastName = $this->doctorModel->find($doctor)->last_name;
            $doctorName = $doctorFirstName . ' ' . $doctorLastName;
        }

        $dateName = 'All';
        if (!empty($date)) {
            $dateName = $date;
        }

        $this->generateHistoryPdfHtmlContent($pdf, $datas, $doctorName, $dateName);

        $filename = 'History_Reports_' . $doctorName . '_' . 'month_' . $dateName . '_' . date('Y-m-d') . '.pdf';
        $pdf->Output($filename, 'I');
        exit;
    }

    private function generateHistoryPdfHtmlContent($pdf, $datas, $doctorName, $dateName)
    {
        $titleReports = 'History Reports';
        $subjectReports = 'History Reports';

        $html = '<h2 style="text-align:center;">' . $titleReports . '</h2>
        <h4 style="text-align:center;">' . $subjectReports . '</h2>
      <table border="1" cellpadding="5" cellspacing="0" style="width:100%;">
         <thead>
           <tr style="background-color:#CCCCCC; font-weight:bold; text-align:center;">
            <th>No</th>
            <th>Doctor</th>
            <th>Patient</th>
            <th>Notes</th>
            <th>Prescription</th>
            <th>Documents</th>
           </tr>
         </thead>
         <tbody>';

        $no = 1;
        foreach ($datas as $data) {
            $html .= '
           <tr>
            <td style="text-align:center;">' . $no . '</td>
            <td>' . $data->doctorFirstName . ' ' . $data->doctorLastName . '</td>
            <td>' . $data->patientFirstName . ' ' . $data->patientLastName . '</td>
            <td>' . $data->notes . '</td>
            <td>' . $data->prescriptions . '</td>
            <td>' . $data->documents . '</td>
           </tr>';
            $no++;
        }

        $html .= '
         </tbody>
       </table>
       <p style="margin-top:30px; text-align:left;">      
               Total History: ' . count($datas) . ' 
           </p>
   
           <p style="margin-top:30px; text-align:right;">    
               Print Date: ' . date('d-m-Y H:i:s') . '<br> 
           </p>';

        $pdf->writeHTML($html, true, false, true, false, '');
    }



    public function getReportResourceExcel()
    {
        return view('page/report/v_report_resources_excel');
    }

    public function reportResourceExcel()
    {
        $spreadsheet = new Spreadsheet();
        $roomSheet = $spreadsheet->createSheet();
        $roomSheet->setTitle('Rooms');

        $rooms = $this->roomModel->findAll();

        $inventoriesSheet = $spreadsheet->createSheet();
        $inventoriesSheet->setTitle('Inventories');
        $inventories = $this->inventoryModel->getAssignedInventories();

        $equipmentSheet = $spreadsheet->createSheet();
        $equipmentSheet->setTitle('Equipments');
        $equipment = $this->equipmentModel->getAssignedEquipment();

        $row = 1;
        $roomSheet->setCellValue("A$row", "Rooms");
        $row++;

        $roomSheet->setCellValue("A$row", "Name")
            ->setCellValue("B$row", "Function")
            ->setCellValue("C$row", "Status");
        $row++;

        foreach ($rooms as $item) {
            $roomSheet->setCellValue("A$row", $item->name)
                ->setCellValue("B$row", $item->function)
                ->setCellValue("C$row", $item->status);
            $row++;
        }

        $row = 1;
        $inventoriesSheet->setCellValue("A$row", "Inventories");
        $row++;

        $inventoriesSheet->setCellValue("A$row", "Name")
            ->setCellValue("B$row", "Serial Number")
            ->setCellValue("C$row", "Function")
            ->setCellValue("D$row", "Status")
            ->setCellValue("E$row", "Assigned Room");
        $row++;

        foreach ($inventories as $item) {
            $inventoriesSheet
                ->setCellValue("A$row", $item->name)
                ->setCellValue("B$row", $item->serial_number)
                ->setCellValue("C$row", $item->function)
                ->setCellValue("D$row", $item->status)
                ->setCellValue("E$row", $item->room_name);
            $row++;
        }

        $row = 1;
        $equipmentSheet->setCellValue("A$row", "Equipments");
        $row++;

        $equipmentSheet->setCellValue("A$row", "Name")
            ->setCellValue("B$row", "Stock")
            ->setCellValue("C$row", "Function")
            ->setCellValue("D$row", "Status")
            ->setCellValue("E$row", "Assigned Room")
            ->setCellValue("F$row", "Stock in Room");
        $row++;

        foreach ($equipment as $item) {
            $equipmentSheet->setCellValue("A$row", $item->name)
                ->setCellValue("B$row", $item->stock)
                ->setCellValue("C$row", $item->function)
                ->setCellValue("D$row", $item->status)
                ->setCellValue("E$row", $item->room_name)
                ->setCellValue("F$row", $item->total);
            $row++;
        }

        $spreadsheet->setActiveSheetIndex(1);

        $filename = 'Room_Resources_Report.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function reportDemographicPdf()
    {
        helper('tcpdf');
    }
}
