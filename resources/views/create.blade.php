<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une personne</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Créer une nouvelle personne</h1>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="first_name" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="last_name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="birth_name" class="form-label">Nom de naissance</label>
                <input type="text" class="form-control" id="birth_name" name="birth_name" value="{{ old('birth_name') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="middle_names" class="form-label">Seconds prénoms</label>
                <input type="text" class="form-control" id="middle_names" name="middle_names" value="{{ old('middle_names') }}">
            </div>
            
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date de naissance</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="created_by" class="form-label">Créé par (ID utilisateur)</label>
                <input type="number" class="form-control" id="created_by" name="created_by" value="{{ auth()->id() ?? old('created_by') }}" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Créer</button>
            <a href="{{ route('index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>