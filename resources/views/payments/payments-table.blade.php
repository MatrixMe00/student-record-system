<x-table-component title="Your Payment History" class="px-2" screens="">
    @section("thead")
        <thead>
            <tr>
                <x-thead-data>Reference</x-thead-data>
                <x-thead-data>Contact Name</x-thead-data>
                <x-thead-data>Contact Phone</x-thead-data>
                <x-thead-data>Contact Email</x-thead-data>
                <x-thead-data>Amount Paid</x-thead-data>
                <x-thead-data>Payment Method</x-thead-data>
                <x-thead-data>Purchase Date</x-thead-data>
                <x-thead-data>Expiry Date</x-thead-data>
            </tr>
        </thead>
    @endsection

    <tbody>
        @foreach ($payments as $payment)
            <tr>
                <x-table-data>{{ $payment->reference }}</x-table-data>
                <x-table-data>{{ ucwords(strtolower($payment->contact_name)) }}</x-table-data>
                <x-table-data>{{ $payment->contact_phone }}</x-table-data>
                <x-table-data>{{ $payment->contact_email }}</x-table-data>
                <x-table-data>GHC {{ $payment->amount }}</x-table-data>
                <x-table-data>{{ str_replace(["-","_"], " ", $payment->payment_method) }}</x-table-data>
                <x-table-data>{{ date("M d, Y", strtotime($payment->created_at)) }}</x-table-data>
                <x-table-data>{{ date("M d, Y", strtotime($payment->expiry_date)) }}</x-table-data>
            </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <x-thead-data>Total Payments</x-thead-data>
            <x-table-data colspan="7">{{ $payments->count() }}</x-table-data>
        </tr>
    </tfoot>
</x-table-component>
