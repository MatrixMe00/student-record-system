<x-form-container maintitle="Add Multiple Users">
    @section("sub-title")
        <p>Upload a document below</p>
        <p class="mb-4">Accepted document template is <a href="{{ asset('defaults/documents/Student List.xlsx') }}" class="text-blue-600 hover:underline">this</a></p>
    @endsection
    <x-form-element action="{{ route('users.add') }}" method="POST" enctype="multipart/form-data" >
        @csrf

        <div>
            <x-input-label value="Select User Group" />
            <x-input-select options="0" name="user_type" :value="old('user_type')" required>
                <option value="">Select a user group</option>
                <option value="student">Students</option>
            </x-input-select>
        </div>

        <div>
            <x-input-label value="Class Type" />
            <x-input-select options="0" name="program_id" :value="old('user_type')" required>
                @if (count($programs) > 0)
                    <option value="mixed">Mixed Classes</option>
                    @foreach ($programs as $program)
                        <option value="{{ $program['id'] }}">{{ $program['name'] }}</option>
                    @endforeach
                @else
                    <option value="">No Classes uploaded</option>
                @endif
            </x-input-select>
        </div>

        <div>
            <x-input-label value="Class List" />
            <x-text-input type="file" name="upload_file" :value="old('upload_file')" accept=".xls,.xlsx" required />
        </div>

        @if (count($programs) > 0)
            <x-form-button-container>
                <x-form-submit-button>Submit</x-form-submit-button>
            </x-form-button-container>
        @endif

    </x-form-element>
</x-form-container>
