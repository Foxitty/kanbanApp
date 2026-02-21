<div class="dropdown nav-user-dropdown">
    <button class="btn dropdown-toggle d-flex align-items-center gap-2"
        type="button"
        data-bs-toggle="dropdown"
        data-bs-toggle="tooltip"
        data-bs-placement="bottom"
        title="{{ Auth::user()->name }}">
        <div class="fw-bold small text-truncate" style="max-width: 100px;">
            {{ Auth::user()->name }}
        </div>
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
        <li><a class="dropdown-item small" href="{{ route('profile.edit') }}">Perfil</a></li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item small text-danger">Sair</button>
            </form>
        </li>
    </ul>
</div>