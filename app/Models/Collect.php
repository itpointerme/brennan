<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    protected $table = 'collect';

    public function getgoods()
    {
    	return $this->hasOne(Posts::class, 'ID', 'gid');
    }
}
