@extends('auth')

@section('content')
    <h2>Login</h2>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <p>
            {{ session('error') }}
        </p>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label>Login</label><br>
            <input class="bordered" name="login" type="text" value="{{ old('login') }}"/>
        </div>
        <div>
            <label>Password</label><br>
            <input class="bordered" name="password" type="password" />
        </div>
        <input style="cursor: pointer" type="submit"/>
    </form>

@endsection
