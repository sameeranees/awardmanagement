<?php
/**
 * Created by PhpStorm.
 * User: amber
 * Date: 7/17/18
 * Time: 1:32 PM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = [['title' => 'Download', 'id'=>'#home', 'template'=>'frontend.pages.download'],
                    ['title' => 'How It Works', 'id'=>'#video-sec','template'=> 'frontend.pages.howitworks'],
                    ['title' => 'FAQ', 'id'=>'#faqs-sec','template'=> 'frontend.pages.faq'],
                    ['title' => 'Contact', 'id'=>'#contact-sec','template'=> 'frontend.pages.contact'],
        ];

        return view('frontend.index',compact('pages'));
    }
}
