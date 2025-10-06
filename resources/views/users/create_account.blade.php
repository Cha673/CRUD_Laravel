<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Ajouter un compte</h1>

        <!-- Formulaire de création de compte -->
        <form action="{{ route('accounts.store') }}" method="POST">
            @csrf

            <!-- Sélection de l'utilisateur -->
            <div class="mb-3">
                <label for="user_id" class="form-label">ID de l'utilisateur</label>
                <input type="number" class="form-control" id="user_id" name="user_id" placeholder="Entrez l'ID utilisateur" required>
            </div>

            <!-- Nom du compte -->
            <div class="mb-3">
                <label for="name" class="form-label">Nom du compte</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom du compte" required>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter le compte</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>
