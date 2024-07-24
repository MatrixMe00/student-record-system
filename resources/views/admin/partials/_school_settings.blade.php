<x-form-container padding="" subtitle="Use the form below to update any notable details">
    <x-form-element method="POST" action="{{ route('school-settings.modify') }}"
        :showErrors="old('submit') == 'settings'" enctype="multipart/form-data"
        action="{{ route('school.update') }}"
    >
        @method("PUT")

        <!-- Name of school -->
        <div>
            <x-input-label for="school_name" :value="__('School Name')" />
            <x-text-input id="school_name" type="text" name="school_name" :value="dual_old('settings','school_name') ?? $school->school_name" placeholder="Name of School" autofocus required />
            <x-input-error :messages="dual_error('settings','school_name',$errors)" class="mt-2" />
        </div>

        <!-- School Slug -->
        <div>
            <x-input-label for="school_slug" :value="__('School Abbreviation')" />
            <x-text-input id="school_slug" type="text" name="school_slug" :value="dual_old('settings','school_slug') ?? $school->school_slug" placeholder="Slug name for school" required />
            <x-input-error :messages="dual_error('settings','school_slug',$errors)" class="mt-2" />
        </div>

        <!-- School Email -->
        <div>
            <x-input-label for="school_email" :value="__('School Email')" />
            <x-text-input id="school_email" type="email" name="school_email" :value="dual_old('settings','school_email') ?? $school->school_email" placeholder="example@email.com" required />
            <x-input-error :messages="dual_error('settings','school_email',$errors)" class="mt-2" />
        </div>

        <!-- Headmaster or Headmistress -->
        <div>
            <x-input-label for="school_head" :value="__('Headmaster / Headmistress name')" />
            <x-text-input id="school_head" type="text" name="school_head" :value="dual_old('settings','school_head') ?? $school->school_head" placeholder="Headmaster / Headmistress" required />
            <x-input-error :messages="dual_error('settings','school_head',$errors)" class="mt-2" />
        </div>

        <!-- School Logo -->
        <div>
            <x-input-label for="logo_path" :value="__('School Logo')" />
            <x-text-input id="logo_path" type="file" accept="image" name="logo_path" :value="dual_old('settings','logo_path')" />
            <x-text-input name="logo_current" :value="$school->logo_path" type="hidden" />
            <a href="{{ url('storage/'.$school->logo_path) }}" class="text-xs text-blue-400 hover:underline hover:underline-offset-4" target="_blank">View Existing</a>
            <x-input-error :messages="dual_error('settings','logo_path',$errors)" class="mt-2" />
        </div>

        <!-- School Location / Circuit -->
        <div>
            <x-input-label for="circuit" :value="__('Circuit')" />
            <x-text-input id="circuit" type="text" name="circuit" :value="dual_old('settings','circuit') ?? $school->circuit" placeholder="Circuit of School" required />
            <x-input-error :messages="dual_error('settings','circuit',$errors)" class="mt-2" />
        </div>

        <!-- District -->
        <div>
            <x-input-label for="district" :value="__('District')" />
            <x-text-input id="district" type="text" name="district" :value="dual_old('settings','district') ?? $school->district" placeholder="Circuit District" required />
            <x-input-error :messages="dual_error('settings','district',$errors)" class="mt-2" />
        </div>

        <!-- GPS Address -->
        <div>
            <x-input-label for="gps_address" :value="__('GPS Address')" />
            <x-text-input id="gps_address" type="text" name="gps_address" :value="dual_old('settings','gps_address') ?? $school->gps_address" placeholder="XX-XXX-XXXX [Include the dashes]" required />
            <x-input-error :messages="dual_error('settings','gps_address',$errors)" class="mt-2" />
        </div>

        <!-- Box Number -->
        <div>
            <x-input-label for="box_number" :value="__('School Box Number')" />
            <x-text-input id="box_number" type="text" name="box_number" :value="dual_old('settings','box_number') ?? $school->box_number" placeholder="P.O.Box XX" required />
            <x-input-error :messages="dual_error('settings','box_number',$errors)" class="mt-2" />
        </div>

        <!-- School type -->
        <div>
            <x-input-label for="school_type" :value="__('Type of School')" />
            @php
                $options = [
                    ["id" => "public", "name" => "Public School"],
                    ["id" => "private", "name" => "Private School"]
                ]
            @endphp
            <x-input-select :options="$options" default="Select A Type" :value="dual_old('settings','school_type') ?? $school->school_type" name="school_type" id="school_type" />
            <x-input-error :messages="dual_error('settings','school_type',$errors)" class="mt-2" />
        </div>

        <!-- School description -->
        <div class="md:col-span-2">
            <x-input-label for="description" :value="__('School Description')" />
            <x-input-textarea id="description" type="text" name="description" class="min-h-32 max-h-44" :value="dual_old('settings','description') ?? $school->description" placeholder="A short description about the school" required />
            <x-input-error :messages="dual_error('settings','description',$errors)" class="mt-2" />
        </div>

        <x-form-button-container>
            <x-form-submit-button icon="fas fa-save" name="submit" value="settings">
                Update
            </x-form-submit-button>
        </x-form-button-container>
    </x-form-element>
</x-form-container>
