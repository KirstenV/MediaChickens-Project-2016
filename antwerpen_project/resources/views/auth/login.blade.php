


<form method="POST" action="{{Request::root()}}/auth/login">
    {!! csrf_field() !!}

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        Wachtwoord
        <input type="password" name="password" id="password">
    </div>

    <div>
        <input type="checkbox" name="remember"> Onthoud mij
    </div>

    <div>
        <button type="submit">Login</button>
    </div>
</form>
@foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach