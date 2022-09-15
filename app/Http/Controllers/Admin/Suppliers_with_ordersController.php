<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin;
use App\Models\Suppliers_with_orders;
use App\Models\Suppliers_with_orders_details;
use App\Models\Inv_itemCard;
use App\Models\Inv_uom;
use App\Models\Store;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Suppliers_with_ordersRequest;
class Suppliers_with_ordersController extends Controller
{
    public function index()
    {
        $com_code=auth()->user()->com_code;
        $data = get_cols_where_p(new Suppliers_with_orders(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
        if (!empty($data)) {
            foreach ($data as $info) {
                $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
                $info->supplier_name = Supplier::where('suuplier_code', $info->suuplier_code)->value('name');
                $info->store_name = Store::where('id', $info->store_id)->value('name');
                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
                }
            }
        }

        return view('admin.suppliers_with_orders.index', ['data' => $data]);
    }
    
    public function create()
    {
  $com_code = auth()->user()->com_code;    
   $suupliers=get_cols_where(new Supplier(),array('suuplier_code','name'),array('com_code'=>$com_code,'active'=>1),'id','DESC');     
   $stores=get_cols_where(new Store(),array('id','name'),array('com_code'=>$com_code,'active'=>1),'id','DESC');     

   return view('admin.suppliers_with_orders.create',['suupliers'=>$suupliers,'stores'=>$stores]);
   
}
public function store(Suppliers_with_ordersRequest $request)
    {

        try{

   $com_code = auth()->user()->com_code;
   $supplierData = get_cols_where_row(new Supplier(), array("account_number"), array("suuplier_code" => $request->suuplier_code, "com_code" => $com_code));
   if(empty($supplierData)){
    return redirect()->back()
    ->with(['error' => 'عفوا   غير قادر علي الوصول الي بيانات المورد المحدد' ])
    ->withInput();
   }


    $row=get_cols_where_row_orderby(new Suppliers_with_orders(),array("auto_serial"),array("com_code"=>$com_code),'id','DESC' );
    if(!empty($row)){
        $data_insert['auto_serial']=$row['auto_serial']+1;
    }else{
        $data_insert['auto_serial']=1;
    }
    
            $data_insert['order_date']=$request->order_date;
            $data_insert['order_type']=1;
            $data_insert['DOC_NO']=$request->DOC_NO;
            $data_insert['suuplier_code']=$request->suuplier_code;
            $data_insert['pill_type']=$request->pill_type;
            $data_insert['store_id']=$request->store_id;
            $data_insert['account_number']=$supplierData['account_number'];
           $data_insert['added_by'] = auth()->user()->id;
           $data_insert['created_at'] = date("Y-m-d H:i:s");
           $data_insert['date'] = date("Y-m-d");
           $data_insert['com_code'] = $com_code;
           Suppliers_with_orders::create($data_insert);
           return redirect()->route('admin.suppliers_orders.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
        }catch (\Exception $ex) {
    
            return redirect()->back()
                ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
                ->withInput();
        }
    
    
        } 
    
        public function show($id){
            try{
                $com_code=auth()->user()->com_code;
                $data = get_cols_where_row(new Suppliers_with_orders(), array("*"), array("id" => $id, "com_code" => $com_code,'order_type'=>1));
                 if(empty($data)){
                    return redirect()->route('admin.suppliers_orders.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
                 }
                 $data['added_by_admin']=Admin::where('id',$data['added_by'])->value('name');    
                 $data['supplier_name'] = Supplier::where('suuplier_code', $data['suuplier_code'])->value('name');
                 $data['store_name'] = Store::where('id', $data['store_id'])->value('name');

                 if($data['updated_by']>0 and $data['updated_by']!=null){
                  $data['updated_by_admin']=Admin::where('id',$data['updated_by'])->value('name');    
                     }

            $details=get_cols_where(new Suppliers_with_orders_details(),array("*"),array('suppliers_with_orders_auto_serial'=>$data['auto_serial'],'order_type'=>1,'com_code'=>$com_code),'id','DESC');
            if(!empty($details)){
                foreach($details as $info){
                $info->item_card_name=Inv_itemCard::where('item_code',$info->item_code)->value('name');    
              $info->uom_name=get_field_value(new Inv_uom(),"name",array("id"=>$info->uom_id));

               
                $data['added_by_admin']=Admin::where('id',$data['added_by'])->value('name');    
                if($data['updated_by']>0 and $data['updated_by']!=null){
                 $data['updated_by_admin']=Admin::where('id',$data['updated_by'])->value('name');    
                    }  
            }
            }
        

            return view("admin.suppliers_with_orders.show",['data'=>$data,'details'=>$details]);
            
            
            }catch(\Exception $ex){
            
                return redirect()->back()
                ->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()]);
                          
            
            }
            
            }

public function get_item_uoms(Request $request){
if($request->ajax()){
 $com_code=auth()->user()->com_code; 
$item_code=$request->item_code;
$item_card_Data=get_cols_where_row(new Inv_itemCard(),array("does_has_retailunit","retail_uom_id","uom_id"),array("item_code"=>$item_code,"com_code"=>$com_code));
if(!empty($item_card_Data)){
    if($item_card_Data['does_has_retailunit']==1){
        $item_card_Data['parent_uom_name']=get_field_value(new Inv_uom(),"name",array("id"=>$item_card_Data['uom_id']));
        $item_card_Data['retial_uom_name']=get_field_value(new Inv_uom(),"name",array("id"=>$item_card_Data['retail_uom_id']));
    }else{
        $item_card_Data['parent_uom_name']=get_field_value(new Inv_uom(),"name",array("id"=>$item_card_Data['uom_id']));
    }
}

return view("admin.suppliers_with_orders.get_item_uoms",['item_card_Data'=>$item_card_Data]);

}

}
public function add_new_details(Request $request){
    if($request->ajax()){
     $com_code=auth()->user()->com_code; 
    $item_code=$request->item_code;
    $suppliers_with_ordersData=get_cols_where_row(new Suppliers_with_orders(),array("is_approved","order_date","tax_value","discount_value"),array("auto_serial"=>$request->autoserailparent,"com_code"=>$com_code,'order_type'=>1));
    if(!empty($suppliers_with_ordersData)){
      if($suppliers_with_ordersData['is_approved']==0){
    
      $data_insert['suppliers_with_orders_auto_serial']=$request->autoserailparent;
      $data_insert['order_type']=1;
      $data_insert['item_code']=$request->item_code_add;
      $data_insert['deliverd_quantity']=$request->quantity_add;
      $data_insert['unit_price']=$request->price_add;
      $data_insert['uom_id']=$request->uom_id_Add;
      $data_insert['isparentuom']=$request->isparentuom;
      if($request->type==2){
        $data_insert['production_date']=$request->production_date;
        $data_insert['expire_date']=$request->expire_date;
      }
      $data_insert['item_card_type']=$request->type;
      $data_insert['total_price']=$request->total_add;
      $data_insert['order_date']=$suppliers_with_ordersData['order_date'];
      $data_insert['added_by'] = auth()->user()->id;
      $data_insert['created_at'] = date("Y-m-d H:i:s");
      $data_insert['com_code'] = $com_code;
      $flag=insert(new Suppliers_with_orders_details(),$data_insert);
    if($flag){

     /** update parent pill */   
     $total_detials_sum=get_sum_where(new Suppliers_with_orders_details(),'total_price',array("suppliers_with_orders_auto_serial"=>$request->autoserailparent,'order_type'=>1,'com_code'=>$com_code));
     $dataUpdateParent['total_cost_items']=$total_detials_sum;
     $dataUpdateParent['total_befor_discount']=$total_detials_sum+$suppliers_with_ordersData['tax_value'];
     $dataUpdateParent['total_cost']=$dataUpdateParent['total_befor_discount']-$suppliers_with_ordersData['discount_value'];
     $dataUpdateParent['updated_by'] = auth()->user()->id;
     $dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
    update(new Suppliers_with_orders(),$dataUpdateParent,array("auto_serial"=>$request->autoserailparent,"com_code"=>$com_code,'order_type'=>1));
        echo json_encode("done");
      }
   
      


      }


    }
    
    
    }
    
    }
    
    public function reload_itemsdetials(Request $request){
        if($request->ajax()){
         $com_code=auth()->user()->com_code; 
        $auto_serial=$request->autoserailparent;
        $data = get_cols_where_row(new Suppliers_with_orders(), array("is_approved"), array("auto_serial" => $auto_serial, "com_code" => $com_code,'order_type'=>1));
      if(!empty($data)){
        $details=get_cols_where(new Suppliers_with_orders_details(),array("*"),array('suppliers_with_orders_auto_serial'=>$auto_serial,'order_type'=>1,'com_code'=>$com_code),'id','DESC');
        if(!empty($details)){
            foreach($details as $info){
            $info->item_card_name=Inv_itemCard::where('item_code',$info->item_code)->value('name');    
          $info->uom_name=get_field_value(new Inv_uom(),"name",array("id"=>$info->uom_id));
            $data['added_by_admin']=Admin::where('id',$data['added_by'])->value('name');    
            if($data['updated_by']>0 and $data['updated_by']!=null){
             $data['updated_by_admin']=Admin::where('id',$data['updated_by'])->value('name');    
                }  
        }
        }
      }

        
        return view("admin.suppliers_with_orders.reload_itemsdetials",['data'=>$data,'details'=>$details]);
        
        }
        
        }
        
    
        public function reload_parent_pill(Request $request){
            if($request->ajax()){
          
            $com_code=auth()->user()->com_code;
            $data = get_cols_where_row(new Suppliers_with_orders(), array("*"), array("auto_serial" => $request->autoserailparent, "com_code" => $com_code,'order_type'=>1));
             if(!empty($data)){

                $data['added_by_admin']=Admin::where('id',$data['added_by'])->value('name');    
                $data['supplier_name'] = Supplier::where('suuplier_code', $data['suuplier_code'])->value('name');
   
                if($data['updated_by']>0 and $data['updated_by']!=null){
                 $data['updated_by_admin']=Admin::where('id',$data['updated_by'])->value('name');    
                    }
 return view("admin.suppliers_with_orders.reload_parent_pill",['data'=>$data]);
 
            
            }
            
            }        
}


public function edit($id)
{
    $com_code=auth()->user()->com_code;
    $data = get_cols_where_row(new Suppliers_with_orders(), array("*"), array("id" => $id, "com_code" => $com_code,'order_type'=>1));
    if(empty($data)){
        return redirect()->route('admin.suppliers_orders.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
     }
   
   if($data['is_approved']==1){
    return redirect()->route('admin.suppliers_orders.index')->with(['error'=>'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);

   }
    $suupliers=get_cols_where(new Supplier(),array('suuplier_code','name'),array('com_code'=>$com_code,'active'=>1),'id','DESC');     
   $stores=get_cols_where(new Store(),array('id','name'),array('com_code'=>$com_code,'active'=>1),'id','DESC');     

    return view('admin.suppliers_with_orders.edit', ['data' => $data,'suupliers'=>$suupliers,'stores'=>$stores]);
}



public function update($id, Suppliers_with_ordersRequest $request)
{
    try {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_row(new Suppliers_with_orders(), array("is_approved"), array("id" => $id, "com_code" => $com_code,'order_type'=>1));
        if (empty($data)) {
            return redirect()->route('admin.suppliers_with_orders.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
        }
        $supplierData = get_cols_where_row(new Supplier(), array("account_number"), array("suuplier_code" => $request->suuplier_code, "com_code" => $com_code));
        if(empty($supplierData)){
         return redirect()->back()
         ->with(['error' => 'عفوا   غير قادر علي الوصول الي بيانات المورد المحدد' ])
         ->withInput();
        }
        $data_to_update['order_date']=$request->order_date;
        $data_to_update['order_type']=1;
        $data_to_update['DOC_NO']=$request->DOC_NO;
        $data_to_update['suuplier_code']=$request->suuplier_code;
        $data_to_update['pill_type']=$request->pill_type;
        $data_to_update['store_id']=$request->store_id;
        $data_to_update['account_number']=$supplierData['account_number'];
        $data_to_update['updated_by'] = auth()->user()->id;
        $data_to_update['updated_at'] = date("Y-m-d H:i:s");
        update(new Suppliers_with_orders(),$data_to_update, array("id" => $id, "com_code" => $com_code,'order_type'=>1));
      
        return redirect()->route('admin.suppliers_orders.show',$id)->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
    } catch (\Exception $ex) {

        return redirect()->back()
            ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
            ->withInput();
    }
}

 
public function load_edit_item_details(Request $request){
    if($request->ajax()){
  
    $com_code=auth()->user()->com_code;
    $parent_pill_data = get_cols_where_row(new Suppliers_with_orders(), array("is_approved"), array("auto_serial" => $request->autoserailparent, "com_code" => $com_code,'order_type'=>1));
     if(!empty($parent_pill_data)){
   if($parent_pill_data['is_approved']==0){
    $item_data_detials = get_cols_where_row(new Suppliers_with_orders_details(), array("*"), array("suppliers_with_orders_auto_serial" => $request->autoserailparent, "com_code" => $com_code,'order_type'=>1,'id'=>$request->id));
    $item_cards=get_cols_where(new Inv_itemCard(),array("name","item_code","item_type"),array('active'=>1,'com_code'=>$com_code),'id','DESC');
 
    $item_card_Data=get_cols_where_row(new Inv_itemCard(),array("does_has_retailunit","retail_uom_id","uom_id"),array("item_code"=>$item_data_detials['item_code'],"com_code"=>$com_code));
if(!empty($item_card_Data)){
    if($item_card_Data['does_has_retailunit']==1){
        $item_card_Data['parent_uom_name']=get_field_value(new Inv_uom(),"name",array("id"=>$item_card_Data['uom_id']));
        $item_card_Data['retial_uom_name']=get_field_value(new Inv_uom(),"name",array("id"=>$item_card_Data['retail_uom_id']));
    }else{
        $item_card_Data['parent_uom_name']=get_field_value(new Inv_uom(),"name",array("id"=>$item_card_Data['uom_id']));
    }
}

    return view("admin.suppliers_with_orders.load_edit_item_details",['parent_pill_data'=>$parent_pill_data,'item_data_detials'=>$item_data_detials,'item_cards'=>$item_cards,'item_card_Data'=>$item_card_Data]);


   }



    
    }
    
    } 



}

public function load_modal_add_details (Request $request){
    if($request->ajax()){
  
    $com_code=auth()->user()->com_code;
    $parent_pill_data = get_cols_where_row(new Suppliers_with_orders(), array("is_approved"), array("auto_serial" => $request->autoserailparent, "com_code" => $com_code,'order_type'=>1));
     if(!empty($parent_pill_data)){
   if($parent_pill_data['is_approved']==0){
    $item_cards=get_cols_where(new Inv_itemCard(),array("name","item_code","item_type"),array('active'=>1,'com_code'=>$com_code),'id','DESC');
    return view("admin.suppliers_with_orders.load_add_new_itemdetails",['parent_pill_data'=>$parent_pill_data,'item_cards'=>$item_cards]);


   }



    
    }
    
    } 



}


public function edit_item_details(Request $request){
    if($request->ajax()){
  
    $com_code=auth()->user()->com_code;
    $parent_pill_data = get_cols_where_row(new Suppliers_with_orders(), array("is_approved","order_date","tax_value","discount_value"), array("auto_serial" => $request->autoserailparent, "com_code" => $com_code,'order_type'=>1));
     if(!empty($parent_pill_data)){
   if($parent_pill_data['is_approved']==0){
   
     $data_to_update['item_code']=$request->item_code_add;
    $data_to_update['deliverd_quantity']=$request->quantity_add;
    $data_to_update['unit_price']=$request->price_add;
    $data_to_update['uom_id']=$request->uom_id_Add;
    $data_to_update['isparentuom']=$request->isparentuom;
    if($request->type==2){
      $data_to_update['production_date']=$request->production_date;
      $data_to_update['expire_date']=$request->expire_date;
    }
    $data_to_update['item_card_type']=$request->type;
    $data_to_update['total_price']=$request->total_add;
    $data_to_update['order_date']=$parent_pill_data['order_date'];
    $data_to_update['updated_by'] = auth()->user()->id;
    $data_to_update['updated_at'] = date("Y-m-d H:i:s");
    $data_to_update['com_code'] = $com_code;
    $flag=update(new Suppliers_with_orders_details(),$data_to_update,array("id"=>$request->id,'com_code'=>$com_code,'order_type'=>1,'suppliers_with_orders_auto_serial'=>$request->autoserailparent));

  if($flag){

   /** update parent pill */   
   $total_detials_sum=get_sum_where(new Suppliers_with_orders_details(),'total_price',array("suppliers_with_orders_auto_serial"=>$request->autoserailparent,'order_type'=>1,'com_code'=>$com_code));
   $dataUpdateParent['total_cost_items']=$total_detials_sum;
   $dataUpdateParent['total_befor_discount']=$total_detials_sum+$parent_pill_data['tax_value'];
   $dataUpdateParent['total_cost']=$dataUpdateParent['total_befor_discount']-$parent_pill_data['discount_value'];
   $dataUpdateParent['updated_by'] = auth()->user()->id;
   $dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
  update(new Suppliers_with_orders(),$dataUpdateParent,array("auto_serial"=>$request->autoserailparent,"com_code"=>$com_code,'order_type'=>1));
  
  echo json_encode("done");
    }

   }



    
    }
    
    } 



}



public function delete($id)
{
    try {
        $com_code=auth()->user()->com_code;  
        $parent_pill_data = get_cols_where_row(new Suppliers_with_orders(), array("is_approved","auto_serial"), array("id" => $id, "com_code" => $com_code,'order_type'=>1));
        if(empty($parent_pill_data)){
            return redirect()->back()
            ->with(['error' => 'عفوا حدث خطأ ما']);
        }

      if($parent_pill_data['is_approved']==1){
        if(empty($parent_pill_data)){
            return redirect()->back()
            ->with(['error' => 'عفوا  لايمكن الحذف بتفاصيل فاتورة معتمده ومؤرشفة']);
        }

      }
      $flag=delete(new Suppliers_with_orders(), array("id" => $id, "com_code" => $com_code,'order_type'=>1));
if($flag){
    delete(new Suppliers_with_orders_details(), array("suppliers_with_orders_auto_serial" => $parent_pill_data['auto_serial'], "com_code" => $com_code,'order_type'=>1));  
    return redirect()->route('admin.suppliers_orders.index')->with(['success' => 'لقد تم حذف  البيانات بنجاح']);

}



    } catch (\Exception $ex) {

        return redirect()->back()
            ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
    }
}


public function delete_details($id,$parent_id)
{
    try {
        $com_code=auth()->user()->com_code;  
        $parent_pill_data = get_cols_where_row(new Suppliers_with_orders(), array("is_approved","auto_serial"), array("id" => $parent_id, "com_code" => $com_code,'order_type'=>1));
        if(empty($parent_pill_data)){
            return redirect()->back()
            ->with(['error' => 'عفوا حدث خطأ ما']);
        }

      if($parent_pill_data['is_approved']==1){
        if(empty($parent_pill_data)){
            return redirect()->back()
            ->with(['error' => 'عفوا  لايمكن الحذف بتفاصيل فاتورة معتمده ومؤرشفة']);
        }

      }
        $item_row = Suppliers_with_orders_details::find($id);
        if (!empty($item_row)) {
            $flag = $item_row->delete();
            if ($flag) {
   /** update parent pill */   
   $total_detials_sum=get_sum_where(new Suppliers_with_orders_details(),'total_price',array("suppliers_with_orders_auto_serial"=>$parent_pill_data['auto_serial'],'order_type'=>1,'com_code'=>$com_code));
   $dataUpdateParent['total_cost_items']=$total_detials_sum;
   $dataUpdateParent['total_befor_discount']=$total_detials_sum+$parent_pill_data['tax_value'];
   $dataUpdateParent['total_cost']=$dataUpdateParent['total_befor_discount']-$parent_pill_data['discount_value'];
   $dataUpdateParent['updated_by'] = auth()->user()->id;
   $dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
  update(new Suppliers_with_orders(),$dataUpdateParent,array("id"=>$parent_id,"com_code"=>$com_code,'order_type'=>1));
  


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

public function do_approved($id){

}
}
