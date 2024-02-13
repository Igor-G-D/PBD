@include('header')
<form action="{{url('/login')}}" method="POST">
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
        <div class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <input placeholder="Senha" id="senha" name="senha" type="password" class="validate">
                    <label for="senha">Senha</label>
                </div>
            </div>
            <button class="btn waves-effect waves-light" type="submit" name="action">Log in
                <i class="material-icons right">send</i>
            </button>
        </div>
    </div>
</form>
<h6>Don't have an account?</h6>
<a class="waves-effect waves-light btn" href={{url('/signup')}}>Register</a>
@include('footer')
