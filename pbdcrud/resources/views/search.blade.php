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
                    <input type="range" id="duracao" name="duracao" min="0" max="180" />
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

@include('footer')
