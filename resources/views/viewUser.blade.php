    @foreach($users as $user)
        user_id -> {!! $user->id !!}  {!! $user->role->id !!}

    @endforeach
