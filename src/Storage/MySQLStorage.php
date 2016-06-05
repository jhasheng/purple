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


class MySQLStorage extends Model implements StorageInterface
{
    use StorageTrait;

    protected $table = 'purple';

    protected $fillable = ['uuid', 'uri', 'content', 'time'];

    public function retrieve($id)
    {
        return unserialize(DB::table('purple')->where('uuid', $id)->value('content'));
    }

    public function store(Request $request)
    {
        self::create($request->toArray());
    }

    public function purge()
    {
        DB::table('purple')->truncate();
    }
}