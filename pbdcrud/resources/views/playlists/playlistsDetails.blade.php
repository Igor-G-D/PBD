@include('header')
@include('navbar')
<div class="row">
    <div class="col s12 valign-wrapper">
        <h5>{{ $playlist->nome }}</h5>

        @if ($playlist->id_usuario == Session::get('login') && $playlist->nome != "Músicas Curtidas")
            <a href="{{url('/playlists/details/'.$playlist->id.'/edit')}}" class="btn-floating btn-large waves-effect waves-light cyan"><i class="material-icons">create</i></a>
            <form action="{{ url('/playlists/delete') }}" method="POST">
                @csrf
                <input type="hidden" name="playlist" value="{{ $playlist->id }}">
                <button class="btn-floating btn-large red" type="submit">
                    <i class="material-icons red">delete</i>
                </button>
            </form>
        @elseif ($playlist->nome != "Músicas Curtidas")
            <form action="{{ url('/playlists/unlike') }}" method="POST">
                @csrf
                <input type="hidden" name="playlist" value="{{ $playlist->id }}">
                <button class="btn-floating btn-large red" type="submit">
                    <i class="material-icons medium red">favorite</i>
                </button>
            </form>
        @endif

    </div>
</div>
<ul class="collection">
    <li class="collection-item">Duração: {{ $playlist-> duracao }}</li>
    <li class="collection-item">Descrição: {{ $playlist->descricao }}</li>
    <li class="collection-item">Dono: <a href="{{url('/users/details/'.$playlist->id_usuario)}}">{{ DB::table('usuarios')->where('id', '=', $playlist->id_usuario)->first()->nome }}</a></li>
    <li class="collection-item">Número de likes: {{DB::table('curte_playlists')->where('curte_playlists.id_playlist', '=', $playlist->id)->get()->count()}}</li>
    <li class="collection-item">Privado: {{$playlist->indicador_privado ? "true" : "false"}}</li>
</ul>
<table>
    <thead>
        <tr>
            <thead><h5>Músicas</h5></thead>
            <th>Nome da música</th>
            <th>Genero</th>
            <th>Duração</th>
            <th>Autores</th>
            <th>Número de Likes</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($musicas as $musica)
            <tr>
                <td>{{$musica->nome}}</td>
                <td>{{$musica->genero}}</td>
                <td>{{$musica->duracao}}</td>
                <td>
                    <?php
                        $autores = DB::table('usuarios')
                            ->leftjoin('tem_autoria', 'usuarios.id','=', 'tem_autoria.id_usuario')
                            ->where('id_musica','=',$musica->id)
                            ->select('usuarios.*')
                            ->get();
                        $autoresString = '';
                        foreach ($autores as $autor) {
                            $autores = '<a href="'.url('/users/details/'.$autor->id).'">'.$autor->nome.'</a>, ';
                            $autoresString .= $autores;
                        }
                        $autoresString = substr($autoresString, 0, -2);
                        echo $autoresString
                    ?>
                </td>
                <td>{{DB::table('curte_musicas')->where('curte_musicas.id_musica', '=', $musica->id)->get()->count()}}</td>
                <td class="right">
                    <a class="btn-floating btn-small waves-effect waves-light red favorite-button" data-number="{{$musica->id}}" data-type="musicas">
                        <i class="material-icons">
                            <?php
                                $liked = DB::table('curte_musicas')->where('id_usuario','=',Session::get('login'))->where('id_musica','=',$musica->id)->count();
                                if($liked == 0) {
                                    echo "favorite_border";
                                } else {
                                    echo "favorite";
                                }
                            ?>
                        </i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@include('footer')
