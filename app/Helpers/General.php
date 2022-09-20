<?php

function uploadImage($folder, $image)
{
  $extension = strtolower($image->extension());
  $filename = time() . rand(100, 999) . '.' . $extension;
  $image->getClientOriginalName = $filename;
  $image->move($folder, $filename);
  return $filename;
}

/*get some cols by pagination table */
function get_cols_where_p($model, $columns_names = array(), $where = array(), $order_field,$order_type,$pagination_counter)
{
  $data = $model::select($columns_names)->where($where)->orderby($order_field, $order_type)->paginate($pagination_counter);
  return $data;
}
/*get some cols by pagination table where 2 */
function get_cols_where2_p($model, $columns_names = array(), $where = array(),$where2field,$where2operator,$where2value, $order_field,$order_type,$pagination_counter)
{
  $data = $model::select($columns_names)->where($where)->where($where2field,$where2operator,$where2value)->
  orderby($order_field, $order_type)->paginate($pagination_counter);
  return $data;
}

/*get some cols  table */
function get_cols_where($model, $columns_names = array(), $where = array(), $order_field,$order_type)
{
  $data = $model::select($columns_names)->where($where)->orderby($order_field, $order_type)->get();
  return $data;
}
/*get some cols  table */
function get_cols($model, $columns_names = array(), $order_field,$order_type)
{
  $data = $model::select($columns_names)->orderby($order_field, $order_type)->get();
  return $data;
}
/*get some cols row table */
function get_cols_where_row($model, $columns_names = array(), $where = array())
{
  $data = $model::select($columns_names)->where($where)->first();
  return $data;
}

/*get some cols row table */
function get_cols_where2_row($model, $columns_names = array(), $where = array(),$where2 = "")
{
  $data = $model::select($columns_names)->where($where)->where($where2)->first();
  return $data;
}
/*get some cols row table order by */
function get_cols_where_row_orderby($model, $columns_names = array(), $where = array(), $order_field,$order_type)
{
  $data = $model::select($columns_names)->where($where)->orderby($order_field, $order_type)->first();
  return $data;
}

/*get some cols table */
function insert($model, $arrayToInsert=array())
{
  $flag = $model::create($arrayToInsert);
  return $flag;
}
function get_field_value($model, $field_name , $where = array())
{
  $data = $model::where($where)->value($field_name);
  return $data;
}

function update($model,$data_to_update,$where=array()){
  $flag=$model::where($where)->update($data_to_update);
  return $flag;
}

function delete($model,$where=array()){
  $flag=$model::where($where)->delete();
  return $flag;
}

function get_sum_where($model,$field_name,$where=array()){
  $sum=$model::where($where)->sum($field_name);
  return $sum;
}

function get_user_shift($Admins_Shifts,$Treasuries,$Treasuries_transactions){
  $com_code=auth()->user()->com_code;
  $data = $Admins_Shifts::select("treasuries_id","shift_code")->where(["com_code"=>$com_code,"admin_id"=>auth()->user()->id,"is_finished"=>0])->first();
  if(!empty($data)){
    $data['name']=$Treasuries::where(["id"=>$data["treasuries_id"],"com_code"=>$com_code])->value("name");
    $data['balance']=$Treasuries_transactions::where(["shift_code"=>$data["shift_code"],"com_code"=>$com_code])->sum("money");

  }
  return $data;
}