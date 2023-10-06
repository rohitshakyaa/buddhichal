<aside id="logo-sidebar" " class=" fixed top-0 left-0 z-40 w-64 h-screen pt-[62px] transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 pt-4 overflow-y-auto bg-gray-100 dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach($menuItems as $item)
            <li>
                <a href="{{ $item->link }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <i class="{{ $item->icon ? $item->icon : 'fa-solid fa-bars' }}"></i>
                    <span class="ml-3">{{ $item->title }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</aside>