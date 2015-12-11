<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="/">
                {{ trans('app.title') }}
            </a>
        </div>

        @if($logged)
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="{{ Request::is('tasks') ? 'active' : 'inactive' }}">
                    <a href="{{ route('tasks.index') }}">{{ trans('app.tasks.title') }}</a>
                </li>
                <li class="{{ Request::is('users') ? 'active' : 'inactive' }}">
                    <a href="{{ route('users.index') }}">{{ trans('app.users.title') }}</a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ $logged->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ url('auth/logout') }}">
                                {{ trans('app.auth.logout') }}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        @endif
    </div>
</nav>
