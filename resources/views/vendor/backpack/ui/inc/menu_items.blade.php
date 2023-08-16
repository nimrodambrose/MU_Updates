{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-dropdown title="Updates" icon="la la-clipboard">
    <x-backpack::menu-dropdown-item title="Channels" icon="la la-microphone" :link="backpack_url('channel')" />
    <x-backpack::menu-dropdown-item title="Tags" icon="la la-tags" :link="backpack_url('tag')" />
    <x-backpack::menu-dropdown-item title="News articles" icon="la la-newspaper" :link="backpack_url('news-article')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Student Representatives" icon="la la-users-cog">
    <x-backpack::menu-dropdown-item title="Positions" icon="la la-person-booth" :link="backpack_url('position')" />
    <x-backpack::menu-dropdown-item title="Representatives" icon="la la-user-tie" :link="backpack_url('student-representative')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-separator></x-backpack::menu-separator>

<x-backpack::menu-dropdown title="Advanced" icon="la la-tools">
    <x-backpack::menu-dropdown-item title="Settings" icon="la la-cogs" :link="backpack_url('setting')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Authentication" icon="la la-users">
    {{-- <x-backpack::menu-dropdown-header title="Authentication" /> --}}
    <x-backpack::menu-dropdown-item title="Users" icon="la la-user" :link="backpack_url('user')" />
    <x-backpack::menu-dropdown-item title="Roles" icon="la la-user-tag" :link="backpack_url('role')" />
    <x-backpack::menu-dropdown-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" />
</x-backpack::menu-dropdown>
