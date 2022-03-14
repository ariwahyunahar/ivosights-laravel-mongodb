<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todolist</title>
</head>
<body>
    <div>
        Reminder for you,<br>
        <br>
        <b>{{ Carbon\Carbon::parse($todo->todo_at)->format('d M Y, H:i') }}</b><br>
        <b>{{ $todo->name }}</b>,<br>
        {{ $todo->detail }}
    </div>
</body>
</html>