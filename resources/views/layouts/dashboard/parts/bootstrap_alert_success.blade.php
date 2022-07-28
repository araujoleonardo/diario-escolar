@if (session('session_sucesso'))
    <div class="alert alert-success alert-dismissible fade show mx-3 mt-3 rounded-3" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <i class="fa-solid fa-check"></i>
        <strong>Sucesso!</strong> {{ session('session_sucesso') }}
    </div>
@endif
