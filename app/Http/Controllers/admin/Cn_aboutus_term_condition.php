<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Md_mangao_about_terms_masters;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;

class Cn_aboutus_term_condition extends Controller
{
     public function index()
    {

        $class_name ='Cn_aboutus_term_condition';
            $about_data = DB::table(Config::get('constants.MANGAO_ABOUT_TERMS_MASTERS').'  as MATM')->where('MATM.status', '<>', 3)->where('MATM.title_name', '=', 'About Us')->select('MATM.content_details', 'MATM.id')->get();
            if(!empty($about_data[0]->id)){
                $about_data[0]->id = Crypt::encryptString($about_data[0]->id);
            }
            

        return view('admin/content/about_us',compact('class_name','about_data'));
       
    }

      /**
     * This are used to add About Us Action .
     *
     * @return \Illuminate\Http\Response
     */
    public function cmsAction(Request $request)
    {
       $this->validate($request, [
           'title_name' => 'required','content_details' => 'required'
        ]);

        
        // function used for add single array 
        $Md_mangao_about_terms_masters = new Md_mangao_about_terms_masters;
        
            if(!empty($request->txtpkey)){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($request->txtpkey);
            $data = Md_mangao_about_terms_masters::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->back()->with('message', 'something went wrong');
            }else{

                $Md_mangao_about_terms_masters = Md_mangao_about_terms_masters::find($txtpkey);
                $Md_mangao_about_terms_masters->updated_at   = date('Y-m-d h:i:s');
                $Md_mangao_about_terms_masters->updated_by   = session()->get('*$%&%*id**$%#');
                $Md_mangao_about_terms_masters->updated_ip_address   = $request->ip();
            }
        }else{
            $msg = "Added";
            $Md_mangao_about_terms_masters->created_at   = date('Y-m-d h:i:s');
            $Md_mangao_about_terms_masters->created_by   = session()->get('*$%&%*id**$%#');
            $Md_mangao_about_terms_masters->created_ip_address   = $request->ip();
        }      
       
        $Md_mangao_about_terms_masters->title_name   = $request->title_name;
        $Md_mangao_about_terms_masters->content_details   = $request->content_details;
        $Md_mangao_about_terms_masters->save();
    
        


        // this statement are used for getting the last inserted id
       //  $Md_mangao_banner->id;   

        return redirect()->back()->with('message', 'About'. $msg);
    }

    
      /**
     * This are used to add Terms Condition Action .
     *
     * @return \Illuminate\Http\Response
     */

        public function terms_condition_page()
    {

        $class_name ='Cn_aboutus_term_condition';
            $term_data = DB::table(Config::get('constants.MANGAO_ABOUT_TERMS_MASTERS').'  as MATM')->where('MATM.status', '<>', 3)->where('MATM.title_name', '=', 'Terms Condition')->select('MATM.content_details', 'MATM.id')->get();
            if(!empty($term_data[0]->id)){
                $term_data[0]->id = Crypt::encryptString($term_data[0]->id);
            }

            

        return view('admin/content/term_condition',compact('class_name','term_data'));
       
    }


      /**
     * This are used to add Terms Condition Action .
     *
     * @return \Illuminate\Http\Response
     */


        public function privacy_policy_page()
    {

        $class_name ='Cn_aboutus_term_condition';
            $policy_data = DB::table(Config::get('constants.MANGAO_ABOUT_TERMS_MASTERS').'  as MATM')->where('MATM.status', '<>', 3)->where('MATM.title_name', '=', 'Privacy Policy')->select('MATM.content_details', 'MATM.id')->get();
            if(!empty($policy_data[0]->id)){
                $policy_data[0]->id = Crypt::encryptString($policy_data[0]->id);
            }


        return view('admin/content/privacy_policy',compact('class_name','policy_data'));
       
    }

      /**
     * This are used to add Privacy Policy Action .
     *
     * @return \Illuminate\Http\Response
     */

   

   



}
