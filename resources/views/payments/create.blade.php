<x-app-layout>
    <x-slot name="header">
        <x-app-header>Make Payment [{{ ucfirst($type) }}]</x-app-header>
    </x-slot>

    @section("title", "Make Payment")

    <x-app-main>
        @if ($amount <= 0)
            <x-empty-div>{{ __("Payment disallowed. Invalid amount value provided. Contact the admin for assistance.") }}</x-empty-div>
        @else
            <x-form-container maintitle="Make Payment for Service" subtitle="Use the form below to make payment for the service requested" class="bg-zinc-100">
                <x-form-element action="" method="POST" id="paymentForm">
                    {{-- contact name --}}
                    <div>
                        <x-input-label for="contact_name">Fullname</x-input-label>
                        <x-text-input name="contact_name" required id="contact_name" :value="old('contact_name')" placeholder="Your fullname" />
                        <x-input-error :messages="$errors->get('contact_name')" class="mt-2" />
                    </div>

                    {{-- contact email --}}
                    <div>
                        <x-input-label for="contact_email">Email</x-input-label>
                        <x-text-input name="contact_email" type="email" required id="contact_email" :value="old('contact_email')" placeholder="Your email" />
                        <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                    </div>

                    {{-- contact phone --}}
                    <div>
                        <x-input-label for="contact_phone">Phone Number</x-input-label>
                        <x-text-input name="contact_phone" type="tel" required pattern="[0-9]+" id="contact_phone" :value="old('contact_phone')" placeholder="Your phone number [0123456789]" />
                        <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
                    </div>

                    {{-- payment type --}}
                    <div>
                        <x-input-label for="payment_type">Payment Type</x-input-label>
                        <x-text-input name="payment_type" id="payment_type" :value="ucfirst($type)" placeholder="Your email" readonly />
                        <x-input-error :messages="$errors->get('payment_type')" class="mt-2" />
                    </div>

                    {{-- contact email --}}
                    <div>
                        <x-input-label for="amount">Amount (GHC)</x-input-label>
                        <x-text-input name="amount" id="amount" :value="$amount" placeholder="Your email" readonly />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <x-form-button-container>
                        <x-form-submit-button>Make Payment</x-form-submit-button>
                    </x-form-button-container>

                </x-form-element>
            </x-form-container>

            @push("scripts")
                <script src="https://js.paystack.co/v1/inline.js"></script>
                <script>
                    const paymentForm = $('#paymentForm');
                    paymentForm.submit(function(e){
                        e.preventDefault();
                        payWithPaystack();

                    })

                    function payWithPaystack() {
                        let handler = PaystackPop.setup({
                            key: "{{ env('PAYSTACK_PUBLIC_KEY') }}",
                            email: $("#paymentForm input#contact_email").val(),
                            amount: parseFloat($("#paymentForm input#amount").val()) * 100,
                            email: 'safosah00@gmail.com',
                            currency: 'GHS',
                            metadata: {
                                custom_fields: [
                                    {
                                        display_name: "Mobile Number",
                                        variable_name: "contact_phone",
                                        value: $("#contact_phone").val()
                                    },
                                    {
                                        display_name: "Customer's Name",
                                        variable_name: "contact_name",
                                        value: $("#contact_name").val()
                                    },
                                    {
                                        display_name: "School ID",
                                        variable_name: "school_id",
                                        value: "sch_" + {{ session('school_id') }}
                                    },
                                    {
                                        display_name: "Student ID",
                                        variable_name: "student_id",
                                        value: "stud_" + {{ auth()->user()->id }}
                                    },
                                    {
                                        display_name: "Payment Type",
                                        variable_name: "payment_type",
                                        value: "{{ $type }}"
                                    }
                                ]
                            },
                            // label: "Optional string that replaces customer email"
                            onClose: function(){
                                alert('Window closed.');
                            },
                            callback: function(response){
                                let message = 'Payment complete! Reference: ' + response.reference;
                                alert(message);

                                location.href="{{ route('paystack.callback') }}" + response.redirecturl
                            }
                        });

                        handler.openIframe();
                    }
                </script>
            @endpush
        @endif
    </x-app-main>
</x-app-layout>
