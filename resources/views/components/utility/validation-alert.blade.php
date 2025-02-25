@if ($errors->any())
    <div class="alert alert-danger p-3">
        <h6 class="font-weight-bold"><i class="fas fa-exclamation-circle"></i> Validasi Gagal</h6>
        <ul class="mb-0 pl-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
