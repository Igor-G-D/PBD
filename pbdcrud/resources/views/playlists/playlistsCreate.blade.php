@include('header')
@include('navbar')
<h5>Adicionar Playlist</h5>
<form action="{{ url('/playlists/create') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <input placeholder="Nome" id="nome" name="nome" type="text">
                    <label for="name">Nome</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row">
                <div class="input-field col s12">
                    <input placeholder="Descricao" id="descricao" name="descricao" type="text"
                        class=" materialize-textarea">
                    <label for="cpf">Descrição</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="switch col s2">
                <label>
                    Publico
                    <input type="checkbox" name="privado" value="true">
                    <span class="lever"></span>
                    Privado
                </label>
            </div>
            <div class="col s1">
                <button class="btn waves-effect waves-light" type="submit">Criar Playlist
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
</form>
@include('footer')
