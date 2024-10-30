<?php

namespace App\Http\Controllers;
use App\Models\Inventory;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InventoryExportController extends Controller
{
    //
    public function exportToExcel()
    {
        // $inventories = Inventory::where('archived', '0')->get();
        // $inventory = Inventory::all();
        // if ($inventory->isEmpty()) {
        //     Session::flash('alert-danger', 'No items available in the inventory to export.');
        //     return redirect()->back();
        // }
    
        // $options = [
        //     'defaultFont' => 'sans-serif', 
        //     'isHtml5ParserEnabled' => true, 
        //     'isRemoteEnabled' => true, 
        //     'paper' => 'A4', 
        //     'orientation' => 'landscape' 
        // ];
        // $pdf = PDF::loadView('admin/inventory_pdf', compact('inventories'))
        //    ->setOptions($options)
        //    ->setPaper('a4', 'landscape');
    
        // return $pdf->download('inventory.pdf');

        $inventories = Inventory::where('archived', '0')->get();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="inventory.xls"');
        header('Cache-Control: max-age=0');

        echo '<table border="1">';
        echo '<tr>';
        echo '<th>Product Code</th>';
        echo '<th>Product Name</th>';
        echo '<th>Product Type</th>';
        echo '<th>Category</th>';
        echo '<th>Brand</th>';
        echo '<th>Quantity</th>';
        echo '<th>Status</th>';
        echo '<th>Price</th>';
        echo '<th>Description</th>';
        echo '</tr>';

        foreach ($inventories as $inventory) {
            echo '<tr>';
            echo '<td>' . $inventory->product_code . '</td>';
            echo '<td>' . $inventory->product_name . '</td>';
            echo '<td>' . $inventory->product_type . '</td>';
            echo '<td>' . $inventory->category . '</td>';
            echo '<td>' . $inventory->brand . '</td>';
            echo '<td>' . $inventory->quantity . '</td>';
            echo '<td>' . $inventory->status . '</td>';
            echo '<td>' . $inventory->price . '</td>';
            echo '<td>' . $inventory->description . '</td>';
            echo '</tr>';
        }

        echo '</table>';
        exit;

    }
}
