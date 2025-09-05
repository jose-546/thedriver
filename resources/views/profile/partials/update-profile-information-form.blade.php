<div>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-lg-6 mb20">
                <h5>Nom</h5>
                <input 
                    type="text" 
                    name="name" 
                    id="username" 
                    class="form-control" 
                    style="font-size:14px;" 
                    placeholder="Entrez votre nom"
                    value="{{ old('name', $user->name) }}"
                    required
                />
                @error('name')
                    <p class="text-danger small mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-lg-6 mb20">
                <h5>Email</h5>
                <input 
                    type="email" 
                    name="email" 
                    id="email_address" 
                    class="form-control" 
                    style="font-size:14px;" 
                    placeholder="Entrez l'email"
                    value="{{ old('email', $user->email) }}"
                    required
                />
                @error('email')
                    <p class="text-danger small mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Vérification email si nécessaire --}}
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-2">
                <p class="text-sm text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif

        <button type="submit" class="btn-main">Enregistrer</button>

        @if (session('status') === 'profile-updated')
            <p class="text-sm text-gray-600 mt-2">{{ __('Saved.') }}</p>
        @endif
    </form>
</div>