@if (session('success') || session('status'))
    <div class="flash-toast" role="status">
        <span class="flash-toast-icon">OK</span>
        <div>
            <p class="flash-toast-title">Berhasil</p>
            <p>{{ session('success') ?? session('status') }}</p>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="flash-toast flash-toast-error" role="alert">
        <span class="flash-toast-icon flash-toast-icon-error">!</span>
        <div>
            <p class="flash-toast-title flash-toast-title-error">Gagal</p>
            <p>{{ session('error') }}</p>
        </div>
    </div>
@endif
