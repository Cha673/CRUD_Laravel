<!DOCTYPE html>
<html>
<head>
    <title>Liste des utilisateurs et comptes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">

        <!-- ===== Tableau Utilisateurs ===== -->
        <h1>Liste des utilisateurs</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Ajouter un utilisateur</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Profil</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->nom }}</td>
                    <td>{{ $user->prenom }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->telephone }}</td>
                    <td>{{ $user->profil }}</td>
                    <td>
                        <!-- Bouton Modifier -->
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Modifier</a>

                        <!-- Bouton Supprimer -->
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <hr class="my-5">

        <!-- ===== Tableau Comptes ===== -->
        <h1>Liste des comptes</h1>
        <a href="{{ route('accounts.create') }}" class="btn btn-primary mb-3">Ajouter un compte</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Utilisateur ID</th>
                    <th>Nom du compte</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($accounts as $account)
                <tr>
                    <td>{{ $account->id }}</td>
                    <td>{{ $account->user_id }}</td>
                    <td>{{ $account->name }}</td>
                    <td>
                        <!-- Bouton Supprimer -->
                        <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Voulez-vous vraiment supprimer ce compte ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</body>
</html>
