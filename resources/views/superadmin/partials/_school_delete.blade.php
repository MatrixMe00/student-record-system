<form method="post" action="{{ route('admin-school.destroy') }}" class="p-6">
    @csrf
    @method("delete")

    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Are you sure you want to delete this school?') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {!! __('Once confirmed, all data about this school, including all its users, academic records, classes, etc shall also be deleted') !!}
    </p>

    <div class="mt-6">
        <x-text-input
            name="school_id"
            id="modal_school_id"
            type="hidden"
            class="mt-1 block w-3/4"
            readonly
        />

        <x-input-error :messages="$errors->get('school_id')" class="mt-2" />
    </div>

    <div class="mt-6 flex justify-end">
        <x-secondary-button type="reset" x-on:click="$dispatch('close')">
            {{ __('Cancel') }}
        </x-secondary-button>

        <x-primary-button class="ms-3 bg-red-500">
            {{ __('Proceed') }}
        </x-primary-button>
    </div>
</form>
