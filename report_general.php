<?php
require('libs/fpdf/fpdf.php');
require_once('assets/php/database.php');

class PDF extends FPDF
{


    function Header()
    {
        // Logo
        $this->Image('assets/images/Logo.png', 20, 5, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 13);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(120, 0, iconv('UTF-8', 'windows-1252', 'ESTACIÓN EXPERIMENTAL TROPICAL PICHILINGUE - INIAP'), 0, 1, 'C');
        $this->Cell(280, 10, 'Reporte General de Saldos', 0, 0, 'C');
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(-300, 20, iconv('UTF-8', 'windows-1252', 'Fecha de Reporte:'), 0, 0, 'C');
        $this->Cell(350, 20, date('d/m/Y'), 0, 1, 'C');
        // Salto de línea
        $this->Ln(1);

        $this->SetFont('Arial', 'B', 8);
        // Títulos de las columnas
        // Títulos de las columnas
        $header = array('Cédula', 'Nombres y Apellidos', 'F. Laboral', 'Departamento', 'F. Inicio', 'F. Fin', 'Lab.', 'Fines.', 'Total');
        // Ancho de las columnas
        $widths = array(25, 65, 20, 95, 20, 20, 12, 12, 10);

        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($widths[$i], 7, iconv('UTF-8', 'windows-1252', $header[$i]) , 1, 0, 'C');
        }
        $this->Ln();

    }

    // Pie de página
    function Footer()
    {
        // Posición a 1,5 cm del final
        $this->SetY(-15);
        // Arial itálica 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    // Tabla simple
    function BasicTable($data, $widths)
    {
        // Datos
        foreach ($data as $row) {
            $i = 0;
            foreach ($row as $col) {
                $this->Cell($widths[$i], 6, iconv('UTF-8', 'windows-1252', $col), 1, 0, 'C');
                $i++;
            }
            $this->Ln();
        }
    }
}

//Captura de parámetros

$search = "";
$numRows = 0;

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}
if (isset($_GET['numRows'])) {
    $numRows = $_GET['numRows'];
}

// Consulta SQL
$where = "";
if ($search != "") {
    $where = "WHERE  
    ci_employee LIKE '%" . $search . "%' OR 
    fullname LIKE '%" . $search . "%' OR 
    name_departament LIKE '%" . $search . "%'";
}
$limit = "";
if ($numRows != 0) {
    $limit = "LIMIT " . $numRows;
}

$sql = "SELECT 
ci_employee,
fullname,
startDate_employee,
name_departament,
startDate_vacationPeriod,
endDate_vacationPeriod,
balanceWorkingDays_vacationPeriod,
balanceWeekendDays_vacationPeriod,
balanceDays_vacationPeriod
FROM vw_reportGeneral " . $where . " " . $limit;


// Títulos de las columnas
$header = array('Cédula', 'Nombres y Apellidos', 'F. Laboral', 'Departamento', 'F. Inicio', 'F. Fin', 'Lab.', 'Fin. Sem.', 'Total');
// Ancho de las columnas
$widths = array(25, 65, 20, 95, 20, 20, 12, 12, 10);

// Datos del permiso
$stmt = $conn->prepare($sql);
$stmt->execute();
//fetching all rows
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


//Generar pdf

$pdf = new PDF('L', 'mm', 'A4');

// Carga de datos
$pdf->SetFont('Arial', '', 8);
$pdf->AddPage();
$pdf->BasicTable($results, $widths);

// Generar el archivo PDF
$pdf->Output('reporte_general.pdf', 'I');
?>