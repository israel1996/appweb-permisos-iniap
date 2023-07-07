<?php
require('libs/fpdf/fpdf.php');
require_once('assets/php/database.php');

class PDF extends FPDF
{

    function Header()
    {
        // Logo
        $this->Image('assets/images/Logo_header.png', 10, 5, 60);
        $this->Ln(15);

    }

    // Pie de página
    function Footer()
    {
        // Posición a 1,5 cm del final
        $this->SetY(-30);
        // Logotipo
        $this->Image('assets/images/Logo_footer.png', 170, 270, 20);

        // Texto del pie de página
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Instituto Nacional de Investigaciones Agropecuarias") , 0, 1, 'L');
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Dirección: Km 5 Vía Quevedo - El Empalme, Cantón Mocache,"), 0, 1, 'L');
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Provincia de los Rios") , 0, 1, 'L');
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Télefonos: 593-5-2783128 / 2783044"), 0, 1, 'L');
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "www.iniap.gob.ec"), 0, 1, 'L');
    }

    // Tabla simple
    function BasicTable($data, $widths)
    {
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "INIAP-UATH-2023-37-CER") , 0, 1, 'R');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Mocache, 09 de junio de 2023") , 0, 1, 'R');
        $this->Ln();
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "El Ing. Carlos Macías Loor, Responsable de Administración del Talento Humano, a petición de la interesada") , 0, 1, 'L');
        $this->SetFont('Arial', 'B', 11);
        $this->Ln();
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "CERTIFICA:") , 0, 1, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', "Que LLANOS SALAS MARIA ALEJANDRA con cédula de ciudadanía Nro. 12062470772, labora en esta Institución con la siguiente Información"), 0, 'L', 0);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Tal como consta en los registros de esta Unidad.") , 0, 1, 'L');
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Es todo en cuanto puedo infromar en honor a la verdad.") , 0, 1, 'L');
        $this->Ln();
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Atentamente.") , 0, 1, 'C');
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
    LOWER(name_departament) LIKE LOWER('%" . $search . "%') OR 
    balanceWorkingDays_vacationPeriod LIKE '%" . $search . "%' OR 
    balanceWeekendDays_vacationPeriod LIKE '%" . $search . "%' OR 
    balanceDays_vacationPeriod LIKE '%" . $search . "%' ";
}
$limit = "";
if ($numRows != 0) {
    $limit = "LIMIT " . $numRows;
}

$sql = "SELECT 
name_departament,
balanceWorkingDays_vacationPeriod,
balanceWeekendDays_vacationPeriod,
balanceDays_vacationPeriod
FROM vw_reportDepartament " . $where . " " . $limit;



// Títulos de las columnas
$header = array('Departamento', 'Laborables', 'Fine de Semana', 'Saldos Totales');
// Ancho de las columnas
$widths = array(100, 30, 30, 30);

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