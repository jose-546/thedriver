<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="row">

        {{-- Current Password --}}
        <div class="col-lg-6 mb20">
            <h5>Ancien mot de Passe</h5>
            <input 
                type="password" 
                name="current_password" 
                id="current_password" 
                class="form-control" 
                placeholder="Entrez l'ancien mot de passe"
                autocomplete="current-password"
            />
            @error('current_password')
                <p class="text-danger small mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- New Password --}}
        <div class="col-lg-6 mb20">
            <h5>Nouveau Mot de passe</h5>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="form-control" 
                placeholder="Choisissez un nouveau mot de passe"
                autocomplete="new-password"
            />
            @error('password')
                <p class="text-danger small mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="col-lg-6 mb20">
            <h5>Confirmez Mot de Passe</h5>
            <input 
                type="password" 
                name="password_confirmation" 
                id="password_confirmation" 
                class="form-control" 
                placeholder="Confirmez le nouveau mot de passe"
                autocomplete="new-password"
            />
            @error('password_confirmation')
                <p class="text-danger small mt-1">{{ $message }}</p>
            @enderror
        </div>

    </div>

    <button type="submit" class="btn-main">Enregister</button>

    @if (session('status') === 'password-updated')
        <p class="text-success mt-2">Mot de passe enregistré.</p>
    @endif
</form>
