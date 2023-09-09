<x-main-layout>
    <div class="h-5 w-full flex justify-end px-10 py-5">
        <div id="toggle-theme" class="text-2xl"></div>
    </div>
    <div class="h-full">
        <div class="max-w-2xl mx-auto">
            <div class="font-bold text-white text-4xl text-center mb-10">
                LOGO HERE
            </div>
            <div>
                {{ $slot }}
            </div>
        </div>
    </div>
</x-main-layout>
