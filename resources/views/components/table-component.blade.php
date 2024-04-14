@props(["tabledata" => null, "title" => "", "screens" => "xl:w-8/12", "thead" => [], "tbody" => [], "btn_text" => false, "btnaction" => "", "shadow" => "shadow-lg" ])
<div {{ $attributes->merge(["class"=>"w-full $screens mx-auto"]) }}>
    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 {{ $shadow }} rounded ">
        @if (!empty($title))
            <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                        <h3 class="font-semibold text-base text-blueGray-700">{{ __($title) }}</h3>
                    </div>
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                        @if ($btn_text)
                            @if (is_array($btn_text))
                                @foreach ($btn_text as $pos => $btn)
                                    <x-primary-button  type="button" onclick="{{ is_array($btnaction) ? $btnaction[$pos] : $btnaction }}" >{{ __($btn) }}</x-primary-button>
                                @endforeach
                            @else
                                <x-primary-button  type="button" onclick="{{ $btnaction }}" >{{ __($btn_text) }}</x-primary-button>
                            @endif
                        @else
                            @yield('button')
                        @endif
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
                                @if (is_array($data))
                                    <x-thead-data :class="$data['class'] :message="$data['value']" /">
                                @else
                                    <x-thead-data message="{{ $data }}" />
                                @endif
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
