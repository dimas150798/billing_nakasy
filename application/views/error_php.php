<!-- application/views/errors/html/error_php.php -->
<!DOCTYPE html>
<html>

<head>
    <title>PHP Error</title>
</head>

<body>
    <h1>A PHP Error was encountered</h1>
    <p>Severity: <?php echo $severity; ?></p>
    <p>Message: <?php echo $message; ?></p>
    <p>Filename: <?php echo $filepath; ?></p>
    <p>Line Number: <?php echo $line; ?></p>
</body>

</html>