<?php
/**
 * Created by PhpStorm.
 * User: krasen
 * Date: 6/1/2016
 * Time: 11:44 PM
 */

namespace Purple\Collections;

use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;

class Info extends AbstractCollection
{
    protected $name = 'info';

    protected $template = 'info';

    protected $icon = 'info-circle';

    public function after(Application $app, Response $response)
    {
        parent::after($app, $response);
    }

    public function live()
    {
        // Start output buffer.
        ob_start();
        // Execute PHP info function.
        phpinfo();
        // Capture buffer contents.
        $info = ob_get_contents();
        // Clear the buffer.
        ob_end_clean();
        // We only want the body.
        $info = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $info);
        // Extract PHP version.
        preg_match('/\<h1 class=\"p\"\>PHP Version ([\d.]+)\<\/h1\>/', $info, $matches);
        // Replace the second title.
        $info = preg_replace('/\<h1 class=\"p\"\>PHP Version ([\d.]+)\<\/h1\>/', null, $info);
        // Set version into data array.
        $this->data['version'] = array_get($matches, '1');
        // Store in data array.
        $this->data['info'] =  $info;
    }
}