<?php
session_start();
require_once 'config.php';

// Authenticate Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied.");
}

// Set limits
ini_set('memory_limit', '256M');

// Include PhpSpreadsheet classes
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$spreadsheet = new Spreadsheet();

// Style configurations
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '1C2431'], // Deep Navy
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ]
];

$titleStyle = [
    'font' => ['bold' => true, 'size' => 15, 'color' => ['rgb' => 'AB8E5B']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]
];

$borderStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => 'D1D5DB'],
        ],
    ],
];

// ==========================================
// SHEET 1: ORDERS & COMMISSIONS
// ==========================================
$sheet1 = $spreadsheet->getActiveSheet();
$sheet1->setTitle('Orders & Sales');

// Title block
$sheet1->setCellValue('A1', 'HIRANYA ART HOUSE - PLATFORM SALES REPORT');
$sheet1->getStyle('A1')->applyFromArray($titleStyle);
$sheet1->setCellValue('A2', 'Generated on: ' . date('d M Y, H:i'));
$sheet1->getStyle('A2')->getFont()->setItalic(true);

// Headers
$headers = ['Order ID', 'Artwork Title', 'Buyer Username', 'Artist Username', 'Sales Type', 'Amount (Rp)', 'Commission (Rp)', 'Transaction Date', 'Payment Status'];
$sheet1->fromArray($headers, NULL, 'A4');
$sheet1->getStyle('A4:I4')->applyFromArray($headerStyle);
$sheet1->getRowDimension(4)->setRowHeight(25);

// Fetch data
$orders_sql = "
    SELECT orders.id, artworks.title AS art_title, buyers.username AS buyer_name, artists.username AS artist_name, 
           orders.order_type, orders.amount, orders.commission_amount, orders.created_at, orders.payment_status
    FROM orders
    JOIN artworks ON orders.artwork_id = artworks.id
    JOIN users AS buyers ON orders.buyer_id = buyers.id
    LEFT JOIN users AS artists ON artworks.artist_id = artists.id
    ORDER BY orders.id ASC
";
$orders_res = mysqli_query($conn, $orders_sql);
$rowIdx = 5;
$totalAmount = 0;
$totalCommission = 0;

while ($row = mysqli_fetch_assoc($orders_res)) {
    $sheet1->setCellValue('A' . $rowIdx, $row['id']);
    $sheet1->setCellValue('B' . $rowIdx, $row['art_title']);
    $sheet1->setCellValue('C' . $rowIdx, '@' . $row['buyer_name']);
    $sheet1->setCellValue('D' . $rowIdx, $row['artist_name'] ? '@' . $row['artist_name'] : 'Hiranya Collection');
    $sheet1->setCellValue('E' . $rowIdx, ucfirst(str_replace('_', ' ', $row['order_type'])));
    
    $sheet1->setCellValue('F' . $rowIdx, (double)$row['amount']);
    $sheet1->getStyle('F' . $rowIdx)->getNumberFormat()->setFormatCode('#,##0');
    
    $sheet1->setCellValue('G' . $rowIdx, (double)$row['commission_amount']);
    $sheet1->getStyle('G' . $rowIdx)->getNumberFormat()->setFormatCode('#,##0');
    
    $sheet1->setCellValue('H' . $rowIdx, date('d M Y H:i', strtotime($row['created_at'])));
    $sheet1->setCellValue('I' . $rowIdx, ucfirst($row['payment_status']));
    
    if ($row['payment_status'] === 'verified') {
        $totalAmount += $row['amount'];
        $totalCommission += $row['commission_amount'];
    }
    
    $rowIdx++;
}

// Summary Row
$sheet1->setCellValue('E' . $rowIdx, 'Total (Verified):');
$sheet1->getStyle('E' . $rowIdx)->getFont()->setBold(true);
$sheet1->setCellValue('F' . $rowIdx, $totalAmount);
$sheet1->getStyle('F' . $rowIdx)->getNumberFormat()->setFormatCode('#,##0');
$sheet1->getStyle('F' . $rowIdx)->getFont()->setBold(true);
$sheet1->setCellValue('G' . $rowIdx, $totalCommission);
$sheet1->getStyle('G' . $rowIdx)->getNumberFormat()->setFormatCode('#,##0');
$sheet1->getStyle('G' . $rowIdx)->getFont()->setBold(true);

// Auto size columns
foreach (range('A', 'I') as $col) {
    $sheet1->getColumnDimension($col)->setAutoSize(true);
}
$sheet1->getStyle('A4:I' . ($rowIdx - 1))->applyFromArray($borderStyle);

// ==========================================
// SHEET 2: ACTIVE AUCTIONS
// ==========================================
$sheet2 = $spreadsheet->createSheet();
$sheet2->setTitle('Active Auctions');

$sheet2->setCellValue('A1', 'HIRANYA ART HOUSE - ACTIVE AUCTIONS SUMMARY');
$sheet2->getStyle('A1')->applyFromArray($titleStyle);

$headers2 = ['Auction ID', 'Artwork Title', 'Artist Username', 'Start Bid (Rp)', 'Current Bid (Rp)', 'End Time', 'Bids Count'];
$sheet2->fromArray($headers2, NULL, 'A3');
$sheet2->getStyle('A3:G3')->applyFromArray($headerStyle);
$sheet2->getRowDimension(3)->setRowHeight(25);

$auc_sql = "
    SELECT auctions.id, artworks.title AS art_title, users.username AS artist_name, 
           auctions.start_bid, auctions.current_bid, auctions.end_time,
           (SELECT COUNT(*) FROM bids WHERE bids.auction_id = auctions.id) as bids_count
    FROM auctions
    JOIN artworks ON auctions.artwork_id = artworks.id
    LEFT JOIN users ON artworks.artist_id = users.id
    WHERE auctions.status = 'active'
    ORDER BY auctions.id ASC
";
$auc_res = mysqli_query($conn, $auc_sql);
$rowIdx2 = 4;
while ($row = mysqli_fetch_assoc($auc_res)) {
    $sheet2->setCellValue('A' . $rowIdx2, $row['id']);
    $sheet2->setCellValue('B' . $rowIdx2, $row['art_title']);
    $sheet2->setCellValue('C' . $rowIdx2, $row['artist_name'] ? '@' . $row['artist_name'] : 'Hiranya Collection');
    
    $sheet2->setCellValue('D' . $rowIdx2, (double)$row['start_bid']);
    $sheet2->getStyle('D' . $rowIdx2)->getNumberFormat()->setFormatCode('#,##0');
    
    $sheet2->setCellValue('E' . $rowIdx2, (double)$row['current_bid']);
    $sheet2->getStyle('E' . $rowIdx2)->getNumberFormat()->setFormatCode('#,##0');
    
    $sheet2->setCellValue('F' . $rowIdx2, date('d M Y H:i', strtotime($row['end_time'])));
    $sheet2->setCellValue('G' . $rowIdx2, (int)$row['bids_count']);
    
    $rowIdx2++;
}

foreach (range('A', 'G') as $col) {
    $sheet2->getColumnDimension($col)->setAutoSize(true);
}
if ($rowIdx2 > 4) {
    $sheet2->getStyle('A3:G' . ($rowIdx2 - 1))->applyFromArray($borderStyle);
}

// Set header response
$writer = new Xlsx($spreadsheet);
$filename = "hiranya_sales_report_" . date('Y-m-d') . ".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit();
?>
