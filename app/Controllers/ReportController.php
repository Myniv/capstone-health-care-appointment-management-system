<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\EquipmentModel;
use App\Models\InventoryModel;
use App\Models\RoomModel;
use App\Models\UserModel;
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
    protected $roomModel;
    protected $inventoryModel;
    protected $equipmentModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->appointmentModel = new AppointmentModel();
        $this->doctorModel = new DoctorModel();
        $this->roomModel = new RoomModel();
        $this->inventoryModel = new InventoryModel();
        $this->equipmentModel = new EquipmentModel();
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

        $pdf = initTcpdf(user()->username, user()->username, "User Reports", "User Reports", );

        $datas = $this->userModel->getUserByRole($role);
        // dd($datas);
        $roleName = 'All';
        if (!empty($role)) {
            $roleName = $this->groupModel->find($role)->name;
        }
        $this->generateUserPdfHtmlContent($pdf, $datas, "User Reports", $roleName);

        // Output PDF
        $filename = 'User_Reports_' . $roleName . '_' . date('Y-m-d') . '.pdf';
        $pdf->Output($filename, 'I');
        exit;
    }

    private function generateUserPdfHtmlContent($pdf, $datas, $title, $subject)
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
           
           <p style="margin-top:30px; text-align:left;">      
               Total Users: ' . count($datas) . ' 
           </p>
   
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
            "page" => $this->request->getGet("page_appointment"),
        ]);

        $result = $this->appointmentModel->getSortedAppointment($params);

        $data = [
            'appointment' => $result['appointment'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('reports/appointment'),
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
        ;
        $date = $this->request->getGet("date");

        $pdf = initTcpdf(user()->username, user()->username, "User Reports", "User Reports", );

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
        $this->generateUserPdfHtmlContent($pdf, $datas, "Appointment Reports", $doctorName . '_' . $dateName);

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
           
           <p style="margin-top:30px; text-align:left;">      
               Total Users: ' . count($datas) . ' 
           </p>
   
           <p style="margin-top:30px; text-align:right;">    
               Print Date: ' . date('d-m-Y H:i:s') . '<br> 
           </p>';
        $pdf->writeHTML($html, true, false, true, false, '');
    }

    public function reportResourceExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $inventories = $this->roomModel->getAssignedInventories();

        $equipment = $this->roomModel->getAssignedEquipment();

        $unassignedInventory = $this->inventoryModel->getUnassignedInventories();

        $unassignedEquipment = $this->equipmentModel->getUnassignedEquipment();


        $row = 1;
        $sheet->setCellValue("A$row", "Room Name")
            ->setCellValue("B$row", "Inventory Name")
            ->setCellValue("C$row", "Serial Number")
            ->setCellValue("D$row", "Status");
        $row++;

        foreach ($inventories as $item) {
            $sheet->setCellValue("A$row", $item['roomName'])
                ->setCellValue("B$row", $item['inventoryName'])
                ->setCellValue("C$row", $item['serial_number'])
                ->setCellValue("D$row", $item['inventoryStatus']);
            $row++;
        }

        $row++;
        $sheet->setCellValue("A$row", "Room Name")
            ->setCellValue("B$row", "Equipment Name")
            ->setCellValue("C$row", "Total")
            ->setCellValue("D$row", "Status");
        $row++;

        foreach ($equipment as $item) {
            $sheet->setCellValue("A$row", $item['roomName'])
                ->setCellValue("B$row", $item['equipmentName'])
                ->setCellValue("C$row", $item['total'])
                ->setCellValue("D$row", $item['equipmentStatus']);
            $row++;
        }

        $row++;
        $sheet->setCellValue("A$row", "Unassigned Inventory");
        $row++;
        $sheet->setCellValue("A$row", "Name")
            ->setCellValue("B$row", "Serial Number")
            ->setCellValue("C$row", "Status");
        $row++;

        foreach ($unassignedInventory as $item) {
            $sheet->setCellValue("A$row", $item['name'])
                ->setCellValue("B$row", $item['serial_number'])
                ->setCellValue("C$row", $item['status']);
            $row++;
        }

        $row++;
        $sheet->setCellValue("A$row", "Unassigned Equipment");
        $row++;
        $sheet->setCellValue("A$row", "Name")
            ->setCellValue("B$row", "Stock")
            ->setCellValue("C$row", "Status");
        $row++;

        foreach ($unassignedEquipment as $item) {
            $sheet->setCellValue("A$row", $item['name'])
                ->setCellValue("B$row", $item['stock'])
                ->setCellValue("C$row", $item['status']);
            $row++;
        }

        // Output file
        $filename = 'Room_Resources_Report.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
}
