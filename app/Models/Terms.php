<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    protected $table = 'wp_terms';

    protected $primaryKey = 'term_id';

    public function terms()
    {
    	return $this->belongsTo(TermTaxonomy::class, 'term_id', 'term_id');
    }

    public function gettermtaxonomy(){
    	return $this->hasOne(TermTaxonomy::class, 'term_id', 'term_id');
    }
}