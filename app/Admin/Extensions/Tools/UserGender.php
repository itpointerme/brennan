<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class UserGender extends AbstractTool
{
    protected function script()
    {
        $url = Request::fullUrlWithQuery(['gender' => '_gender_']);
        return <<<EOT
            $('input:radio.user-gender').change(function () {
                alert('123');
                var url = "$url".replace('_gender_', $(this).val());
                $.pjax({container:'#pjax-container', url: url });
            });

EOT;
    }

    public function render()
    {
        Admin::script($this->script());
        return view('admin.tools.gender');
    }
}