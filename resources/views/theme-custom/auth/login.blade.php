{{-- @include(backpack_view('auth.login.' . backpack_theme_config('auth_layout'))) --}}
@include(backpack_view('auth.login.' . (backpack_theme_config('auth_layout') ?: 'illustration')))