<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload </title>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="604348947953-du2d6ug98pamud5ohdqmsqmtjeoa5fk9.apps.googleusercontent.com">
</head>
<body>
    <h1>Upload File</h1>
    <form action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="file">Choose a file:</label>
        <input type="file" name="file" id="file" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
