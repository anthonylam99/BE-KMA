<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @php
        if(isset($name)){
            echo $name;
        }
    @endphp
    <form action="" method="POST">
        @csrf
        <label for="">Name: </label>
        <input type="text" name="name" id="name">
        <input type="submit" value="submit">
    </form>
</body>
</html>