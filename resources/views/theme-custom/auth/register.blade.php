{{-- @include(backpack_view('auth.register.' . backpack_theme_config('auth_layout'))) --}}
@include(backpack_view('auth.register.' . (backpack_theme_config('auth_layout') ?: 'illustration')))
