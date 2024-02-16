@include('header')
@include('navbar')
<h5>Adicionar Músicas a Playlist {{DB::table('playlists')->where('id','=',$playlist)->first()->nome}}</h5>
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
                    <a class="btn-floating btn-small waves-effect waves-light red add-playlist-button" data-musica="{{$musica->id}}" data-playlist="{{$playlist}}">
                        <i class="material-icons">
                            <?php
                                $added = DB::table('playlist_possui_musicas')->where('id_playlist','=',$playlist)->where('id_musica','=',$musica->id)->count();
                                if($added == 0) {
                                    echo "add";
                                } else {
                                    echo "remove";
                                }
                            ?>
                        </i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<a class="btn" href="{{url('/playlists/details/'.$playlist.'/edit')}}">Confirmar</a>

@include('footer')
