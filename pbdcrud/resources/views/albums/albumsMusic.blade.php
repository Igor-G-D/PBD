@include('header')
<table>
    <thead>
        <tr>
            <thead><h5>Músicas do Album {{$nome}}</h5></thead>
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
                    <form action="{{ url('/albums/'.$album_id.'/music/removeAndUpdate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="musica" value="{{ $musica->id }}">
                        <button class="btn-floating btn-small red" type="submit">
                            <i class="material-icons">delete</i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<a class="btn" href="{{url('/albums/'.$album_id.'/music/new')}}">Adicionar Música</a> <br>
<a class="btn" href="{{url('/albums/'.$album_id.'/music/confirm')}}">Confirmar</a>

@include('footer')
