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
        $this->Image('assets/images/Logo_header.png', 10, 5, 0, 0);
        $this->Ln(15);

    }

    // Pie de página
    function Footer()
    {
        // Posición a 1,5 cm del final
        $this->SetY(-30);
        // Logotipo
        $this->Image('assets/images/Logo_footer.png', 0, 270, 0, 0);
    }

    // Tabla simple
    function BasicTable($dataEmployee, $dataAdmin, $rmu)
    {
        // Array de nombres de meses en español
        $meses = array(
            'enero',
            'febrero',
            'marzo',
            'abril',
            'mayo',
            'junio',
            'julio',
            'agosto',
            'septiembre',
            'octubre',
            'noviembre',
            'diciembre'
        );
        $texto = $dataEmployee['name_departament'];
        $textoReemplazado = str_replace('Proyecto DAPME', 'Proyecto de Inversión Desarrollo de Agrotecnologías como Estrategias ante la Amenaza de Enfermedades que afecten la Producción de Musáceas en el Ecuador', $texto);

        if ($textoReemplazado === $texto) {
            // No se encontró la coincidencia, mostrar el contenido original
            $textoReemplazado = $texto;
        }


        // Obtener la fecha actual en formato español
        $fecha = date('d') . ' de ' . $meses[date('n') - 1] . ' de ' . date('Y');
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "INIAP-UATH-" . date('Y') . "-". $dataEmployee['countCertificate_numberPeriod'] ."-CER"), 0, 1, 'R');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Mocache, " . $fecha), 0, 1, 'R');
        $this->Ln();
        $this->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', "Ingeniero/a " . $dataAdmin['fullname_inv2'] . ", Responsable de Administración del Talento Humano, a petición del interesado"), 0, 'L', 0);
        $this->SetFont('Arial', 'B', 11);
        $this->Ln();
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "CERTIFICA:"), 0, 1, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', "Que " . strtoupper($dataEmployee['fullname']) . " con cédula de ciudadanía Nro." . $dataEmployee['ci_employee'] . ", labora en esta Institución con la siguiente Información:"), 0, 'L', 0);
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Cargo"), 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', $dataEmployee['name_jobTitle']), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Periodo"), 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', $dataEmployee['startDate_employee'] ." - " . date('d/m/Y')), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Área / Unidad"), 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', $textoReemplazado), 0, 'L', 0);
       
        if ($rmu) {
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Remuneración"), 0, 1, 'L');
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "$" . $dataEmployee['salary_employee']), 0, 1, 'L');
        }
        $this->Ln(5);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Tal como consta en los registros de esta Unidad."), 0, 1, 'L');
        $this->Ln(5);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Es todo en cuanto puedo infromar en honor a la verdad."), 0, 1, 'L');
        $this->Ln(5);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Atentamente."), 0, 1, 'C');
        $this->Ln(30);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 5, iconv('UTF-8', 'windows-1252', "Ing. ". $dataAdmin['fullname_inv2']), 0, 1, 'C');
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
        $nombre = 'Ing.'. $dataAdmin['fullname_inv'];
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
    $rmu = filter_var($_GET['rmu'], FILTER_VALIDATE_BOOLEAN);
}

$sql_temp = "CALL pa_incrementCountCertificate()";
$stmt = $conn->prepare($sql_temp);
$stmt->execute();

$sql = "SELECT 
id_employee,
ci_employee,
fullname,
fullname_inv,
fullname_inv2,
name_jobTitle,
startDate_employee,
name_departament,
salary_employee,
countCertificate_numberPeriod
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
$pdf->BasicTable($dataEmployee, $dataAdmin, $rmu);

// Generar el archivo PDF
$pdf->Output('certificado.pdf', 'I');
?>