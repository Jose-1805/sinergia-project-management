<div class="col s12">
    <div class="col s12 m6">
        <a class=" col s12 teal white-text btn waves-effect waves-light" href="{{asset("/eval/perfil-sugerir/".\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}">Sugerir</a>
    </div>

    <div class="col s12 m6">
        <a class="col s12 btn teal white-text waves-effect waves-light" href="{{asset("/proyecto/inicio-proyecto/".\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}">Establecer inicio</a>
    </div>
</div>