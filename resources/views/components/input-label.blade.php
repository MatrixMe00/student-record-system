@props(['value', 'subtext' => null, 'subtextIcon' => 'fas fa-info-circle'])

<label {{ $attributes->merge(['class' => 'block mb-2 text-sm text-gray-600 dark:text-gray-200']) }} 
       @if($subtext) 
       x-data="{
           tooltip: false,
           position: 'top',
           updatePosition($el) {
               if (!this.tooltip) return;
               const iconEl = $el.querySelector('i');
               const tooltipEl = $el.querySelector('[x-ref=\'tooltip\']');
               if (!iconEl || !tooltipEl) return;
               
               // Wait for tooltip to be rendered
               setTimeout(() => {
                   const iconRect = iconEl.getBoundingClientRect();
                   const tooltipRect = tooltipEl.getBoundingClientRect();
                   
                   const spaceTop = iconRect.top;
                   const spaceBottom = window.innerHeight - iconRect.bottom;
                   const spaceLeft = iconRect.left;
                   const spaceRight = window.innerWidth - iconRect.right;
                   const tooltipHeight = tooltipRect.height || 150;
                   const tooltipWidth = tooltipRect.width || 256;
                   
                   // Check if tooltip fits above
                   if (spaceTop >= tooltipHeight + 20) {
                       this.position = 'top';
                   }
                   // Check if tooltip fits below
                   else if (spaceBottom >= tooltipHeight + 20) {
                       this.position = 'bottom';
                   }
                   // Check if tooltip fits on the right
                   else if (spaceRight >= tooltipWidth + 20) {
                       this.position = 'right';
                   }
                   // Default to left
                   else {
                       this.position = 'left';
                   }
               }, 10);
           }
       }" 
       @mouseenter="tooltip = true; $nextTick(() => updatePosition($el))" 
       @mouseleave="tooltip = false"
       @mouseover="updatePosition($el)"
       @endif>
    <span class="inline-flex items-center">
        {{ $value ?? $slot }}
        @if($subtext)
            <span class="relative ml-2 inline-block">
                <i class="{{ $subtextIcon }} text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-help text-xs"></i>
                <div x-show="tooltip" 
                     x-ref="tooltip"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     x-cloak
                     :class="{
                         'bottom-full mb-2 left-1/2 -translate-x-1/2': position === 'top',
                         'top-full mt-2 left-1/2 -translate-x-1/2': position === 'bottom',
                         'left-full ml-2 top-1/2 -translate-y-1/2': position === 'right',
                         'right-full mr-2 top-1/2 -translate-y-1/2': position === 'left'
                     }"
                     class="absolute w-64 max-w-[calc(100vw-2rem)] p-3 bg-gray-900 dark:bg-gray-800 text-white text-xs rounded-lg shadow-lg z-50 pointer-events-none">
                    <div class="flex items-start">
                        <i class="{{ $subtextIcon }} mr-2 mt-0.5 flex-shrink-0"></i>
                        <span class="break-words">{{ $subtext }}</span>
                    </div>
                    <!-- Tooltip arrow -->
                    <template x-if="position === 'top'">
                        <div class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900 dark:border-t-gray-800"></div>
                    </template>
                    <template x-if="position === 'bottom'">
                        <div class="absolute left-1/2 -translate-x-1/2 bottom-full w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-gray-900 dark:border-b-gray-800"></div>
                    </template>
                    <template x-if="position === 'right'">
                        <div class="absolute top-1/2 -translate-y-1/2 right-full w-0 h-0 border-t-4 border-b-4 border-r-4 border-transparent border-r-gray-900 dark:border-r-gray-800"></div>
                    </template>
                    <template x-if="position === 'left'">
                        <div class="absolute top-1/2 -translate-y-1/2 left-full w-0 h-0 border-t-4 border-b-4 border-l-4 border-transparent border-l-gray-900 dark:border-l-gray-800"></div>
                    </template>
                </div>
            </span>
        @endif
    </span>
</label>
