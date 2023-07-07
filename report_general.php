<?php
require('libs/fpdf/fpdf.php');
require_once('assets/php/database.php');

class PDF extends FPDF
{


    function Header()
    {
        // Logo
        $this->Image('assets/images/Logo.png', 10, 5, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 13);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 0, 'Reporte General de Saldos', 0, 0, 'C');
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(-50, 10, iconv('UTF-8', 'windows-1252', 'Fecha de Reporte:'), 0, 0, 'C');
        $this->Cell(100, 10, date('d/m/Y'), 0, 1, 'C');
        // Salto de línea
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 10);
        // Títulos de las columnas
        $header = array('CI Empleado', 'Nombres y Apellidos', 'Tipo de Código', 'Saldo de Vacaciones');
        // Ancho de las columnas
        $widths = array(30, 80, 40, 40);

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
    LOWER(fullname) LIKE LOWER('%" . $search . "%') OR 
    LOWER(name_codeType) LIKE LOWER('%" . $search . "%') OR 
    balanceDays_vacationPeriod LIKE '%" . $search . "%' ";
}
$limit = "";
if ($numRows != 0) {
    $limit = "LIMIT " . $numRows;
}

$sql = "SELECT 
ci_employee,
fullname,
name_codeType,
balanceDays_vacationPeriod
FROM vw_reportGeneral " . $where . " " . $limit;




// Títulos de las columnas
$header = array('CI Empleado', 'Nombres y Apellidos', 'Tipo de Código', 'Saldo de Vacaciones');
// Ancho de las columnas
$widths = array(30, 80, 40, 40);

// Datos del permiso
$stmt = $conn->prepare($sql);
$stmt->execute();
//fetching all rows
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


//Generar pdf

$pdf = new PDF('P', 'mm', 'A4');

// Carga de datos
$pdf->SetFont('Arial', '', 10);
$pdf->AddPage();
$pdf->BasicTable($results, $widths);

// Generar el archivo PDF
$pdf->Output('reporte_general.pdf', 'I');
?>