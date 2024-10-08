<?php
function printTextInFile($node)
{
    $text = ""; // Initialize the text variable
    $lastWasText = false; // Track if the last node added was text

    foreach ($node->childNodes as $child) {
        // If the node is a text node and is not empty
        if ($child->nodeType === XML_TEXT_NODE && trim($child->textContent) !== '') {
            if ($lastWasText) {
                // If the last added was text, just add the current text without extra newline
                $text .= trim($child->textContent);
            } else {
                // Add the current text followed by a newline
                $text .= trim($child->textContent) . PHP_EOL;
            }
            $lastWasText = true; // Set lastWasText to true
        } 
        // If the node is an element node and has no child nodes
        elseif ($child->nodeType === XML_ELEMENT_NODE && !$child->hasChildNodes()) {
            if ($lastWasText) {
                // If the last added was text, just add the current text without extra newline
                $text .= trim($child->textContent);
            } else {
                // Add the current text followed by a newline
                $text .= trim($child->textContent) . PHP_EOL;
            }
            $lastWasText = true; // Set lastWasText to true
        } 
        // If the node has child nodes, recurse into it
        elseif ($child->hasChildNodes()) {
            $childText = printTextInFile($child); // Get text from child nodes
            if (trim($childText) !== '') { // If the child's text is not empty
                if ($lastWasText) {
                    // If the last added was text, just add the child's text without extra newline
                    $text .= trim($childText);
                } else {
                    // Add the child's text followed by a newline
                    $text .= trim($childText) . PHP_EOL;
                }
                $lastWasText = true; // Set lastWasText to true
            }
        } else {
            $lastWasText = false; // Reset for non-text elements
        }
    }
    return $text;
}


function removeTagsFromDom($object , ...$tags){
    foreach ($tags as $tag) {
        $body = $object->getElementsByTagName($tag);
        while ($body->length > 0) {
            $body->item(0)->parentNode->removeChild($body->item(0));
        }
    }
}

function makeFile($url , ...$tags){
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
        $filePath = $resultDir . '/' . $sanitizedUrl . '.txt';

        if (!is_dir($resultDir)) {
            mkdir($resultDir, 755, true);
        }
        $text = printTextInFile($body);
        file_put_contents($filePath, $text);
        return $filePath ; 
    }

}
