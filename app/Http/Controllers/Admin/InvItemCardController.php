<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inv_itemCard;
use App\Models\Admin;
use App\Models\inv_itemcard_categorie;
use App\Models\Inv_uom;
use App\Http\Requests\ItemcardRequest;

class InvItemCardController extends Controller
{
 
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data=get_cols_where_p(new Inv_itemCard(),array("*"),array("com_code"=>$com_code),'id','DESC',PAGINATION_COUNT);
        if (!empty($data)) {
            foreach ($data as $info) {
                $info->added_by_admin =get_field_value(new Admin(),'name',array('id'=>$info->added_by));
                $info->inv_itemcard_categories_name =get_field_value(new inv_itemcard_categorie(),'name',array('id'=>$info->inv_itemcard_categories_id));
                $info->parent_item_name =get_field_value(new Inv_itemCard(),'name',array('id'=>$info->parent_inv_itemcard_id));
                $info->Uom_name =get_field_value(new Inv_uom(),'name',array('id'=>$info->uom_id));
                $info->retail_uom_name =get_field_value(new Inv_uom(),'name',array('id'=>$info->retail_uom_id));
                
                
                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by_admin = get_field_value(new Admin(),'name',array('id'=>$info->updated_by));
                }
            }
        }
        $inv_itemcard_categories=get_cols_where(new inv_itemcard_categorie(),array('id','name'),array('com_code'=>$com_code,'active'=>1),'id','DESC');     
        return view('admin.inv_itemCard.index', ['data' => $data,'inv_itemcard_categories'=>$inv_itemcard_categories]);
    }


    public function create()
    {
        $com_code = auth()->user()->com_code;    
   $inv_itemcard_categories=get_cols_where(new inv_itemcard_categorie(),array('id','name'),array('com_code'=>$com_code,'active'=>1),'id','DESC');     
   $inv_uoms_parent=get_cols_where(new Inv_uom(),array('id','name'),array('com_code'=>$com_code,'active'=>1,'is_master'=>1),'id','DESC');     
   $inv_uoms_child=get_cols_where(new Inv_uom(),array('id','name'),array('com_code'=>$com_code,'active'=>1,'is_master'=>0),'id','DESC');     
   $item_card_data=get_cols_where(new Inv_itemCard(),array('id','name'),array('com_code'=>$com_code,'active'=>1),'id','DESC');     

   
   return view('admin.inv_itemCard.create',['inv_itemcard_categories'=>$inv_itemcard_categories,'inv_uoms_parent'=>$inv_uoms_parent,'inv_uoms_child'=>$inv_uoms_child,'item_card_data'=>$item_card_data]);
   
}

    public function store(ItemcardRequest $request){

try{

        $com_code = auth()->user()->com_code;
//set item code for itemcard

$row=get_cols_where_row_orderby(new Inv_itemCard(),array("item_code"),array("com_code"=>$com_code),'id','DESC' );
if(!empty($row)){
    $data_insert['item_code']=$row['item_code']+1;
}else{
    $data_insert['item_code']=1;
}


        //check if not exsits for barcode
        if($request->barcode!=''){
            $checkExists_barcode = Inv_itemCard::where(['barcode' => $request->barcode, 'com_code' => $com_code])->first();
            if (!empty($checkExists_barcode)) {
                return redirect()->back()
                ->with(['error' => 'عفوا باركود الصنف مسجل من قبل'])
                ->withInput();
    
            }else{
                $data_insert['barcode']=$request->barcode;     
            }
        }else{
            $data_insert['barcode']="item".$data_insert['item_code'];          
        }
       
    //check if not exsits for name
        $checkExists_barcode = Inv_itemCard::where(['name' => $request->name, 'com_code' => $com_code])->first();
        if (!empty($checkExists_barcode)) {
            return redirect()->back()
            ->with(['error' => 'عفوا اسم الصنف مسجل من قبل'])
            ->withInput();
        }

        $data_insert['name']=$request->name;
        $data_insert['item_type']=$request->item_type;
        $data_insert['inv_itemcard_categories_id']=$request->inv_itemcard_categories_id;
        $data_insert['uom_id']=$request->uom_id;
        $data_insert['price']=$request->price;
        $data_insert['nos_gomla_price']=$request->nos_gomla_price;
        $data_insert['gomla_price']=$request->gomla_price;
        $data_insert['cost_price']=$request->cost_price;
        $data_insert['does_has_retailunit']=$request->does_has_retailunit;
        $data_insert['parent_inv_itemcard_id']=$request->parent_inv_itemcard_id;
        if($data_insert['parent_inv_itemcard_id']==""){
            $data_insert['parent_inv_itemcard_id']=0;  
        }
       if($data_insert['does_has_retailunit']==1){ 
        $data_insert['retail_uom_quntToParent']=$request->retail_uom_quntToParent;
        $data_insert['retail_uom_id']=$request->retail_uom_id;
        $data_insert['price_retail']=$request->price_retail;
        $data_insert['nos_gomla_price_retail']=$request->nos_gomla_price_retail;
        $data_insert['gomla_price_retail']=$request->gomla_price_retail;
        $data_insert['cost_price_retail']=$request->cost_price_retail;
    
       }

       if($request->has('Item_img')){
        $request->validate([
            'Item_img'=>'required|mimes:png,jpg,jpeg|max:2000',
        ]);
    
      $the_file_path=uploadImage('assets/admin/uploads',$request->Item_img);
      $data_insert['photo']=$the_file_path;
    
       } 
       $data_insert['has_fixced_price']=$request->has_fixced_price;
       $data_insert['active']=$request->active;
       $data_insert['added_by'] = auth()->user()->id;
       $data_insert['created_at'] = date("Y-m-d H:i:s");
       $data_insert['date'] = date("Y-m-d");
       $data_insert['com_code'] = $com_code;
       Inv_itemCard::create($data_insert);
       return redirect()->route('admin.itemcard.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
    }catch (\Exception $ex) {

        return redirect()->back()
            ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
            ->withInput();
    }


    } 


    public function edit($id)
    {
        $data =get_cols_where_row(new Inv_itemCard(),array("*"),array("id"=>$id));
        $com_code = auth()->user()->com_code;    
        $inv_itemcard_categories=get_cols_where(new inv_itemcard_categorie(),array('id','name'),array('com_code'=>$com_code,'active'=>1),'id','DESC');     
        $inv_uoms_parent=get_cols_where(new Inv_uom(),array('id','name'),array('com_code'=>$com_code,'active'=>1,'is_master'=>1),'id','DESC');     
        $inv_uoms_child=get_cols_where(new Inv_uom(),array('id','name'),array('com_code'=>$com_code,'active'=>1,'is_master'=>0),'id','DESC');     
        $item_card_data=get_cols_where(new Inv_itemCard(),array('id','name'),array('com_code'=>$com_code,'active'=>1),'id','DESC');     
        return view('admin.inv_itemCard.edit',['data'=>$data,'inv_itemcard_categories'=>$inv_itemcard_categories,'inv_uoms_parent'=>$inv_uoms_parent,'inv_uoms_child'=>$inv_uoms_child,'item_card_data'=>$item_card_data]);
        
  
    }


    
    public function update($id, ItemcardRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data =get_cols_where_row(new Inv_itemCard(),array("*"),array("id"=>$id));
            if (empty($data)) {
                return redirect()->route('admin.itemcard.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
            }

       //check if not exsits for barcode
       if($request->barcode!=''){
        $checkExists_barcode = Inv_itemCard::where(['barcode' => $request->barcode, 'com_code' => $com_code])->where("id","!=",$id)->first();
        if (!empty($checkExists_barcode)) {
            return redirect()->back()
            ->with(['error' => 'عفوا باركود الصنف مسجل من قبل'])
            ->withInput();

        }else{
            $data_insert['barcode']=$request->barcode;     
        }
    }

   
//check if not exsits for name
    $checkExists_barcode = Inv_itemCard::where(['name' => $request->name, 'com_code' => $com_code])->where("id","!=",$id)->first();
    if (!empty($checkExists_barcode)) {
        return redirect()->back()
        ->with(['error' => 'عفوا اسم الصنف مسجل من قبل'])
        ->withInput();
    }


    $data_to_update['name']=$request->name;
    $data_to_update['item_type']=$request->item_type;
    $data_to_update['inv_itemcard_categories_id']=$request->inv_itemcard_categories_id;
    $data_to_update['uom_id']=$request->uom_id;
    $data_to_update['price']=$request->price;
    $data_to_update['nos_gomla_price']=$request->nos_gomla_price;
    $data_to_update['gomla_price']=$request->gomla_price;
    $data_to_update['cost_price']=$request->cost_price;
    $data_to_update['does_has_retailunit']=$request->does_has_retailunit;
    $data_to_update['parent_inv_itemcard_id']=$request->parent_inv_itemcard_id;
    if($data_to_update['parent_inv_itemcard_id']==""){
        $data_to_update['parent_inv_itemcard_id']=0;  
    }
   if($data_to_update['does_has_retailunit']==1){ 
    $data_to_update['retail_uom_quntToParent']=$request->retail_uom_quntToParent;
    $data_to_update['retail_uom_id']=$request->retail_uom_id;
    $data_to_update['price_retail']=$request->price_retail;
    $data_to_update['nos_gomla_price_retail']=$request->nos_gomla_price_retail;
    $data_to_update['gomla_price_retail']=$request->gomla_price_retail;
    $data_to_update['cost_price_retail']=$request->cost_price_retail;

   }

   if($request->has('photo')){
    $request->validate([
        'photo'=>'required|mimes:png,jpg,jpeg|max:2000',
    ]);
    $oldphotoPath=$data['photo'];
  $the_file_path=uploadImage('assets/admin/uploads',$request->photo);
  if(file_exists('assets/admin/uploads/'.$oldphotoPath ) and !empty($oldphotoPath)){
    unlink('assets/admin/uploads/'.$oldphotoPath);
   }

  $data_to_update['photo']=$the_file_path;

   } 
   $data_to_update['has_fixced_price']=$request->has_fixced_price;
   $data_to_update['active']=$request->active;
  $data_to_update['updated_by'] = auth()->user()->id;
 $data_to_update['updated_at'] = date("Y-m-d H:i:s");
 update(new Inv_itemCard(),$data_to_update,array('id' => $id, 'com_code' => $com_code));
            return redirect()->route('admin.itemcard.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->back()
                ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
                ->withInput();
        }
    }

    public function delete($id)
    {
        try {
            $com_code = auth()->user()->com_code;

            $item_row = get_cols_where_row(new Inv_itemCard(),array("id"),array("id"=>$id,'com_code'=>$com_code) );
            if (!empty($item_row)) {
                $flag = delete(new Inv_itemCard(),array("id"=>$id,'com_code'=>$com_code));
                if ($flag) {
                    return redirect()->back()
                        ->with(['success' => '   تم حذف البيانات بنجاح']);
                } else {
                    return redirect()->back()
                        ->with(['error' => 'عفوا حدث خطأ ما']);
                }
            } else {
                return redirect()->back()
                    ->with(['error' => 'عفوا غير قادر الي الوصول للبيانات المطلوبة']);
            }
        } catch (\Exception $ex) {

            return redirect()->back()
                ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
        }


        
    }

    public function show($id)
    {
        $data =get_cols_where_row(new Inv_itemCard(),array("*"),array("id"=>$id));
        $com_code = auth()->user()->com_code;    
               $data['added_by_admin'] =get_field_value(new Admin(),'name',array('id'=>$data['added_by']));
               $data['inv_itemcard_categories_name'] =get_field_value(new inv_itemcard_categorie(),'name',array('id'=>$data['inv_itemcard_categories_id']));
               $data['parent_item_name'] =get_field_value(new Inv_itemCard(),'name',array('id'=>$data['parent_inv_itemcard_id']));
               $data['Uom_name'] =get_field_value(new Inv_uom(),'name',array('id'=>$data['uom_id']));
             if($data['does_has_retailunit']==1){
                $data['retail_uom_name'] =get_field_value(new Inv_uom(),'name',array('id'=>$data['retail_uom_id']));
             }
                
                if ($data['updated_by'] > 0 and $data['updated_by']  != null) {
                    $data['updated_by_admin'] = get_field_value(new Admin(),'name',array('id'=>$data['updated_by'] ));
                }


                

                
        return view('admin.inv_itemCard.show',['data'=>$data]);
        
  
    }

    public function ajax_search(Request $request){
        if($request->ajax()){
        
            $search_by_text=$request->search_by_text;
            $item_type=$request->item_type;
            $inv_itemcard_categories_id=$request->inv_itemcard_categories_id;
          $searchbyradio=$request->searchbyradio;
            if($item_type=='all'){
                $field1="id";
                $operator1=">";
                $value1=0;
            }else{
                $field1="item_type";
                $operator1="=";
                $value1=$item_type;
            }

            if($inv_itemcard_categories_id=='all'){
                $field2="id";
                $operator2=">";
                $value2=0;
            }else{
                $field2="inv_itemcard_categories_id";
                $operator2="=";
                $value2=$inv_itemcard_categories_id;
            }

            if($search_by_text!=''){

                if( $searchbyradio=='barcode'){
                  
                        $field3="barcode";
                        $operator3="=";
                        $value3=$search_by_text;
                    
                }elseif( $searchbyradio=='item_code'){
                        $field3="item_code";
                        $operator3="=";
                        $value3=$search_by_text;
                    
                }else{
                    $field3="name";
                $operator3="like";
                $value3="%{$search_by_text}%";   
                }



            }else{
                //true 
                $field3="id";
                $operator3=">";
                $value3=0;   
            }

         
      
        


            $data=Inv_itemCard::where($field1,$operator1, $value1)->where($field2,$operator2,$value2)->where($field3,$operator3,$value3)-> orderBy('id','DESC')->paginate(PAGINATION_COUNT);
            if (!empty($data)) {
                foreach ($data as $info) {
                    $info->added_by_admin =get_field_value(new Admin(),'name',array('id'=>$info->added_by));
                    $info->inv_itemcard_categories_name =get_field_value(new inv_itemcard_categorie(),'name',array('id'=>$info->inv_itemcard_categories_id));
                    $info->parent_item_name =get_field_value(new Inv_itemCard(),'name',array('id'=>$info->parent_inv_itemcard_id));
                    $info->Uom_name =get_field_value(new Inv_uom(),'name',array('id'=>$info->uom_id));
                    $info->retail_uom_name =get_field_value(new Inv_uom(),'name',array('id'=>$info->retail_uom_id));
                    
                    
                    if ($info->updated_by > 0 and $info->updated_by != null) {
                        $info->updated_by_admin = get_field_value(new Admin(),'name',array('id'=>$info->updated_by));
                    }
                }
            }
          
            return view('admin.inv_itemCard.ajax_search',['data'=>$data]);
        }
        
        
        }
}
