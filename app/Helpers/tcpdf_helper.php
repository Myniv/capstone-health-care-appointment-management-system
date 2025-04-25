<?php
function initTcpdf($creator, $author, $title, $subject)
{
    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

    $pdf->SetCreator($creator ?? 'User');
    $pdf->SetAuthor($author ?? 'Administrator');
    $pdf->SetTitle($title ?? 'User Reports');
    $pdf->SetSubject($subject ?? 'User Reports');

    //To set the image in pdf, 
    //set this : define ('K_PATH_IMAGES', FCPATH. '/');
    //in this path : vendor/tecnickcom/tcpdf/config/tcpdf_config:
    $pdf->SetHeaderData('', 10, 'Health Care', 'Appointment', [0, 0, 0], [0, 64, 128]);
    $pdf->setFooterData([0, 64, 0], [0, 64, 128]);

    $pdf->setHeaderFont(['helvetica', '', 12]);
    $pdf->setFooterFont(['helvetica', '', 8]);

    $pdf->SetMargins(15, 20, 15);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);

    $pdf->SetAutoPageBreak(true, 25);

    $pdf->SetFont('helvetica', '', 10);

    $pdf->AddPage();

    return $pdf;
}