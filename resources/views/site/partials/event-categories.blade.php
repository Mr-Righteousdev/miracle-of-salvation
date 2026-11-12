<nav class="category-links" aria-label="Event categories">
    <a href="{{ route('events') }}" class="{{ request()->routeIs('events') ? 'is-active' : '' }}">All upcoming</a>
    @foreach (\App\Enums\EventCategory::cases() as $category)
        <a href="{{ route($category->routeName()) }}" class="{{ request()->routeIs($category->routeName()) ? 'is-active' : '' }}">{{ $category->label() }}</a>
    @endforeach
</nav>
