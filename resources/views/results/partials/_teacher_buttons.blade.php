@if ($edit_once)
    <div class="flex flex-col items-center justify-center md:flex-row gap-4">
        <button type="submit" value="save" name="submit"
            class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
                tracking-wide text-white capitalize group transform bg-teal-500 rounded-md
                hover:bg-teal-400 focus:outline-none focus:ring focus:ring-teal-300
                focus:ring-opacity-50">
            <span>Save For Later</span>
            <i class="far fa-save group-hover:mr-2 transition-all duration-500"></i>
        </button>
        <button type="submit" value="submit" name="submit"
            class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
                tracking-wide text-white capitalize group transform bg-blue-500 rounded-md
                hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300
                focus:ring-opacity-50">
            <span>Submit as Final</span>
            <i class="fas fa-angle-right group-hover:mr-2 transition-all duration-500"></i>
        </button>
    </div>
@endif
