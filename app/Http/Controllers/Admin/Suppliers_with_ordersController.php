<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin;
use App\Models\Suppliers_with_orders;
use App\Models\Suppliers_with_orders_details;
use App\Models\Inv_itemCard;
use App\Models\Inv_uom;

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
   
   return view('admin.suppliers_with_orders.create',['suupliers'=>$suupliers]);
   
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
                $data = get_cols_where_row(new Suppliers_with_orders(), array("*"), array("id" => $id, "com_code" => $com_code));
                 if(empty($data)){
                    return redirect()->route('admin.suppliers_orders.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
                 }
                 $data['added_by_admin']=Admin::where('id',$data['added_by'])->value('name');    
                 $data['supplier_name'] = Supplier::where('suuplier_code', $data['suuplier_code'])->value('name');

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
            //if pill still open
            if($data['is_approved']==0){
                $item_cards=get_cols_where(new Inv_itemCard(),array("name","item_code","item_type"),array('active'=>1,'com_code'=>$com_code),'id','DESC');
            }else{
                $item_cards=array();
            }


            return view("admin.suppliers_with_orders.show",['data'=>$data,'details'=>$details,"item_cards"=>$item_cards]);
            
            
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
    $suppliers_with_ordersData=get_cols_where_row(new Suppliers_with_orders(),array("is_approved","order_date"),array("auto_serial"=>$request->autoserailparent,"com_code"=>$com_code,'order_type'=>1));
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
        echo json_encode("done");
      }
   
      


      }


    }
    
    
    }
    
    }
    
            
}
