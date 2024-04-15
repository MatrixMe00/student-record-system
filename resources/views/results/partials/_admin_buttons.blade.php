@php
    // use this to measure if the document cannot be touched any longer
    if($remark_head?->status == "accepted" && $remark_head?->transferred == true){
        $hide_strict = true;
    }else{
        $hide_strict = false;
    }
@endphp
<div class="flex flex-col items-center justify-center md:flex-row gap-4">
    {{-- set pending status --}}
    @if (!$hide_strict && in_array(($result->status ?? $remark_head->status), ["submitted", "accepted", "rejected", "reject"]))
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
    @if (!$hide_strict && in_array(($result->status ?? $remark_head->status), ["submitted", "rejected", "reject"]))
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
    @if (!$hide_strict && in_array(($result->status ?? $remark_head->status), ["submitted", "accepted"]))
        <button type="submit" value="rejected" name="submit"
        class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
            tracking-wide text-white capitalize group transform bg-red-500 rounded-md
            hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-300
            focus:ring-opacity-50">
        <span>Reject Results</span>
        <i class="fas fa-times group-hover:mr-2 transition-all duration-500"></i>
    </button>
    @endif

    @if (($result->status ?? $remark_head->status) == "pending")
        <p class="border p-2 text-center w-full cursor-default">
            {{ "Results has not been submitted for review." }}
        </p>
    @endif

    @if ($hide_strict)
        <p class="border p-2 text-center w-full cursor-default">
            {{ "Work on this slip has been finished. No further changes can be made" }}
        </p>
    @endif
</div>
