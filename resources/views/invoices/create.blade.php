@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="mb-4">Proforma Invoice</h2>

                <form id="invoiceForm" action="{{ route('invoices.generate-pdf') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Invoice No</label>
                            <input type="text" name="invoice_no" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control shadow-none" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bill To</label>
                        <textarea name="bill_to" class="form-control shadow-none" rows="4" required></textarea>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <table class="table" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th>Items</th>
                                        <th>Quantity</th>
                                        <th>Price (Rp)</th>
                                        <th>Amount (Rp)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="item-row">
                                        <td>
                                            <input type="text" name="items[0][description]"
                                                class="form-control shadow-none" required>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][quantity]"
                                                class="form-control shadow-none quantity" value="1" min="1"
                                                required>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][price]"
                                                class="form-control shadow-none price" value="0" min="0"
                                                required>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][amount]"
                                                class="form-control shadow-none amount" value="0" readonly>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td><span id="total">Rp 0</span></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <button type="button" class="btn btn-primary btn-sm" id="addRow">Add Item</button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Generate PDF</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/invoices/createItems.js') }}"></script>
@endpush
