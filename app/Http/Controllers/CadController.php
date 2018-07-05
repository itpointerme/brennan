<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class CadController extends Controller{

	public function cad()
	{	
		return view('cad');
	}

}