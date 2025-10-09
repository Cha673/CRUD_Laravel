<!DOCTYPE html>
<html>
<head>
    <title>Détails de l'utilisateur et comptes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Détails de l'utilisateur et comptes associés</h1>
        
        @if(isset($data['accounts']))
        
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Comptes associés à l'utilisateur #{{$data['userId']}}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID du compte</th>
                                    <th>ID de l'utilisateur</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['accounts'] as $account)
                                <tr>
                                    <td>{{ $account->id }}</td>
                                    <td>{{ $account->user_id }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning">
                Aucun compte trouvé pour cet utilisateur
            </div>
        @endif

        <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Retour</a>
    </div>
</body>
</html>