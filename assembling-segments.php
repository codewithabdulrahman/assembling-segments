<?php

function assemble_segments($fragments)
{
    $segments = array();
    $segment = '';
    foreach ($fragments as $fragment) {
        $size = strlen($fragment);
        if ($size < 8) {
            continue;
        }
        if ($size > 256) {
            $chunks = str_split($fragment, 128);
            foreach ($chunks as $chunk) {
                if (strlen($segment) + strlen($chunk) > 256) {
                    $segments[] = $segment;
                    $segment = $chunk;
                } else {
                    $segment .= $chunk;
                }
            }
        } else {
            if (strlen($segment) + $size > 256) {
                $segments[] = $segment;
                $segment = $fragment;
            } else {
                $segment .= $fragment;
            }
        }
    }
    
    if (strlen($segment) > 128 && strlen($segment) < 256) {
        $segments[] = $segment;
    }
    return $segments;
}


$fragments = array('Lorem ipsum', 'dolor sit amet,', 'consectetur adipiscing elit.', 'Proin pharetra massa', 'at semper ullamcorper.');
$segments = assemble_segments($fragments);
print_r($segments);

foreach($segments as $segment)
    echo strlen($segment) . PHP_EOL;


