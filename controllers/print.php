<?php
session_start();
require("./db_connection.php");

require('./fpdf/fpdf.php');
date_default_timezone_set('Asia/Manila');

// Check if order_id and order_date are set in the POST request
if (!isset($_POST['order_id']) || !isset($_POST['order_date'])) {
    exit("Error: order_id or order_date is not set.");
}

$order_id = $_POST['order_id'];
$order_date = $_POST['order_date'];

class PDF extends FPDF
{
    private $order_id;
    private $order_date;

    public function __construct($orientation, $unit, $size, $order_id, $order_date)
    {
        parent::__construct($orientation, $unit, $size);
        $this->order_id = $order_id;
        $this->order_date = $order_date;
    }

    // Page header
    function Header()
    {
        // $this->Image('.png', 25, 5, 30);
        $this->Ln(10);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Helvetica', 'I', 8);
        $this->Cell(50, 5, date('Y/m/d - H:i A', strtotime($this->order_date)), 0);
        $this->Cell(20, 5, $this->order_id, 0, 1, 'R');
    }
}

// Instanciation of inherited class with parameters for both parent and child
$pdf = new PDF('P', 'mm', array(80, 250), $order_id, $order_date);
// Instanciation of inherited class
// $pdf = new PDF('P', 'mm', array(80, 250));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(5, 0, 5);
$pdf->Ln(15);

// Receipt content
$pdf->SetFont('Helvetica', 'B', 12); 
$pdf->Cell(0, 5, 'Tom\'s Chicken House', 0, 1, 'C');
$pdf->SetFont('Helvetica', '', 11); 

$pdf->Ln(3);
$pdf->Cell(0, 5, 'Icon one bldg, Sanchez st.,', 0, 1, 'C');
$pdf->Cell(0, 5, 'San Jose City', 0, 1, 'C');
$pdf->Cell(0, 5, 'Nueva Ecija', 0, 1, 'C');

$pdf->Ln(3);
$pdf->Cell(0, 5, 'Contact: 09655628076', 0, 1, 'C');

$query = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $order_id);
$stmt->execute();
$result1 = $stmt->get_result();
$order = $result1->fetch_assoc();

$pdf->Ln(5);
$pdf->Cell(0, 5, 'Cashier: Jamaica Sambrano', 0, 1, 'L');
$pdf->Cell(0, 5, '-----------------------------------------------------', 0, 1, 'L');
$pdf->Cell(0, 5, $order['order_method'], 0, 1, 'L');
$pdf->Cell(0, 5, '-----------------------------------------------------', 0, 1, 'L');
$stmt->close();
// QUERY
$query = "SELECT oi.*, i.* FROM orderItems as oi INNER JOIN items as i ON oi.item_id = i.item_id WHERE oi.order_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $order_id);
$stmt->execute();
$result = $stmt->get_result();

$counter = 0;
while($order_item = $result->fetch_assoc()){
    $pdf->Cell(50, 5, $order_item['item_name'], 0);
    $pdf->Cell(20, 5, "P" . number_format($order_item['item_total'],2), 0, 1, 'R');
    $pdf->Cell(60, 5, $order_item['quantity'] . " x P" . number_format($order_item['price'], 2), 0);
    
    $counter++;
    if ($counter != $result->num_rows) {
        $pdf->Ln(10); // Add line break if it's not the last element
    } else {
        $pdf->Ln(5);
        $pdf->Cell(0, 5, '-----------------------------------------------------', 0, 1, 'L');
    }
}
$stmt->close();

$query = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $order_id);
$stmt->execute();
$result1 = $stmt->get_result();
$order = $result1->fetch_assoc(); 
// Receipt content
$pdf->SetFont('Helvetica', 'B', 15); 
$pdf->Cell(50, 5, 'Total', 0);
$pdf->Cell(20, 5, 'P' . number_format($order['total'], 2), 0, 1, 'R');
$pdf->SetFont('Helvetica', '', 11);
$pdf->Ln(5);
$pdf->Cell(50, 5, 'Cash', 0);
$pdf->Cell(20, 5, 'P' . number_format($order['cash'], 2), 0, 1, 'R');
$pdf->Cell(50, 5, 'Change', 0);
$pdf->Cell(20, 5, 'P' . number_format($order['change_amount'], 2), 0, 1, 'R');
$pdf->Cell(0, 5, '-----------------------------------------------------', 0, 1, 'L');

$stmt->close();

$pdf->Ln(2);
$pdf->Cell(0, 5, 'Thank you and Come again!', 0, 1, 'C');

$pdf->Ln(5);
$pdf->Cell(0, 5, 'Like us on facebook & instagram:', 0, 1, 'C');
$pdf->Cell(0, 5, 'Tom\'s Chicken House', 0, 1, 'C');

$pdf->Ln(5);
$pdf->Cell(0, 5, '*** OFFICIAL RECEIPT ***', 0, 1, 'C');

$pdf->Output();