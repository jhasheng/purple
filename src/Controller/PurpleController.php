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
use Purple\Collections\CollectionInterface;

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

        /**
         * @var $hook \Purple\PurpleHook
         */
        $hook = $app['purple.hook'];
        $current = $hook->getCollection($name);

        $data = $this->buildViewData($result, $current);
//        dd($data);
        return view('purple::index', $data);
    }

    protected function buildViewData($result, CollectionInterface $collection)
    {
        $data = $this->getGlobalData();

        $data['child'] = $this->renderCurrent($collection);
        $data['current'] = $collection;
        $data['storage'] = $result;

        return $data;
    }

    protected function getGlobalData()
    {
        $global = [];
        /**
         * @var $hook \Purple\PurpleHook
         */
        $hook = $this->app['purple.hook'];
        $collections = $hook->getCollections();

        foreach ($collections as $collection) {
            $global = array_merge($collection->getGlobal(), $global);
        }

        $global['menu'] = [];
        return $global;
    }

    protected function renderCurrent(CollectionInterface $collection)
    {
        $collection->live();
//        dd($collection->getData());
        return view("purple::modules.{$collection->getTemplate()}", $collection->getData())->render();
    }
}