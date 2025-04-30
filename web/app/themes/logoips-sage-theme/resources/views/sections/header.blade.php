@php
  use App\Walkers\CustomNavWalker;
@endphp
<header class="header">
  @if (has_nav_menu('primary_navigation'))
    @push('styles')
      <link rel="stylesheet" href="{{ asset('assets/nav.css') }}" media="all">
    @endpush
    <nav class="nav container" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
    <div class="d-flex justify-content-between align-items-center h-100">
      <a href="#" class="nav__logo">
      <img src="{{asset('assets/logo-bg.svg')}}" alt="">
      </a>
    </div>
    <div class="nav__toggle ms-auto my-auto" id="nav-toggle">
      <i class="ri-menu-line nav__toggle-menu"></i>
      <i class="ri-close-line nav__toggle-close"></i>
    </div>
    <div class="nav-menu" id="nav-menu">
      {!! wp_nav_menu([
    'theme_location' => 'primary_navigation',
    'menu_class' => 'nav__list',
    'container' => false,
    'walker' => new CustomNavWalker(),
    'echo' => false,
    ]) !!}
    </div>

    @push('scripts')
    <script src="{{ asset('assets/nav.js') }}"></script>
  @endpush
    </nav>
  @endif
</header>