<x-app-layout>
    <div class="container py-5">
        <div class="mb-4">
            <a href="javascript:history.back()" class="btn btn-link p-0 text-decoration-none fw-bold text-muted d-flex align-items-center gap-2 hover-primary">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar
            </a>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="auth-card p-4 p-sm-5 mb-4 profile-section border shadow-sm">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="auth-card p-4 p-sm-5 mb-4 profile-section border shadow-sm">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="auth-card p-4 p-sm-5 border border-danger border-opacity-25 profile-section shadow-sm">
                    <div class="max-w-xl text-danger">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>