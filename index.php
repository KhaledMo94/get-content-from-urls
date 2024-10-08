<?php
require __DIR__ . '/functions.php';

$url_array = [];
if (!empty($url_array)) {
    foreach ($url_array as $url) {
        makeFile($url, 'nav', 'footer', 'header', 'script', 'style');
    }
}
if (isset($_POST['url'])) {
    if(str_starts_with($_POST['url'],'http')){
        $url = $_POST['url'];
        var_dump($url);
        die;
    }else{
        $url = 'https://' . $_POST['url'];
    }
    $res = makeFile($url, 'nav', 'footer', 'header', 'script', 'style');
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($res) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($res));
    // Clear the output buffer and read the file for download
    ob_clean();
    flush();
    readfile($res);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Download Website Content</title>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Convert Web Content To File</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="basic-url">Your vanity URL</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">https://</span>
                    </div>
                    <input type="text" name="url" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                </div>
            </div>
            <button type="submit">Convert</button>
        </form>
    </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
<?php
exit;
