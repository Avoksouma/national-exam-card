<div class='sidebar bg-body min-vh-100 d-none d-sm-block' data-bs-theme="dark">
    <div class='d-flex flex-column justify-content-between h-100'>
        <div>
            <div class='text-center'>
                <img class='m-3 rounded-pill' alt='logo' src='/img/logo.png' height='80' width='80' />
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('home') }}" class="list-group-item list-group-item-action">
                    <i class='bi bi-house me-2'></i> {{ __('Home') }}
                </a>
                <a href="{{ route('dashboard') }}"
                    class="list-group-item list-group-item-action @if (Route::currentRouteName() == 'dashboard') active @endif">
                    <i class='bi bi-speedometer2 me-2'></i> {{ __('Dashboard') }}
                </a>
                @if (in_array(Auth::user()->role, ['staff', 'admin']))
                    <a href="{{ route('report') }}"
                        class="list-group-item list-group-item-action @if (str_contains(Route::currentRouteName(), 'report')) active @endif">
                        <i class='bi bi-box me-2'></i> {{ __('Report') }}
                    </a>
                    <a href="{{ route('school.index') }}"
                        class="list-group-item list-group-item-action @if (str_contains(Route::currentRouteName(), 'school')) active @endif">
                        <i class='bi bi-building me-2'></i> {{ __('School') }}
                    </a>
                @endif
                <a href="{{ route('application.index') }}"
                    class="list-group-item list-group-item-action @if (str_contains(Route::currentRouteName(), 'application')) active @endif">
                    <i class='bi bi-collection me-2'></i> {{ __('Student Application') }}
                </a>
                @if (in_array(Auth::user()->role, ['staff', 'admin']))
                    <a href="{{ route('subject.index') }}"
                        class="list-group-item list-group-item-action @if (str_contains(Route::currentRouteName(), 'subject')) active @endif">
                        <i class='bi bi-star me-2'></i> {{ __('Subjects') }}
                    </a>
                    <a href="{{ route('combination.index') }}"
                        class="list-group-item list-group-item-action @if (str_contains(Route::currentRouteName(), 'combination')) active @endif">
                        <i class='bi bi-boxes me-2'></i> {{ __('Combinations') }}
                    </a>
                @endif
                <a href="{{ route('marks.index') }}"
                    class="list-group-item list-group-item-action @if (str_contains(Route::currentRouteName(), 'marks')) active @endif">
                    <i class='bi bi-clipboard-check me-2'></i> {{ __('Marks') }}
                </a>
                <a href="{{ route('calendar.index') }}"
                    class="list-group-item list-group-item-action @if (str_contains(Route::currentRouteName(), 'calendar')) active @endif">
                    <i class='bi bi-calendar-date me-2'></i> {{ __('Calendar') }}
                </a>
                <a href="{{ route('notification.index') }}"
                    class="list-group-item list-group-item-action @if (str_contains(Route::currentRouteName(), 'notification')) active @endif">
                    <i class='bi bi-bell me-2'></i> {{ __('Notification') }}
                    <span class='badge bg-info float-end'>
                        {{ Auth::user()->notifications->count() }}
                    </span>
                </a>
                <a href="" class="list-group-item list-group-item-action d-none">
                    <i class='bi bi-chat me-2'></i> {{ __('Message') }}
                    <span class='badge bg-info float-end'>
                        {{ Auth::user()->receivedMessages->count() }}
                    </span>
                </a>
                <a href="{{ route('paper.index') }}"
                    class="list-group-item list-group-item-action @if (str_contains(Route::currentRouteName(), 'paper')) active @endif">
                    <i class='bi bi-file-earmark-medical me-2'></i> {{ __('Past Papers') }}
                </a>
                @if (in_array(Auth::user()->role, ['staff', 'admin']))
                    <a href="{{ route('user.index') }}"
                        class="list-group-item list-group-item-action @if (str_contains(Route::currentRouteName(), 'user')) active @endif">
                        <i class='bi bi-people me-2'></i> {{ __('User') }}
                    </a>
                    <a href="{{ route('student.index') }}"
                        class="list-group-item list-group-item-action @if (str_contains(Route::currentRouteName(), 'student')) active @endif">
                        <i class='bi bi-people me-2'></i> {{ __('Students') }}
                    </a>
                @endif
                <a href="{{ route('profile.show', Auth::user()->id) }}"
                    class="list-group-item list-group-item-action @if (str_contains(Route::currentRouteName(), 'profile')) active @endif">
                    <i class='bi bi-person-circle me-2'></i> {{ __('Profile') }}
                </a>
                <a href="{{ route('logout') }}" class="list-group-item list-group-item-action">
                    <i class='bi bi-box-arrow-left me-2'></i> {{ __('Logout') }}
                </a>
                <div class='list-group-item list-group-item-action text-center'>
                    <a class='text-decoration-none mx-1' href="/language/en">
                        <img alt='english flag' src='/img/english.png' width='25' height='25' />
                    </a>
                    <a class='text-decoration-none mx-1' href="/language/fr">
                        <img alt='francais flag' src='/img/francais.png' width='25' height='25' />
                    </a>
                </div>
            </div>
        </div>
        <div class='d-flex flex-row'>
            <img class='m-3 rounded-pill' alt='{{ Auth::user()->name }}' src='/img/user.png' height='50'
                width='50' />
            <div class='text-white my-auto'>
                <b class='d-block'>{{ Auth::user()->name }}</b>
                <small class='d-block'>{{ Auth::user()->role }}</small>
            </div>
        </div>
    </div>
</div>
