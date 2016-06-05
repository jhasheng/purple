<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 17:23
 * Email: jhasheng@hotmail.com
 */

namespace Purple\Adapter;

use DB;
use Illuminate\Database\Eloquent\Model;
use Purple\Request\Request;

class MySQL extends Model implements AdapterInterface
{
    protected $table = 'purple';

    protected $fillable = ['uuid', 'uri', 'content', 'time'];

    public function store(Request $request)
    {
        try {
            self::create($request->toArray());
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

    public function retrieve($id)
    {
        return DB::table('purple')->where('uuid', $id)->first();
    }

    public function clear()
    {
        DB::table('purple')->truncate();
    }
}