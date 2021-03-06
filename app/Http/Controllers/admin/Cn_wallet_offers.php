<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Md_wallet_normal_plan;
use App\Models\Md_wallet_offer_plan;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;

class Cn_wallet_offers extends Controller
{

    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function offer_plan_page()
    {
        $class_name ='cn_wallet_offers';
        return view('admin/wallet-offer-plan/wallet_offers_plan',compact('class_name'));
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function add_offerplan()
    {
        $class_name ='cn_wallet_offers';
        return view('admin/wallet-offer-plan/add_wallet_offers_plan',compact('class_name'));
    }

    /**
     * This function are used to edit offer plan.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_edit_offer_plan($encrypt_id)
    {
         try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $offer_plan_data = Md_wallet_offer_plan::where('status', '<>', 3)->select('offer_amount','offer_priority','isoffer_status','discount_value_type','discount_amount','total_calculate_offer_amount','offer_plan_image', 'id', 'created_at','status')->where('id',$id)->get();
            
            // Make id encrypt
            $offer_plan_data[0]->edit_id = Crypt::encryptString($offer_plan_data[0]->id);
            
            //make image url
            $url =Storage::url($offer_plan_data[0]->offer_plan_image);
            $offer_plan_data[0]->show_offer_img = url($url);
            
            $class_name ='cn_wallet_offers';
           
            if(!empty($offer_plan_data[0])){
                return view('admin/wallet-offer-plan/add_wallet_offers_plan',compact('class_name','offer_plan_data'));
            }else{
               return redirect()->route('offer.plan.page')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect()->route('offer.plan.page')->with('error', 'something went wrong');
        }

    }

    

    /**
     * This are used to add Offer Plan Action .
     *
     * @return \Illuminate\Http\Response
     */
    public function offerPlanAction(Request $request)
    {
       $this->validate($request, [
            'offer_amount' => 'required|numeric','offer_priority' => 'required|numeric','isoffer_status' => 'required','discount_value_type' => 'required','discount_amount' => 'required|numeric','total_calculate_offer_amount' => 'required|numeric'
        ]);
        
        $formdata = $request->all();
        $filename = '';
        if($request->has('offer_plan_image')){
            $filename = time().'_'.$request->file('offer_plan_image')->getClientOriginalName();
            $filePath = $request->file('offer_plan_image')->storeAs('public/offer_plan_image',$filename);  
        }else{
            $filePath = $request->offer_image_old;
        }
               
        if(!empty($formdata['txtpkey'])){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($formdata['txtpkey']);
            $data = Md_wallet_offer_plan::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->route('main.categories')->with('message', 'something went wrong');
            }else{
                $formdata['offer_plan_image']   = $filePath;
                $formdata['updated_by']   = session()->get('*$%&%*id**$%#');
                $formdata['updated_ip_address']   = $request->ip();
                $formdata = Arr::except($formdata,['_token','txtpkey','offer_image_old']);
                $Md_mangao_categories = Md_wallet_offer_plan::where('id',$txtpkey)->update($formdata);

                // $formdata['id']   = $txtpkey;

                // $Md_mangao_categories = Md_wallet_offer_plan::update($formdata);
            }
        }else{
            $msg = "Added";
            $formdata['offer_plan_image']   = $filePath;
            $formdata['created_by']   = session()->get('*$%&%*id**$%#');
            $formdata['created_ip_address']   = $request->ip();
            $Md_mangao_categories = Md_wallet_offer_plan::create($formdata);
        }      
       
        return redirect()->route('offer.plan.page')->with('message', 'Offer plan '. $msg);
        
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_data_table_of_offer_plan(Request $request)
    {
        if ($request->ajax()) {
            
            $data = Md_wallet_offer_plan::where('status', '<>', 3)->select('offer_amount','offer_priority','isoffer_status','discount_value_type','offer_plan_image', 'id', 'discount_amount','total_calculate_offer_amount','created_at','status')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. url("/edit-offer-plan") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="Offer plan" table="' . Crypt::encryptString('mangao_wallet_offers_plan') . '" redirect-url="' . Crypt::encryptString('offer.plan.page') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })

                ->addColumn('offer_plan_image', function($data){
                    $url =Storage::url($data['offer_plan_image']);
                    return $offer_plan_image = "<img src=".url($url)."  width='100%' />";
                })
                
                ->rawColumns(['date'])
                ->rawColumns(['action-js','offer_plan_image']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }

    }



}