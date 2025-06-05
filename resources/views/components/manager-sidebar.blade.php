<aside id="sidebar"
    class="fixed top-0 left-0 z-40 w-[17rem] h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            
            @php
                $user = auth()->user();
                $outlets = $user->getCurrentLembaga()->outlets;
                $activeOutlet = session('active_outlet', 'all');
            @endphp

            <div class="px-3 pb-4">
                <label for="outlet-select" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Select Outlet</label>
                <select id="outlet-select"
                    class="w-full p-2 text-sm border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    name="outlet_id">
                    <option value="all" {{ $activeOutlet === 'all' ? 'selected' : '' }}>All Outlets</option>
                    @foreach($outlets as $outlet)
                        <option value="{{ $outlet->id }}" {{ $activeOutlet == $outlet->id ? 'selected' : '' }}>
                            {{ $outlet->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <hr />
            <!-- Current User Profile -->
            <li>
                <div href="#"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/avatar.png') }}" alt="current user profile"
                        class="w-5 h-5 rounded-full">
                    <span class="ms-3">
                        {{ auth()->user()->email }}
                    </span>
                </div>
            </li>

            <!-- Dynamic Menu Items -->
            @foreach($menuItems as $menuItem)
                <li>
                    @if($menuItem->is_parent && $menuItem->children->count() > 0)
                        <!-- Parent Menu with Children -->
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="{{ Str::slug($menuItem->menu_name) }}-dropdown" 
                            data-collapse-toggle="{{ Str::slug($menuItem->menu_name) }}-dropdown">
                            
                            @if(str_contains($menuItem->icon, 'fa-'))
                                <i class="{{ $menuItem->icon }} text-lg text-gray-700 dark:text-gray-200"></i>
                            @else
                                {!! $menuItem->icon !!}
                            @endif
                            
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ $menuItem->menu_name }}</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <ul id="{{ Str::slug($menuItem->menu_name) }}-dropdown" class="hidden py-2 space-y-2 transition-all duration-1000">
                            @foreach($menuItem->children as $childItem)
                                <li>
                                    <a href="{{ $childItem->route ?: '#' }}"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-8 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 menu-link"
                                        data-title='{{ $childItem->menu_name }}'
                                        >
                                        @if($childItem->icon)
                                            @if(str_contains($childItem->icon, 'fa-'))
                                                <i class="{{ $childItem->icon }} mr-2 text-lg text-gray-700 dark:text-gray-200"></i>
                                            @else
                                                {!! $childItem->icon !!}
                                            @endif
                                        @endif
                                        {{ $childItem->menu_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <!-- Single Menu Item -->
                        <a href="{{ $menuItem->route ?? '#' }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group menu-link">
                            @if($menuItem->icon)
                                @if(str_contains($menuItem->icon, 'fa-'))
                                    <i class="{{ $menuItem->icon }} text-lg text-gray-700 dark:text-gray-200"></i>
                                @else
                                    {!! $menuItem->icon !!}
                                @endif
                            @endif
                            <span class="ms-3">
                                {{ $menuItem->menu_name }}
                            </span>
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</aside>