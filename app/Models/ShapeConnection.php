<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class ShapeConnection extends Model
{
	use ModelTree, AdminBuilder;

    protected $table = 'shape_connection';
}
