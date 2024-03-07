<div class="flex flex-col items-center justify-center md:flex-row gap-4">
    {{-- set pending status --}}
    @if (in_array($result->status, ["submitted", "submit", "accepted", "accept", "rejected", "reject"]))
        <button type="submit" value="pending" name="submit"
            class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
                tracking-wide text-white capitalize group transform bg-blue-500 rounded-md
                hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300
                focus:ring-opacity-50">
            <span>Save for Editing</span>
            <i class="far fa-edit group-hover:mr-2 transition-all duration-500"></i>
        </button>
    @endif

    {{-- set save status --}}
    @if (in_array($result->status, ["submitted", "submit", "rejected", "reject"]))
        <button type="submit" value="accepted" name="submit"
        class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
            tracking-wide text-white capitalize group transform bg-teal-500 rounded-md
            hover:bg-teal-600 focus:outline-none focus:ring focus:ring-teal-300
            focus:ring-opacity-50">
        <span>Approve Results</span>
        <i class="fas fa-check group-hover:mr-2 transition-all duration-500"></i>
    </button>
    @endif

    {{-- set reject status --}}
    @if (in_array($result->status, ["submitted", "submit", "accepted", "accept"]))
        <button type="submit" value="reject" name="submit"
        class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
            tracking-wide text-white capitalize group transform bg-red-500 rounded-md
            hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-300
            focus:ring-opacity-50">
        <span>Reject Results</span>
        <i class="fas fa-times group-hover:mr-2 transition-all duration-500"></i>
    </button>
    @endif

    @if ($result->status == "pending")
        <p class="border p-2 text-center w-full cursor-default">
            {{ "Results has not been submitted for review." }}
        </p>
    @endif
</div>
