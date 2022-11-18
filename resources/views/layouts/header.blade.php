@php
	$currentRequestRouteName = Request::route()->getName();
@endphp

<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="javascript:void(0)">Six Ladder Assignment</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ $currentRequestRouteName === 'home' ? 'active': '' }}" aria-current="page" href="{{ route('home') }}">Add Invoice</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentRequestRouteName === 'invoices' ? 'active': '' }}" href="{{ route('invoices') }}">Invoices</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
