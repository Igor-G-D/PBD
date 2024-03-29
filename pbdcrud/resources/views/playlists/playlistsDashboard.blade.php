@include('header')
@include('navbar')

<h3>Playlists</h3>
<div class="row">
    <div class="col s12">
        <ul class="tabs tabs-fixed-width">
            <li class="tab col s3"><a href="#userCreated">Criadas por você</a></li>
            <li class="tab col s3"><a href="#userLiked">Curtidas</a></li>
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
                    <th>Número de Likes</th>
                </tr>
            </thead>

            <tbody>
            @foreach($userPlaylists as $playlist)
                <tr>
                    <td><a href="{{url('/playlists/details/'.$playlist->id)}}">{{ $playlist->nome }}</a></td>
                    <td>{{ DB::table('playlist_possui_musicas')->where('id_playlist','=',$playlist->id)->get()->count()}}</td>
                    <td>{{ $playlist-> duracao }}</td>
                    <td><a href="{{url('/users/details/'.$playlist->id_usuario)}}">{{ DB::table('usuarios')->where('id','=',$playlist->id_usuario)->first()->nome }}</a></td>
                    <td>{{DB::table('curte_playlists')->where('curte_playlists.id_playlist', '=', $playlist->id)->get()->count()}}</td>
                    @if ($playlist->nome != "Músicas Curtidas")
                        <td class="right valign-wrapper">
                            <a href="{{url('/playlists/details/'.$playlist->id.'/edit')}}" class="btn-floating btn-small waves-effect waves-light cyan"><i class="material-icons">create</i></a>
                            <form action="{{ url('/playlists/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="playlist" value="{{ $playlist->id }}">
                                <button class="btn-floating btn-small red" type="submit">
                                    <i class="material-icons">delete</i>
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{url('/playlists/create')}}" class="btn">
            <i class="material-icons right">add</i> Adicionar Playlist
        </a>
    </div>
    <div id="userLiked" class="col s12">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Numero de Músicas</th>
                    <th>Duração</th>
                    <th>Autor</th>
                    <th>Número de Likes</th>
                </tr>
            </thead>

            <tbody>
                @foreach($likedPlaylists as $playlist)
                    @if ($playlist->indicador_privado == false || Session::get('login') == $playlist->id_usuario)
                        <tr>
                            <td><a href="{{url('/playlists/details/'.$playlist->id)}}">{{ $playlist->nome }}</a></td>
                            <td>{{ DB::table('playlist_possui_musicas')->where('id_playlist','=',$playlist->id)->get()->count()}}</td>
                            <td>{{ $playlist-> duracao }}</td>
                            <td><a href="{{url('/users/details/'.$playlist->id_usuario)}}">{{ DB::table('usuarios')->where('id','=',$playlist->id_usuario)->first()->nome }}</a></td>
                            <td>{{DB::table('curte_playlists')->where('curte_playlists.id_playlist', '=', $playlist->id)->get()->count()}}</td>
                            <td class="right">
                                <a class="btn-floating btn-small waves-effect waves-light red favorite-button" data-number="{{$playlist->id}}" data-type="playlists">
                                    <i class="material-icons">
                                        <?php
                                            $liked = DB::table('curte_playlists')->where('id_usuario','=',Session::get('login'))->where('id_playlist','=',$playlist->id)->count();
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
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('footer')
