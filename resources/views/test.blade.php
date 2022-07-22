<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>Reminder</h1>
    <p>Task: {{ $task->task }}</p>
    <p>Tag: {{ $task->tag->name }}</p>
    <p>Priority: {{ $task->priority }}</p>
    @if($task->start_date !== null)
        <p>Start Date: {{ $task->start_date }}</p>
    @endif
    @if($task->start_time !== null)
        <p>Start Time: {{ $task->start_time }}</p>
    @endif
    @if($task->end_time !== null)
        <p>End Time: {{ $task->end_time }}</p>
    @endif
    @if($task->notes !== null)
        <p>Notes: </p>
        <p>{!! nl2br($task->notes) !!}</p>
    @endif
    @if(count($task->checks) !== 0)
        <p>Checks: </p>
        @foreach ($task->checks as $check)
            @if ($check->completed)
                <input type="checkbox" name="{{$check->id}}" checked>
                <label for="{{$check->id}}"> {{$check->check}} </label><br>
            @else
                <input type="checkbox" name="{{$check->id}}">
                <label for="{{$check->id}}"> {{$check->check}} </label><br>
            @endif
        @endforeach
    @endif
</body>
</html>