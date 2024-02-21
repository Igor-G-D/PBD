@include('header')
@include('navbar')
<form action="{{url('/users/details/'.$usuario->id.'/edit')}}" method="POST">
    @csrf
    <div class="row">
        <div class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <input placeholder="Name" id="name" name="nome" type="text" class="validate" value="{{$usuario->nome}}">
                    <label for="name">First Name</label>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="row">
            <div class="input-field col s12">
                <input placeholder="CPF" id="cpf" name="cpf" type="text" class="validate" value="{{$usuario->cpf}}">
                <label for="cpf">CPF</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <input placeholder="Senha" id="senha" name="senha" type="password" class="validate" value="{{$usuario->senha}}">
                    <label for="senha">Senha</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <select name="distribuidor">
                    <option value="">Nenhum</option>
                @foreach ($distribuidores as $distribuidor)
                    <option value="{{$distribuidor->id}}"
                        @if ($distribuidor->id == $usuario->id_distribuidor)
                            selected
                        @endif
                        >{{$distribuidor->nome}}
                    </option>
                @endforeach
            </select>
            <label>Distribuidora</label>
        </div>
    </div>
    <button class="btn waves-effect waves-light" type="submit" name="action">Confirmar
        <i class="material-icons right">send</i>
    </button>
</form>
@include('footer')
