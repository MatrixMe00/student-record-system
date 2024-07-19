<x-form-container subtitle="Use this form to set up internal functionalities of your school account">
    <x-form-element method="POST" action="{{ route('school-settings.modify') }}" :showErrors="old('submit') == 'school_settings'">
        <x-text-input name="school_id" value="{{ $school->id }}" type="hidden" />
        <x-text-input name="active_tab" value="internal" type="hidden" />
        @php
            $reject = ["system_price", "max_form", "roll_number"];
        @endphp
        @foreach ($school_settings as $count => $settings)
            @if (!in_array($settings["name"], $reject))
                <div>
                    <x-input-label for="{{ $settings['name'] }}">{{ __($settings["text"]) }}</x-input-label>
                    <x-text-input type="hidden" name="settings_name[]" value="{{ $settings['name'] }}" />
                    <x-text-input
                        type="{{ $settings['input_type'] }}"
                        id="{{ $settings['name'] }}" name="value[]"
                        required :value="dual_old('school_settings', 'value.'.$count) ?? $settings['value']"
                        :oa="insert_options($settings['options'])"
                        placeholder="{{ $settings['placeholder'] }}"
                    />

                    <x-input-error :messages="dual_error('school_settings', 'value.'.$count, $errors)" />
                </div>
            @endif
        @endforeach

        <x-form-button-container>
            <x-form-submit-button icon="fas fa-save" name="submit" value="school_settings">
                Save
            </x-form-submit-button>
        </x-form-button-container>
    </x-form-element>
</x-form-container>
