@extends('auth')

@section('content')
    <h2>Registration</h2>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label>Login</label><br>
            <input class="bordered" name="login" type="text" value="{{ old('login') }}"/>
        </div>
        <div>
            <label>Password</label><br>
            <input class="bordered" name="password" type="password" />
        </div>
        <input type="submit" />
    </form>
@endsection
