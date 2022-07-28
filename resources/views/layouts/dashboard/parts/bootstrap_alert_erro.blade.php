@if (session('session_erro'))
    <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3 rounded-3" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <i class="fa-solid fa-circle-exclamation"></i>
        <strong>Erro!</strong> {{ session('session_erro') }}
    </div>
@endif
