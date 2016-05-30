<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/18
 * Time: 16:25
 * Email: jhasheng@hotmail.com
 */

namespace Purple\Controller;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;

class PurpleController extends Controller
{
    protected $app;

    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    public function index($id, $name = 'request')
    {
        $app = $this->app;
        /**
         * @var $storage \Purple\Storage\StorageInterface
         */
        $storage = $app['purple.storage'];

        $result = $storage->retrieve($id);

        $request = $this->app['purple.request'];

        $request->hydra($result);
        
        foreach ($result['content'] as $key => $val) {
            if ($key === $name) {
                $content['current'] = view('purple::modules.' . $name, $val)->render();
                break;
            }
        }

        $content['version'] = Application::VERSION;
        $content['created_at'] = $result->created_at;
        $content['name'] = $name;
        return view('purple::index', $content);
    }
}