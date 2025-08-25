<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test SMS Twilio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Test SMS Twilio</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('test-sms.send') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="phone" class="form-label">Numéro de téléphone</label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       placeholder="Ex: 0123456789 ou +22912345678" 
                                       value="{{ old('phone') }}" required>
                                <small class="form-text text-muted">
                                    Format accepté: numéro local (01234...) ou international (+229...)
                                </small>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" 
                                          rows="3" maxlength="160" required>{{ old('message', 'Test SMS depuis CarRental - ' . now()->format('d/m/Y H:i')) }}</textarea>
                                <small class="form-text text-muted">
                                    Maximum 160 caractères
                                </small>
                            </div>

                            <button type="submit" class="btn btn-primary">Envoyer SMS</button>
                        </form>
                    </div>
                </div>

                <div class="mt-4">
                    <h5>Configuration actuelle:</h5>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Mode Sandbox:</strong> 
                            <span class="badge {{ config('services.twilio.sandbox_mode') ? 'bg-warning' : 'bg-success' }}">
                                {{ config('services.twilio.sandbox_mode') ? 'Activé' : 'Désactivé' }}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <strong>Numéro Twilio:</strong> {{ config('services.twilio.phone_number') ?: 'Non configuré' }}
                        </li>
                        <li class="list-group-item">
                            <strong>SID configuré:</strong> 
                            <span class="badge {{ config('services.twilio.sid') ? 'bg-success' : 'bg-danger' }}">
                                {{ config('services.twilio.sid') ? 'Oui' : 'Non' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>