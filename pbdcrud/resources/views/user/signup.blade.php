@include('header')
<form action="{{url('/signup')}}" method="POST">
    @csrf
    <div class="row">
        <div class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <input placeholder="Name" id="name" name="nome" type="text" class="validate">
                    <label for="name">First Name</label>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="row">
            <div class="input-field col s12">
                <input placeholder="CPF" id="cpf" name="cpf" type="text" class="validate">
                <label for="cpf">CPF</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <input placeholder="Senha" id="senha" name="senha" type="password" class="validate">
                    <label for="senha">Senha</label>
                </div>
            </div>
            <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                <i class="material-icons right">send</i>
            </button>
        </div>
    </div>
</form>
<h6>Already have an account?</h6>
<a class="waves-effect waves-light btn" href={{url('/login')}}>Log in</a>
@include('footer')
