@props(["tabledata" => null, "title" => "", "thead" => [], "tbody" => []])
<div {{ $attributes->merge(["class"=>"w-full xl:w-8/12 px-4 mx-auto"]) }}>
    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded ">
        @if (!empty($title))
            <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                        <h3 class="font-semibold text-base text-blueGray-700">{{ __($title) }}</h3>
                    </div>
                </div>
            </div>
        @endif

        <div class="block w-full overflow-x-auto">
            <table class="items-center bg-transparent w-full border-collapse ">
                @if (!empty($thead))
                    <thead>
                        <tr>
                            @foreach ($thead as $data)
                                <x-thead-data message="{{ $data }}" />
                            @endforeach
                        </tr>
                    </thead>
                @else
                    @yield('thead')
                @endif

                @if ($tabledata)
                    <tbody>
                        @foreach ($tabledata as $data)
                            <tr>
                                @foreach ($tbody as $pos)
                                    <x-table-data :message="$data[$pos]" />
                                @endforeach
                            </tr>
                        @endforeach

                    </tbody>
                @else
                    {{ $slot }}
                @endif
            </table>
        </div>
    </div>
</div>
