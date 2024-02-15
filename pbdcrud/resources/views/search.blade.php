@include('header')
@include('navbar')

<div class="row">
    <form class="col s12">
        <div class="row valign-wrapper">
            <div class="input-field col s6 offset-s3">
                <i class="material-icons prefix">search</i>
                <input placeholder="Search" name="nome" id="mainNome" type="text">
                <label for="name">Search</label>
            </div>
            <a class='dropdown-trigger btn-floating dropFilters' data-target='dropdownFilters'><i class="material-icons">filter_list</i></a>
            <a class='dropdown-trigger btn-floating dropOrder' data-target='dropdownOrder'><i class="material-icons">swap_vert</i></a>
        </div>

        <ul id='dropdownFilters' class='dropdown-content' style='overflow-x: hidden;'>
            <li>
                Categoria:
                <p>
                    <label>
                        <input name="type" id="musicas" value="musicas" type="radio" checked/>
                        <span>Músicas</span>
                    </label>
                </p>
                <p>
                    <label>
                        <input name="type" id="playlists" value="playlists" type="radio"/>
                        <span>Playlists</span>
                    </label>
                </p>
                <p>
                    <label>
                        <input name="type" id="albums" value="albums" type="radio"/>
                        <span>Albums</span>
                    </label>
                </p>
            </li>
            <li class="divider" tabindex="-1"></li>
            <li>
                <p class="range-field">
                    Max Duração (min)
                    <input type="range" id="duracao" name="duracao" min="0" max="180" value="180"/>
                </p>
            </li>
        </ul>

        <ul  id='dropdownOrder' class='dropdown-content' style='overflow-x: hidden;'>
            <li>
                <div class="switch">
                    <label>
                        Descending
                        <input type="checkbox" id="order" name="order" value="asc">
                        <span class="lever"></span>
                        Ascending
                    </label>
                </div>
            </li>
            <li class="divider" tabindex="-1"></li>
            <li>
                Ordenar por:
                <p>
                    <label>
                        <input name="orderby" id="nome" value="nome" type="radio" checked/>
                        <span>Nome</span>
                    </label>
                </p>
                <p>
                    <label>
                        <input name="orderby" id="nLikes" value="nLikes" type="radio"/>
                        <span>Número de Likes</span>
                    </label>
                </p>
                <p>
                    <label>
                        <input name="orderby" id="duracao" value="duracao"type="radio"/>
                        <span>Duração</span>
                    </label>
                </p>
            </li>
        </ul>
    </form>
</div>

@switch($type)
    @case('musicas')
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
                @foreach ($results as $musica)
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
        @break
    @case('playlists')
        <table>
            <thead>
                <tr>
                    <thead><h5>Playlists</h5></thead>
                    <th>Nome</th>
                    <th>Numero de Músicas</th>
                    <th>Duração</th>
                    <th>Autor</th>
                    <th>Número de Likes</th>
                </tr>
            </thead>

            <tbody>
                @foreach($results as $playlist)
                    @if ($playlist->indicador_privado == false)
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

        @break
    @case('albums')
        <table>
            <thead>
                <tr>
                    <thead><h5>Álbums</h5></thead>
                    <th>Nome</th>
                    <th>Numero de Músicas</th>
                    <th>Duração</th>
                    <th>Autor</th>
                    <th>Número de Likes</th>
                </tr>
            </thead>

            <tbody>
                @foreach($results as $album)
                    <tr>
                        <td><a href="{{url('/albums/details/'.$album->id)}}">{{ $album->nome }}</a></td>
                        <td>{{ DB::table('musicas')->where('id_album','=',$album->id)->get()->count()}}</td>
                        <td>{{ $album-> duracao }}</td>
                        <td><a href="{{url('/users/details/'.$album->id_usuario)}}">{{ DB::table('usuarios')->where('id','=',$album->id_usuario)->first()->nome }}</a></td>
                        <td>{{DB::table('curte_albums')->where('curte_albums.id_album', '=', $album->id)->get()->count()}}</td>
                        <td class="right">
                            <a class="btn-floating btn-small waves-effect waves-light red favorite-button" data-number="{{$album->id}}" data-type="album">
                                <i class="material-icons">
                                    <?php
                                        $liked = DB::table('curte_albums')->where('id_usuario','=',Session::get('login'))->where('id_album','=',$album->id)->count();
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
        @break

@endswitch
@include('footer')
