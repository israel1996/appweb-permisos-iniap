<?php
session_start();
require('libs/fpdf/fpdf.php');
require_once('assets/php/database.php');
require_once('assets/class/User.php');

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
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Instituto Nacional de Investigaciones Agropecuarias"), 0, 1, 'L');
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Dirección: Km 5 Vía Quevedo - El Empalme, Cantón Mocache,"), 0, 1, 'L');
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Provincia de los Rios"), 0, 1, 'L');
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Télefonos: 593-5-2783128 / 2783044"), 0, 1, 'L');
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "www.iniap.gob.ec"), 0, 1, 'L');
    }

    // Tabla simple
    function BasicTable($dataEmployee, $dataAdmin)
    {
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "INIAP-UATH-" . date('Y') . "-37-CER"), 0, 1, 'R');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Mocache, 09 de junio de 2023"), 0, 1, 'R');
        $this->Ln();
        $this->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', "El o La Ingeniero/a ". $dataAdmin['fullname'] .", Responsable de Administración del Talento Humano, a petición de la interesada"), 0, 'L', 0);
        $this->SetFont('Arial', 'B', 11);
        $this->Ln();
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "CERTIFICA:"), 0, 1, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', "Que LLANOS SALAS MARIA ALEJANDRA con cédula de ciudadanía Nro. 12062470772, labora en esta Institución con la siguiente Información"), 0, 'L', 0);
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Cargo"), 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Cargo"), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Periodo"), 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Periodo"), 0, 0, 'L');
        $this->Cell(2, 5, iconv('UTF-8', 'windows-1252', "Periodo"), 0, 0, 'L');
        $this->Cell(-150, 5, iconv('UTF-8', 'windows-1252', "Periodo"), 0, 0, 'L');
        $this->Cell(-150, 5, iconv('UTF-8', 'windows-1252', "Periodo"), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Área / Unidad"), 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Área / Unidad"), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Remuneración"), 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Remuneración"), 0, 1, 'L');

        $this->Ln(5);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Tal como consta en los registros de esta Unidad."), 0, 1, 'L');
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Es todo en cuanto puedo infromar en honor a la verdad."), 0, 1, 'L');
        $this->Ln(5);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Atentamente."), 0, 1, 'C');
        $this->Ln(30);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Ing. Carlos Macías Loor"), 0, 1, 'C');
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "UNIDAD DE ADMINISTRACIÓN DEL TALENTO HUMANO"), 0, 1, 'C');
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "ESTACIÓN EXPERIMENTAL TROPICAL PICHILINGUE"), 0, 1, 'C');
        $this->Ln(5);
        // Encabezados de las columnas
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 7, iconv('UTF-8', 'windows-1252', "ACCIÓN"), 1, 0, 'C');
        $this->Cell(60, 7, iconv('UTF-8', 'windows-1252', "NOMBRE"), 1, 0, 'C');
        $this->Cell(100, 7, iconv('UTF-8', 'windows-1252', "CARGO"), 1, 1, 'C'); // El último '1' es para crear una nueva línea después de esta celda

        // Cambiar a fuente normal para los datos
        $this->SetFont('Arial', '', 10);

        // Definir los datos
        $accion = 'Elaborado por';
        $nombre = 'Ing. Carlos Macias';
        $cargo = 'Responsable de Administracion de Talento Humano';

        // Agregar los datos a la tabla
        $this->Cell(30, 7, iconv('UTF-8', 'windows-1252', $accion), 1, 0, 'C');
        $this->Cell(60, 7, iconv('UTF-8', 'windows-1252', $nombre), 1, 0, 'C');
        $this->Cell(100, 7, iconv('UTF-8', 'windows-1252', $cargo), 1, 1, 'C'); // El último '1' es para crear una nueva línea después de esta celda
    }
}

//Captura de parámetros
$idAdmin = 0;
$idEmployee = 0;
$rmu = false;

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $idAdmin = $user->getIdEmployee();
} 

if (isset($_GET['idEmployee'])) {
    $idEmployee = $_GET['idEmployee'];
}
if (isset($_GET['rmu'])) {
    $rmu = $_GET['rmu'];
}

$sql = "SELECT 
id_employee,
ci_employee,
fullname,
name_jobTitle,
startDate_employee,
name_departament,
salary_employee
FROM vw_dataEmloyeeCertificate ";

$sql_employee = $sql . "WHERE id_employee = " . $idEmployee;
$sql_admin = $sql . "WHERE id_employee = " . $idAdmin;

$stmt = $conn->prepare($sql_employee);
$stmt->execute();
$dataEmployee = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare($sql_admin);
$stmt->execute();
$dataAdmin = $stmt->fetch(PDO::FETCH_ASSOC);


//Generar pdf

$pdf = new PDF('P', 'mm', 'A4');

// Carga de datos
$pdf->SetFont('Arial', '', 10);
$pdf->AddPage();
$pdf->BasicTable($dataEmployee, $dataAdmin);

// Generar el archivo PDF
$pdf->Output('certificado.pdf', 'I');
?>