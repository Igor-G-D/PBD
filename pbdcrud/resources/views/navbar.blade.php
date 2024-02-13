<ul id="dropdown1" class="dropdown-content">
    <li><a href="{{url("/profile")}}">Seu Perfil</a></li>
    <li class="red lighten-3"><a href="{{url("/logout")}}">Log Out</a></li>
</ul>
<nav>
    <div class="nav-wrapper">
        <a href="" class="brand-logo center">
            <img class="responsive-img" src="{{url('/images/UFPEL-ESCUDO-2013.png')}}" alt="">
        </a>
        <ul class="left hide-on-med-and-down">
            <li><a href="{{url("/playlists")}}">Suas Playlists</a></li>
            <li><a href="{{url("/albums")}}">Seus Álbums</a></li>
            <li><a href="{{url("/buscar")}}">Buscar</a></li>
        </ul>
        <ul class="right hide-on-med-and-down">
            <li><a class="dropdown-trigger" data-target="dropdown1"><?php echo DB::table('usuarios')->where('id',Session::get('login'))->first()->nome ?><i class="material-icons right">arrow_drop_down</i></a></li>
        </ul>
    </div>
</nav>
