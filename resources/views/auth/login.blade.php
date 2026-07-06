<x-guest-layout>

    {{-- Session Status --}}
    @if(session('status'))
        <div class="alert alert-success py-2">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('login') }}">

        @csrf

        {{-- Email --}}
        <div class="mb-3">

            <label for="email"
                   class="form-label fw-semibold">
                Email
            </label>

            <div class="input-group">

                <span class="input-group-text bg-body-tertiary border-end-0">
                    <i class="bi bi-envelope text-secondary"></i>
                </span>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                    placeholder="Masukkan email"
                    required
                    autofocus
                    autocomplete="username">

            </div>

            @error('email')
                <div class="text-danger small mt-1">
                    {{ $message }}
                </div>
            @enderror

        </div>

        {{-- Password --}}
        <div class="mb-3">

            <label for="password"
                   class="form-label fw-semibold">
                Password
            </label>

            <div class="input-group">

                <span class="input-group-text bg-body-tertiary border-end-0">
                    <i class="bi bi-lock text-secondary"></i>
                </span>

                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
                    placeholder="Masukkan password"
                    required
                    autocomplete="current-password">

            </div>

            @error('password')
                <div class="text-danger small mt-1">
                    {{ $message }}
                </div>
            @enderror

        </div>

        {{-- Remember dan Forgot Password --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">

            <div class="form-check">
                <input
                    id="remember"
                    type="checkbox"
                    name="remember"
                    class="form-check-input">

                <label for="remember"
                       class="form-check-label text-secondary">
                    Ingat saya
                </label>
            </div>

            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-decoration-none">
                    Lupa password?
                </a>
            @endif

        </div>

        {{-- Tombol Masuk --}}
        <button type="submit"
                class="btn btn-primary bg-gradient w-100 py-2 fw-semibold shadow-sm">

            <i class="bi bi-box-arrow-in-right me-1"></i>
            Masuk

        </button>

        {{-- Register --}}
        @if(Route::has('register'))
            <div class="text-center mt-4">

                <span class="text-secondary">
                    Belum memiliki akun?
                </span>

                <a href="{{ route('register') }}"
                   class="text-decoration-none fw-semibold ms-1">
                    Daftar
                </a>

            </div>
        @endif

    </form>

</x-guest-layout>