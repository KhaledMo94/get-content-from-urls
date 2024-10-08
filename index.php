<?php
require __DIR__ . '/functions.php';

$url_array = [
// put links required to be fetched as string 
];

try {

    foreach ($url_array as $url) {

        $content = file_get_contents($url);

        if ($content === FALSE) {
            echo "Error fetching the content!";
        } else {
            $dom = new DOMDocument();

            @$dom->loadHTML($content);

            removeTagsFromDom($dom, 'nav', 'footer', 'header', 'script', 'style');

            $body = $dom->getElementsByTagName('body')->item(0);

            $resultDir = __DIR__ . '/result';
            $sanitizedUrl = preg_replace('/[^a-zA-Z0-9_\-]/', '_', parse_url($url, PHP_URL_HOST) . parse_url($url, PHP_URL_PATH));
            $filePath = $resultDir . '/' . $sanitizedUrl . 'txt';

            if (!is_dir($resultDir)) {
                mkdir($resultDir, 755, true);
            }
            $text = printTextInFile($body);
            file_put_contents($filePath, $text);
            echo "Urls had been fetched and saved into files successfully";
        }
    }
} catch (\Throwable $th) {
    throw $th;
}
