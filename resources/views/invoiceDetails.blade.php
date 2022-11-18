<table class="table">
    <thead>
        <tr>
            <th scope="col">Invoice Number</th>
            <th scope="col">Product Name</th>
            <th scope="col">Rate</th>
            <th scope="col">Unit</th>
            <th scope="col">Qty</th>
            <th scope="col">Discount</th>
            <th scope="col">Net Amount</th>
            <th scope="col">Total Amount</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($invoice->InvoiceDetails as $InvoiceDetail)
        <tr>
            <th scope="row">{{ $invoice->Invoice_no }}</th>
            <td>{{ $InvoiceDetail->Product->Product_Name }}</td>
            <td>{{ $InvoiceDetail->Rate }}</td>
            <td>{{ $InvoiceDetail->Unit }}</td>
            <td>{{ $InvoiceDetail->Qty }}</td>
            <td>{{ $InvoiceDetail->Disc_Percentage }}</td>
            <td>{{ $InvoiceDetail->NetAmount }}</td>
            <td>{{ $InvoiceDetail->TotalAmount }}</td>
        </tr>
        @empty
        @endforelse
    </tbody>
</table>
