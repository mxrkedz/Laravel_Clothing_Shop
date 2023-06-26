<h1>customer dashboard</h1>
    
<a class="menu-link logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span class="ms-auto">Logout</span>
        <i class="fa-solid fa-right-from-bracket" style="margin-left: 5px;"></i>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>