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
    protected $table = 'anbu';

    protected $fillable = ['uuid', 'uri', 'storage', 'time'];

    public function store(Request $request)
    {
        try {
//            DB::table('anbu')->insert($request->toArray());
            self::create($request->toArray());
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

    public function find($id)
    {
        return DB::table('anbu')->find($id);
    }

    public function clear()
    {
        DB::table('anbu')->truncate();
    }
}