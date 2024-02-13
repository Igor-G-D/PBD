@include('header')
@include('navbar')
<div class="row">
    <div class="col s12 valign-wrapper">
        <h5>{{ $playlist->nome }}</h5>

        @if ($playlist->id_usuario == Session::get('login'))
            <a href="{{url('/playlists/details/'.$playlist->id.'/edit')}}" class="btn-floating btn-large waves-effect waves-light cyan"><i class="material-icons">create</i></a>
            <form action="{{ url('/playlists/delete') }}" method="POST">
                @csrf
                <input type="hidden" name="playlist" value="{{ $playlist->id }}">
                <button class="btn-floating btn-large red" type="submit">
                    <i class="material-icons red">delete</i>
                </button>
            </form>
        @else
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
    <li class="collection-item">Duração: {{ $playlist->duracao_total }}</li>
    <li class="collection-item">Descrição: {{ $playlist->descricao }}</li>
    <li class="collection-item">Dono:{{ DB::table('usuarios')->where('id', '=', $playlist->id_usuario)->first()->nome }}
    </li>
</ul>
<table>
    <thead>
        <tr>
            <thead><h5>Músicas</h5></thead>
            <th>Nome da música</th>
            <th>Genero</th>
            <th>Duração</th>
            <th>Autores</th>
            <th></th>
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
                        $autoresString = $autoresString.$autor->nome.',';
                    }
                    $autoresString = substr($autoresString, 0, -1);
                    echo $autoresString
                ?>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@include('footer')
