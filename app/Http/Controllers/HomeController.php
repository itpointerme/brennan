<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function uploadimg(Request $request)
    {
        if($request->isMethod('post'))
        {

            $file =  $request->file('idcard_front');
            if($file){
                $extension = $file -> guessExtension();
                $newName = str_random(18).".".$extension;
                $file -> move(base_path().'/public/storage/uploads',$newName);
                $idCardFrontImg = '/upload/file/'.$newName;
                return json_encode($idCardFrontImg);
            }else{
                $idCardFrontImg = '';
                return json_encode($idCardFrontImg);
            }
        }
    }
}
