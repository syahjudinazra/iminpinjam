<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('invoices.create');
    }

    public function generatePDF(Request $request)
    {
        $data = $request->validate([
            'invoice_no' => 'required|string',
            'date' => 'required|date',
            'bill_to' => 'required|string',
            'items' => 'required|array',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.amount' => 'required|numeric|min:0',
        ]);

        $pdf = PDF::loadView('invoices.pdf', [
            'invoice' => $data,
            'total' => collect($data['items'])->sum('amount'),
            'formatted_date' => Carbon::parse($data['date'])->format('d-m-Y'),
        ]);

        return $pdf->download('invoice-' . $data['invoice_no'] . '.pdf');
    }
}
