<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class GeneralController extends Controller
{
    public function index() {
        return view('index');
    }

    public function invoices() {
        $invoices = Invoice::get();
        return view('invoices', compact('invoices'));
    }

    public function getInvoice(Request $request, $id) {
        $invoice = Invoice::with(['InvoiceDetails', 'InvoiceDetails.Product'])->findOrFail($id);

        return view('invoiceDetails', compact('invoice'))->render();
    }
}
