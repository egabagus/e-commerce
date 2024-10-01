<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

    <x-sidebar.link title="Dashboard" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.dropdown title="Master" :active="Str::startsWith(request()->route()->uri(), 'master')">
        <x-slot name="icon">
            <i class="fas fa-shopping-bag"></i>
        </x-slot>

        <x-sidebar.sublink title="Product" href="{{ url('master/product') }}" :active="request()->url('master/product')" />
    </x-sidebar.dropdown>

    <x-sidebar.dropdown title="Shop" :active="Str::startsWith(request()->route()->uri(), 'shop')">
        <x-slot name="icon">
            <i class="fas fa-store-alt"></i>
        </x-slot>

        <x-sidebar.sublink title="Order" href="{{ url('shop/order') }}" :active="request()->url('shop/order')" />
    </x-sidebar.dropdown>

</x-perfect-scrollbar>
