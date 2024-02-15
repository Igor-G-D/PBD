@include('header')
@include('navbar')
<div class="row">
    <div class="col s12 valign-wrapper">
        <h5>Perfil</h5>

        @if ($usuario->id == Session::get('login'))
            <a href="{{url('/users/details/'.$usuario->id.'/edit')}}" class="btn-floating btn-large waves-effect waves-light cyan"><i class="material-icons">create</i></a>
            <form action="{{ url('/users/delete') }}" method="POST">
                @csrf
                <input type="hidden" name="usuario" value="{{ $usuario->id }}">
                <button class="btn-floating btn-large red" type="submit">
                    <i class="material-icons red">delete</i>
                </button>
            </form>
        @endif

    </div>
</div>
<ul class="collection">
    <li class="collection-item">Nome: {{ $usuario-> nome }}</li>
    <li class="collection-item">CPF: {{ $usuario->cpf }}</li>
    @if ($usuario->id_distribuidor != null)
        <li class="collection-item">Em contrato com: {{ DB::table('distribuidores')->where('id', '=', $usuario->id_distribuidor)->first()->nome }}</li>
    @endif
    <li class="collection-item">Número de Playlists Criadas: {{ $nPlaylists }}</li>
    <li class="collection-item">Número de Albums Criados: {{ $nAlbums }}</li>
    <li class="collection-item">Número de Músicas com Autoria: {{ $nMusicas }}</li>
    </li>
</ul>
@include('footer')
