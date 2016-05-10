<!-- resources/views/auth/register.blade.php -->

<form method="POST" action="{{Request::root()}}/auth/register">
    {!! csrf_field() !!}

    <div>
        Naam
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        Wachtwoord
        <input type="password" name="password">
    </div>

    <div>
        Bevestig wachtwoord
        <input type="password" name="password_confirmation">
    </div>

    <div>
        <button type="submit">Registreer</button>
    </div>
</form>
@foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
@endforeach