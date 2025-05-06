<!DOCTYPE html>
<html>
<head>
    <title>Nouveau message de contact</title>
</head>
<body>
    <h2>Nouveau message depuis JobNow</h2>
    
    <p><strong>Nom:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Sujet:</strong> {{ $data['subject'] }}</p>
    
    <h3>Message:</h3>
    <p>{{ $data['message'] }}</p>
    
    <hr>
    <p>Ce message a été envoyé via le formulaire de contact du site JobNow.</p>
</body>
</html>
