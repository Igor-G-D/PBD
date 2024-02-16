@include('header')
@include('navbar')
<h5>Editar Playlist</h5>
<form action="{{ url('/playlists/details/update') }}" method="POST">
    <input type="hidden" name="playlist_id" value="{{$playlist->id}}">
    @csrf
    <div class="row">
        <div class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <input placeholder="Nome" id="nome" name="nome" type="text" value="{{$playlist->nome}}">
                    <label for="name">Nome</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row">
                <div class="input-field col s12">
                    <input placeholder="Descricao" id="descricao" name="descricao" type="text" class=" materialize-textarea" value="{{$playlist->descricao}}">
                    <label for="cpf">Descrição</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="switch col s2">
                <label>
                    Publico
                    <input type="checkbox" name="privado" value="true" {{$playlist->indicador_privado ? "checked" : "" }}>
                    <span class="lever"></span>
                    Privado
                </label>
            </div>
            <div class="col s1">
                <button class="btn waves-effect waves-light" type="submit">Salvar Alterações
                    <i class="material-icons right">save</i>
                </button>
            </div>
        </div>
</form>
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
                    <form action="{{ url('/playlists/details/'.$playlist->id.'/edit/removeMusica') }}" method="POST">
                        @csrf
                        <input type="hidden" name="playlist" value="{{ $playlist->id }}">
                        <input type="hidden" name="musica" value="{{ $musica->id }}">
                        <button class="btn-floating btn-small red" type="submit">
                            <i class="material-icons">remove</i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@include('footer')
