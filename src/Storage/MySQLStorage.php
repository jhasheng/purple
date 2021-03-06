<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 16:32
 * Email: jhasheng@hotmail.com
 */

namespace Purple\Storage;

use DB;
use Purple\Request\Request;
use Illuminate\Database\Eloquent\Model;


class MysqlStorage extends Model implements StorageInterface
{
    use StorageTrait;

    protected $table = 'purple';

    protected $fillable = ['uuid', 'uri', 'content', 'time'];

    /**
     * 获取指定数据
     * @param $token
     * @return array
     */
    public function retrieve($token)
    {
        return unserialize(DB::table('purple')->where('uuid', $token)->value('content'));
    }

    /**
     * 保存收集到的数据
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        self::create($request->toArray());
    }

    /**
     * 清空数据
     * @return void
     */
    public function purge()
    {
        DB::table('purple')->truncate();
    }

    /**
     * 获取所有数据，可分页
     * @param $pageNow
     * @return array
     */
    public function fetch($pageNow)
    {
        $pageSize = $this->app['config']->get('purple.history_size', 10);

        return DB::table('purple')->paginate($pageSize);
    }
}