@include('header')
@include('navbar')

<h3>Albums</h3>
<div class="row">
    <div class="col s12">
        <ul class="tabs tabs-fixed-width">
            <li class="tab col s3"><a href="#userCreated">Criados por você</a></li>
            <li class="tab col s3"><a href="#userLiked">Curtidos</a></li>
        </ul>
    </div>
    <div id="userCreated" class="col s12">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Numero de Músicas</th>
                    <th>Duração</th>
                    <th>Autor</th>
                </tr>
            </thead>

            <tbody>
            @foreach($userAlbums as $album)
                <tr>
                    <td><a href="{{url('/albums/details/'.$album->id)}}">{{ $album->nome }}</a></td>
                    <td>{{ DB::table('musicas')->where('id_album','=',$album->id)->get()->count()}}</td>
                    <td>{{ $album->duracao_total }}</td>
                    <td>{{ DB::table('usuarios')->where('id','=',$album->id_usuario)->first()->nome }}</td>
                    <td class="right valign-wrapper">
                        <a href="{{url('/albums/details/'.$album->id.'/edit')}}" class="btn-floating btn-small waves-effect waves-light cyan"><i class="material-icons">create</i></a>
                        <form action="{{ url('/albums/delete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="album" value="{{ $album->id }}">
                            <button class="btn-floating btn-small red" type="submit">
                                <i class="material-icons">delete</i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button class="btn waves-effect waves-light" name="action">
            <i class="material-icons right">add</i> Adicionar Album
        </button>
    </div>
    <div id="userLiked" class="col s12">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Numero de Músicas</th>
                    <th>Duração</th>
                    <th>Autor</th>
                </tr>
            </thead>

            <tbody>
                @foreach($likedAlbums as $album)
                    <tr>
                        <td><a href="{{url('/albums/details/'.$album->id)}}">{{ $album->nome }}</a></td>
                        <td>{{ DB::table('musicas')->where('id_album','=',$album->id)->get()->count()}}</td>
                        <td>{{ $album->duracao_total }}</td>
                        <td>{{ DB::table('usuarios')->where('id','=',$album->id_usuario)->first()->nome }}</td>
                        <td class="right">
                            <form action="{{ url('/albums/unlike') }}" method="POST">
                                @csrf
                                <input type="hidden" name="album" value="{{ $album->id }}">
                                <button class="btn-floating btn-small red" type="submit">
                                    <i class="material-icons medium red">favorite</i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('footer')
