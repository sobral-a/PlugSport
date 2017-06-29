<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Un événement arrive!</h2>
<div>
     Le coach de  {{ $team_name }} vous annonce que votre équipe participe à l'événement suivant:
    <ul>
        <li>Nom: {{ $event_name }}</li>
        <li>Date: {{ $event_date }}</li>
    </ul>
</div>

</body>
</html>