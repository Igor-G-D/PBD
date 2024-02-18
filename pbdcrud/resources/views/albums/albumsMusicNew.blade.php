@include('header')

<h5>Nova Música para o Álbum {{$nome}}</h5>
<form action="{{ url('/albums/'.$album_id.'/music/new') }}" method="POST">
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
        <div class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <input placeholder="Gếnero" id="genero" name="genero" type="text">
                    <label for="genero">Genero</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h6>Duração</h6>
        <div class="input-field col s6">
            <select id="minutes" name="minutes">
                <option value="0" selected>0</option>
                @for($i = 1 ; $i<=60 ; $i++)
                    <option value="{{$i}}" >{{$i}}</option>
                @endfor
            </select>
            <label for="minutes">Minutos</label>
        </div>

        <div class="input-field col s6">
            <select id="seconds" name="seconds">
                <option value="0" selected>0</option>
                @for($i = 1 ; $i<=60 ; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
            <label for="seconds">Segundos</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <select name="coauthor">
                    <option value="">Nenhum</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{$usuario->id}}">{{$usuario->nome}}</option>
                @endforeach
            </select>
            <label>Co-autor</label>
        </div>
    </div>
    <button class="btn waves-effect waves-light" type="submit">Adicionar Música
        <i class="material-icons right">add</i>
    </button>
</form>
@include('footer')
