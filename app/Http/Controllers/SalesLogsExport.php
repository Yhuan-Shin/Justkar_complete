<?php

namespace App\Http\Controllers;
use App\Models\Sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class SalesLogsExport extends Controller
{
    //
    // public function exportToPdf()
    // {
    //     $sales = Sales::with('payment')->where('quantity', '>', 0)->get(); 

    //     $options = [
    //         'defaultFont' => 'sans-serif', 
    //         'isHtml5ParserEnabled' => true, 
    //         'isRemoteEnabled' => true, 
    //         'paper' => 'A4', 
    //         'orientation' => 'landscape' 
    //     ];
    //     $pdf = PDF::loadView('admin.sales_pdf', compact('sales'))
    //              ->setPaper('A4', 'landscape')
    //              ->setOptions($options);
    //     return $pdf->download('sales.pdf');
    // }
    public function exportToExcel()
{
    // Fetch sales data
    $sales = Sales::with('payment')->where('quantity', '>', 0)->get(); 

    // Set headers for Excel file download
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="sales.xls"');
    header('Cache-Control: max-age=0');

    // Start outputting HTML for the Excel file
    echo '<table border="1">';
    echo '<tr>';
    echo '<th>Product Code</th>';
    echo '<th>Product Name</th>';
    echo '<th>Product Type</th>';
    echo '<th>Category</th>';
    echo '<th>Brand</th>';
    echo '<th>Size</th>';
    echo '<th>Quantity</th>';
    echo '<th>Price</th>';
    echo '<th>Total Price</th>';
    echo'<th>Date</th>';
    echo '</tr>';

    foreach ($sales as $sale) {
        echo '<tr>';
        echo '<td>' . $sale->product_code . '</td>';
        echo '<td>' . $sale->product_name . '</td>'; // Adjust according to your fields
        echo '<td>' . $sale->product_type . '</td>';
        echo '<td>' . $sale->category . '</td>';
        echo '<td>' . $sale->brand . '</td>';
        echo '<td>' . $sale->size . '</td>';
        echo '<td>' . $sale->quantity . '</td>';
        echo '<td>' . $sale->price . '</td>';
        echo '<td>' . $sale->total_price . '</td>'; 
        echo '<td>' . $sale->created_at->timezone('Asia/Manila')->format('m/d/Y, h:i A') . '</td>';
        echo '</tr>';
    }

    echo '</table>';
    exit; // Terminate the script after outputting the Excel file
}


    
    

}
