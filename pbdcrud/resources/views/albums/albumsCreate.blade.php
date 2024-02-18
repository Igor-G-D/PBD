@include('header')
@include('navbar')

<h5>Adicionar Album</h5>
<form action="{{ url('/albums/create') }}" method="POST">
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
            <div class="col s12">
                <button class="btn-large waves-effect waves-light" type="submit" >Confirmar e Adicionar Músicas
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
</form>
@include('footer')
