
    @if (session('success'))
        <div class="alert alert-success" >{{session('success')}}</div>
        {{ session()->forget('success')}}
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
         {{ session()->forget('error')}}

    @endif
