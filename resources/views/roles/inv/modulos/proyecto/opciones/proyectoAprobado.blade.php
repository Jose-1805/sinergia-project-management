<div class="col s12">
    <div class="col s12 m4">
        <a class=" col s12 teal white-text btn waves-effect waves-light" href="{{asset("/proyecto/entidades/".\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}">Entidades</a>
    </div>

    <div class="col s12 m4">
        <a class=" col s12 teal white-text btn waves-effect waves-light" href="{{asset("/proyecto/grupo/".\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}">Grupo</a>
    </div>

    <div class="col s12 m4">
        <a class="col s12 btn teal white-text waves-effect waves-light" href="{{asset("/inv/asignacion-tareas/".\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}">Tareas</a>
    </div>
</div>