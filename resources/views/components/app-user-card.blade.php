@props(["user"])

@php
    $status_text = $user->user->is_active ? "Deactivate" : "Activate";
    if(auth()->user()->id != $user->user_id){
        $username = "/user/{$user->user->username}";
        $edit = $username."/edit";
        $delete = $username."/delete";
        $deactivate = $username."/status";
    }else{
        $edit = $delete = $deactivate = "javascript:void(0)";
        $disable = "text-gray-400 hover:bg-gray-100";
    }

@endphp

<div class="sm:w-56 w-full bg-white shadow rounded border border-transparent hover:border-blue-500 cursor-pointer">
    <div class="h-32 w-full checker-bg flex items-center justify-center p-4 text-blue-500">
      <x-application-logo />
    </div>

    <div class="p-4 border-t border-gray-200" x-data="{showMore:false}" x-cloak="">
      <div class="flex items-center justify-between relative">
        <h1 class="text-gray-600 font-medium">{{ $user->lname." ".$user->oname }}</h1>
        <button class="text-gray-500 hover:text-gray-900" @click="showMore=!showMore">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
          </svg>
        </button>
        <div x-show="showMore" class="absolute rounded right-0 p-1 border top-[100%] w-32 bg-white">
            <ul class="list-none">
                <li class="p-2 {{ $disable ?? 'hover:bg-gray-300' }}"><a href="{{ $edit }}" class="block">Edit</a></li>
                <li class="p-2 {{ $disable ?? 'hover:bg-gray-300' }}"><a href="{{ $delete }}" class="block">Delete</a></li>
                <li class="p-2 {{ $disable ?? 'hover:bg-gray-300' }}"><a href="{{ $deactivate }}" class="block">{{ $status_text }}</a></li>
                @if ($user->user->role_id == 4)
                    <li class="p-2 {{ $disable ?? 'hover:bg-gray-300' }}"><a href="/teacher/subject-assign/{{ $user->user_id }}" class="block">Subjects</a></li>
                @endif
            </ul>
        </div>
      </div>
      <p class="text-gray-400 text-sm my-1">Active</p>
      @if (!is_null($user->school_id) && is_null(session('school_id')))
        <p class="text-gray-400 text-sm my-1">{{ $user->school->school_name }}</p>
      @endif
    </div>
  </div>
