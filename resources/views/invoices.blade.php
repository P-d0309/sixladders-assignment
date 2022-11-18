@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Invocies</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 text-center">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Invoice No</th>
                                <th scope="col">Invoice_Date</th>
                                <th scope="col">CustomerName</th>
                                <th scope="col">TotalAmount</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoices as $invoice)
                                <tr>
                                    <th scope="row">{{ $invoice->Invoice_no }}</th>
                                    <td>{{ $invoice->Invoice_Date }}</td>
                                    <td>{{ $invoice->CustomerName }}</td>
                                    <td>{{ $invoice->TotalAmount }}</td>
                                    <td><button class="btn btn-info view-invoice" data-id="{{ $invoice->Invoice_Id }}"><i
                                                class="fa fa-eye"></i></button></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <h3 class="text-center">No Invoice are found. Please add it from <a href="{{ route('home') }}">here</a>
                                        </h3>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="invoiceModalLabel">Invocie Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="attach-invoice-data">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('PageJS')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(() => {
            $('.view-invoice').click(function() {
                const invoiceID = $(this).data('id');
                const url = `{{ route('getInvoice') }}/${invoiceID}`

                $.ajax({
                    url,
                    success: function(result) {
                        $("#invoiceModal").modal("show");
                        $('#attach-invoice-data').html(result);
                    }
                })
            })
        })
    </script>
@endpush
