<?php
require('libs/fpdf/fpdf.php');
require_once('assets/php/database.php');

class PDF extends FPDF
{

    // Contenido del informe para la primera mitad
    function Content1($data)
    {
        $status = array('V' => 'Validado', 'P' => 'Pendiente', 'R' => 'Rechazado');

        $this->SetAutoPageBreak(false);

        // Logo
        $this->Image('assets/images/Logo.png', 10, 2, 30);

        // Título del encabezado
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, -5, iconv('UTF-8', 'windows-1252', 'ESTACIÓN EXPERIMENTAL TROPICAL PICHILINGUE - INIAP'), 0, 1, 'C');
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 13);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', 'Permiso Nº '). $data['issueNumber_permission'] .'-'. date('Y'), 0, 1, 'C');
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(170, 5, iconv('UTF-8', 'windows-1252', 'Fecha de Emisión:'), 0, 0, 'C');
        $this->Cell(-122, 5, $data['issueDate_permission'], 0, 1, 'C');
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Cédula de Ciudadanía:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, $data['ci_employee'], 0, 1);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Nombres y Apellidos:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', $data['name_employee'].' '.$data['lastName_employee']), 0, 1);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Departamento:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', $data['name_departament']), 0, 1);

        $this->SetFont('Arial', 'BU', 10);
        $this->Cell(45, 10, iconv('UTF-8', 'windows-1252', 'Motivo de la Salida:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, iconv('UTF-8', 'windows-1252', $data['name_reason']), 0, 1);

        $this->SetFont('Arial', 'BU', 10);
        $this->Cell(45, 4, iconv('UTF-8', 'windows-1252', 'Observaciones:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 4, iconv('UTF-8', 'windows-1252', $data['observation_permission']));

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'FECHAS DE PERMISO'), 0, 1, 'C');

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Fecha Inicial:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 5,  $data['startDateTime_permission'], 0); // Aumente el ancho de la celda a 40 para dar más espacio para la fecha

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Fecha Final:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, $data['endDateTime_permission'], 0, 1); // Aumente el ancho de la celda a 40 para dar más espacio para la fecha

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Tiempo tomado:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, $data['workingDays_permission'].' dias laborables y '. $data['weekendDays_permission'] .' fines de semana', 0, 1); // Aumente el ancho de la celda a 40 para dar más espacio para la fecha

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 15, iconv('UTF-8', 'windows-1252', 'SALDOS ACTUALES:'), 0);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(60, 15, $data['balanceWorkingDays_vacationPeriod'].' dias laborables y '. $data['balanceWeekendDays_vacationPeriod'] .' fines de semana', 0, 1); // Aumente el ancho de la celda a 40 para dar más espacio para la fecha



        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 10, 'Estado de Permiso:', 0);

        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(255, 0, 0); // Establecer el color de texto a rojo
        $this->Cell(0, 10, $status[$data['state_permission']], 0, 1); // Aumente el ancho de la celda a 40 para dar más espacio para la fecha
        $this->SetTextColor(0, 0, 0); // Restablecer el color de texto a negro

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 4, 'Comentario:', 0);

        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 4, iconv('UTF-8', 'windows-1252', $data['adminObservation_permission']));


        $this->Ln(15);
        // Posición inicial
        $initial_position = 20;
        $cell_width = 60;

        // Firma del Solicitante
        $this->SetFont('Arial', '', 10);
        $this->SetX($initial_position);
        $this->Cell($cell_width, 10, '__________________', 0, 0, 'C');
        $this->SetX($initial_position);
        $this->Cell($cell_width, 20, 'SOLICITANTE', 0, 0, 'C');

        // Firma del Jefe Inmediato
        $this->SetX($initial_position + $cell_width);
        $this->Cell($cell_width, 10, '__________________', 0, 0, 'C');
        $this->SetX($initial_position + $cell_width);
        $this->Cell($cell_width, 20, 'JEFE INMEDIATO', 0, 0, 'C');

        // Firma UATH
        $this->SetX($initial_position + $cell_width * 2);
        $this->Cell($cell_width, 10, '__________________', 0, 0, 'C');
        $this->SetX($initial_position + $cell_width * 2);
        $this->Cell($cell_width, 20, 'UATH', 0, 0, 'C');

        //$this->Ln();

        $this->Line(0, $this->GetPageHeight() / 2, $this->GetPageWidth(), $this->GetPageHeight() / 2);

    }

    // Contenido del informe para la segunda mitad
    function Content2($data)
    {
       
        $status = array('V' => 'Validado', 'P' => 'Pendiente', 'R' => 'Rechazado');


        $this->SetY($this->GetPageHeight() / 2 - 1);
        // Logo
        $this->Image('assets/images/Logo.png', 10, $this->GetPageHeight() / 2 + 2, 30);

        // Título del encabezado
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 20, iconv('UTF-8', 'windows-1252', 'ESTACIÓN EXPERIMENTAL TROPICAL PICHILINGUE - INIAP'), 0, 0, 'C');

        $this->SetY($this->GetPageHeight() / 2 + 9);

        $this->SetFont('Arial', 'B', 13);

        $this->Cell(0, 10,iconv('UTF-8', 'windows-1252', 'Permiso Nº '). $data['issueNumber_permission'] .'-'. date('Y'), 0, 1, 'C');

        $this->SetFont('Arial', 'I', 10);
        $this->Cell(170, 0, iconv('UTF-8', 'windows-1252', 'Fecha de Emisión:'), 0, 0, 'C');
        $this->Cell(-122, 0, $data['issueDate_permission'], 0, 1, 'C');
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Cédula de Ciudadanía:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, $data['ci_employee'], 0, 1);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Nombres y Apellidos:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', $data['name_employee'].' '.$data['lastName_employee']), 0, 1);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Departamento:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', $data['name_departament']), 0, 1);

        $this->SetFont('Arial', 'BU', 10);
        $this->Cell(45, 10, iconv('UTF-8', 'windows-1252', 'Motivo de la Salida:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, iconv('UTF-8', 'windows-1252', $data['name_reason']), 0, 1);

        $this->SetFont('Arial', 'BU', 10);
        $this->Cell(45, 4, iconv('UTF-8', 'windows-1252', 'Observaciones:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 4, iconv('UTF-8', 'windows-1252', $data['observation_permission']));

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'FECHAS DE PERMISO'), 0, 1, 'C');

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Fecha Inicial:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 5,  $data['startDateTime_permission'], 0); // Aumente el ancho de la celda a 40 para dar más espacio para la fecha

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Fecha Final:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, $data['endDateTime_permission'], 0, 1); // Aumente el ancho de la celda a 40 para dar más espacio para la fecha

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Tiempo tomado:'), 0);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, $data['workingDays_permission'].' dias laborables y '. $data['weekendDays_permission'] .' fines de semana', 0, 1); // Aumente el ancho de la celda a 40 para dar más espacio para la fecha

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 15, iconv('UTF-8', 'windows-1252', 'SALDOS ACTUALES:'), 0);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(60, 15, $data['balanceWorkingDays_vacationPeriod'].' dias laborables y '. $data['balanceWeekendDays_vacationPeriod'] .' fines de semana', 0, 1); // Aumente el ancho de la celda a 40 para dar más espacio para la fecha



        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 10, 'Estado de Permiso:', 0);

        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(255, 0, 0); // Establecer el color de texto a rojo
        $this->Cell(0, 10, $status[$data['state_permission']], 0, 1); // Aumente el ancho de la celda a 40 para dar más espacio para la fecha
        $this->SetTextColor(0, 0, 0); // Restablecer el color de texto a negro

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 4, 'Comentario:', 0);

        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 4, iconv('UTF-8', 'windows-1252', $data['adminObservation_permission']));


        $this->Ln(15);
        // Posición inicial
        $initial_position = 20;
        $cell_width = 60;

        // Firma del Solicitante
        $this->SetFont('Arial', '', 10);
        $this->SetX($initial_position);
        $this->Cell($cell_width, 10, '__________________', 0, 0, 'C');
        $this->SetX($initial_position);
        $this->Cell($cell_width, 20, 'SOLICITANTE', 0, 0, 'C');

        // Firma del Jefe Inmediato
        $this->SetX($initial_position + $cell_width);
        $this->Cell($cell_width, 10, '__________________', 0, 0, 'C');
        $this->SetX($initial_position + $cell_width);
        $this->Cell($cell_width, 20, 'JEFE INMEDIATO', 0, 0, 'C');

        // Firma UATH
        $this->SetX($initial_position + $cell_width * 2);
        $this->Cell($cell_width, 10, '__________________', 0, 0, 'C');
        $this->SetX($initial_position + $cell_width * 2);
        $this->Cell($cell_width, 20, 'UATH', 0, 0, 'C');
    }

}


// Crear instancia de PDF
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddPage();

if (isset($_GET['idPermiss'])) {
    $idPermiss = $_GET['idPermiss'];
} else {
    $idPermiss = 0;
}
// Datos del permiso

$sql = "SELECT * FROM vw_permissEmployeeReport WHERE id_permission =". $idPermiss;

$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();



// Agregar contenido a la primera mitad
$pdf->Content1($results);


// Agregar contenido a la segunda mitad

$pdf->Content2($results);


// Generar el archivo PDF
$pdf->Output('informe_permiso.pdf', 'I');
?>