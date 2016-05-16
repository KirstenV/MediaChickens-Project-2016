<div id="registerModal" class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Registreer</h4>
</div>
<div class="modal-body">

        {{var_dump($errors)}}

    <div class="modal-body-center">
        <form method="POST" action="{{Request::root()}}/auth/register">
            {!! csrf_field() !!}

            <div>
                <label>Naam</label>
                <br>
                <input class="textbox" type="text" name="name" value="{{ old('name') }}">
            </div>
            <br>
            <div>
                <label>Email</label>
                <br>
                <input class="textbox" type="email" name="email" value="{{ old('email') }}">
            </div>
            <br>
            <div>
                <label>Wachtwoord</label>
                <br>
                <input class="textbox" type="password" name="password">
            </div>
            <br>
            <div>
                <label>Bevestig wachtwoord</label>
                <br>
                <input class="textbox" type="password" name="password_confirmation">
            </div>



            @foreach ($errors->all() as $error)
            <li class="title_red">{{ $error }}</li>
            @endforeach 
            
            @if ($errors->first("password"))
            <script>
                $('#myModal').modal('show');
            </script>
            @endif
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Annuleer</button>
    <button id="btn-register" name="submit" type="submit" class="btn btn-primary">Registreer</button>
    </form>
</div>