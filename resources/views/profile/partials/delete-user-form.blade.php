
    <h5>Supprimer le compte</h5>
    <p>
        Une fois votre compte supprimé, toutes ses données seront définitivement supprimées.
        Avant de supprimer votre compte, veuillez télécharger toutes les informations que vous souhaitez conserver.
    </p>

    <!-- Bouton pour ouvrir le modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
        Supprimer le compte
    </button>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAccountModalLabel">Confirmer la suppression du compte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted">
                            Une fois votre compte supprimé, toutes ses données seront définitivement supprimées.
                            Veuillez entrer votre mot de passe pour confirmer la suppression.
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
                            @error('password')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer le compte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

