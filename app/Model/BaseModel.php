<?php
namespace App\Model;

use App\Exceptions\CustomException;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Model;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Object_;

class BaseModel extends Model
{

    protected $with =['created_by_obj','updated_by_obj'];
    protected $duplicateField;
    public function created_by_obj(){
        return $this->hasOne('App\Model\User', 'id', 'created_by');
    }
    public function updated_by_obj(){
        return $this->hasOne('App\Model\User', 'id', 'updated_by');
    }
    public function prefixId(){
        return "Id";
    }
    protected function getPrefix(){
        return "";
    }
    public function getTableName(){
        return $this->table;
    }
    protected  function isCandelete($rec){
        return true;
    }
    public function isDuplicateRecord($record){
        if($this->duplicateField != null && !empty($this->duplicateField)){
            $model = $this->getQuery();
            foreach ($this->duplicateField as $index => $field) {
                $model->where($field, $record[$field]);
            }
            if(isset($record['id'])){
                $model->where($field, '!=', $record[$field]);
            }
            
        }
        return false;
    }
    protected function getQuery(){
        return $this::query();
    }
    protected function getInvoiceNumberField(){
        return "";
    }
    protected function productMoveOut($pid,$quantity){
        
    }
    public function getInvoiceNumber($prefix,$invNum){

        //$curD = date('Y');
        $preD = $prefix. date('Y');
        $inv = 0;
        if($invNum != '' && isset($invNum) && !empty($invNum)){
            $arr = explode('-',$invNum);
            if($preD == $arr[0]){
                $inv = (int)$arr[1];
            }
        }
        return $preD .'-'. sprintf('%07d', ((int)$inv+1));

    }
    public function getNextInvoice()
    {
        $invoiceNumber = new InvoiceNumber();
        //$model = $this->getQuery();
        $rec = $invoiceNumber->where("type",$this->getPrefix())->latest()->orderBy('created_date','desc')->first();
        $invNum = '';
        if($rec != null && !empty($rec)){
            $invNum = $rec['current_number'];
        }else{
            $rec = [];
            $rec['type'] = $this->getPrefix();
        }
        $newInv = $this->getInvoiceNumber($this->getPrefix(),$invNum);
        $rec['current_number'] = $newInv;
        return $rec;
    }
    
    public function generateSysFields($record, $isUpdate=false){
        if (!$isUpdate) {
            $record['id'] = $this->generateId($this->prefixId());
            $record['created_by'] =  Auth::user()->id;
            //$record['created_date'] = Carbon::now()->format('Y-m-d H:i:s');
        }
        $record['updated_by'] = Auth::user()->id;
        $record['updated_date'] = Carbon::now()->format('Y-m-d H:i:s');

        return $record;
    }
    public static function generateId($preFixId) {
        return uniqid($preFixId.'0');
    }
    public function getChilds($rec){
        if(isset($rec['child']) || empty($rec['child']) ){
            return $rec['child'];
        }
        return null;
    }
    public function getMode($name){
        $path = 'App\Model\\'.$name;
        return app($path);
    }

    public function doInsert($record){
        
        if(!empty($this->getInvoiceNumberField())){
            $invoiceRec = $this->getNextInvoice();
            $invoiceNumber = new InvoiceNumber();
            if(!isset($invoiceRec['id'])){
                $invoiceNumber->doInsert($invoiceRec);
            }else{
                $invoiceNumber->doUpdate($invoiceRec->attributesToArray());
            }
            $record[$this->getInvoiceNumberField()] = $invoiceRec['current_number'];
            $record['current_number'] = $invoiceRec;
        }
        
        $record = $this->beforeInsert($record);
        $record = $this->generateSysFields($record,false);
        // $this::updateOrCreate(["id" => $record['id']], $record);
        $record = $this->doUpsert($record);
        $record = $this->afterInsert($record);
        return $record;
    }
    public function doUpdate($record){
        $this->beforeUpdate($record);
        $record = $this->generateSysFields($record,true);
        $record = $this->doUpsert($record);
        $this->afterUpdate($record);
        return $record;
    }
    public function getSearchColumns(){
        return [];
    }

    public function doUpsert($record){
        $this::updateOrCreate(["id" => $record['id']], $record);
        return $record;
    }
    public function bulkUpsert($records){
        return $this->commit($records);
    }
    public function checkArray($lstRecords){
        foreach ($lstRecords as $index => $record) {
            return !is_string($index);
        }
    }
    public function commit($records){
        if (!empty($records) ) {

            DB::beginTransaction();
            try {
                $lstRecordUpserted = [];
                if(!$this->checkArray($records)){

                    if(isset($records['id']) && !empty($records['id'])){
                        $lstRecordUpserted[] = $this->doUpdate($records);
                    }else{
                        $lstRecordUpserted[] = $this->doInsert($records);
                    }
                }else{

                    foreach ($records as $index => $record) {
                        //it is array
                        if(isset($record['id']) && !empty($record['id'])){
                            $lstRecordUpserted[] = $this->doUpdate($record);
                        }else{
                            $lstRecordUpserted[] = $this->doInsert($record);
                        }
                    }

                }
                DB::commit();
                $lstFilterNull = array_filter($lstRecordUpserted, function ($var) {
                    return ((isset($var) && !empty($var)) || $var === 0);
                });
                $lstIds = [];
                foreach ($lstFilterNull as $index => $record) {
                    $lstIds[] = $record["id"];
                }
                if (!empty($lstIds)) {
                    $lstRecords = $this->queryByModel(["id" => implode(",", $lstIds), "limit" => (count($lstIds) + 1)]);
                    return $lstRecords;
                }
                return [];
            } catch(QueryException $e){
                DB::rollback();
                throw new CustomException( $e->getMessage() , $e->getCode(), $e->getTrace());
            }catch (\Exception $e) {
                DB::rollback();
                throw new CustomException($e->getMessage() , $e->getCode(), $e->getTrace());
            }
        }
    }
    public function beforeInsert($record){
        if($this->isDuplicateRecord($record)){
            throw new CustomException("Record is already existed", 400);
        }
        return $record;
    }
    public function beforeUpdate($record){
        if($this->isDuplicateRecord($record)){
            throw new CustomException("Record is already existed", 400);
        }
        return $record;
    }
    public function doDelete($id){
        $record = $this::where("id", $id)->first();
        if(!$this->isCandelete($record)){
            throw new CustomException("Record is already in used", 400);
        }
        $record = $this->beforeDelete($record);
//         $record = $this::update($record);
        $record = $this->afterDelete($record);
        return $record;
    }
    public function beforeDelete($record){
        return $record;
    }
    public function afterDelete($record){
        return $record;
    }
    public function afterInsert($record){
        return $record;
    }
    public function afterUpdate($record){
        return $record;
    }
   
    public function queryByModel($lstFilters = []){
        $model = $this->getQuery();
        $withObject = [];
        $withCountObj = [];
        $limit = 50;
        $orderCol = "created_date";
        $orderby = "desc";

        //added filter query before get data
        foreach ($lstFilters as $colName => $value) {

            //get all additional objects present in model
            if($colName == "with"){
                $withObject = explode(",", $value);
                continue;
            }

            //get all with count obj
            if($colName == "with_count"){
                $withCountObj = explode(",", $value);
                continue;
            }

            if($colName == 'page') continue;


            if($colName == 'order_by') {
                $orderby = $value;
                continue;
            }
            if($colName == 'order_col') {
                $orderCol = $value;
                continue;
            }
            if($colName == 'limit'){
                $limit = $value;
                continue;
            }

            //to check if column need check condition with whereraw
            //the request will has prefix "whereraw_"
            if(strpos($colName, 'whereraw') !== false){

                if(!isset($value) || empty($value)){
                    continue;
                }
                $colName = str_replace("whereraw_", "", $colName);

                if(strpos($value, ",") === false){
                    $model->whereRaw("find_in_set('".$value."', $colName)");
                }else{
                    $lstVal = explode(",", $value);

                    foreach($lstVal as $index => $val){
                        $model->orWhereRaw("find_in_set('".$val."', $colName)");
                    }
                }
                continue;
            }

            //for query by checking if relationship existence
            if(strpos($colName, 'has__') !== false){
                $colName = str_replace("has__", "", $colName);
                $model->has($colName, '>', 0);
                continue;
            }

            //for query year
            if(strpos($colName, 'year__') !== false){
                $colName = str_replace("year__", "", $colName);
                $model->whereYear($colName, $value);
                continue;
            }

            //for query month
            if(strpos($colName, 'month__') !== false){
                $colName = str_replace("month__", "", $colName);
                $model->whereMonth($colName, $value);
                continue;
            }

            //if value is string null, we change it to use null variable
            if(!isset($value) || $value == 'null'){
                $model->where($colName, null);

            }else
                //if there are no comma in value, it means we need to search by whole value
                if(strpos($value, ",") === false){
                    //check with condition greater than
                    if(strpos($colName, 'g__') !== false){
                        $colName = str_replace("g__", "", $colName);
                        $model->where($colName, '>', $value);
                    }else
                        //check with condition greater  than or equals
                        if(strpos($colName, 'ge__') !== false){
                            $colName = str_replace("ge__", "", $colName);
                            $model->where($colName, '>=', $value);
                        }else
                            //check with condition less than
                            if(strpos($colName, "l__") !== false){
                                $colName = str_replace("l__", "", $colName);
                                $model->where($colName, '<', $value);
                            }else
                                //check with condition less than or equals
                                if(strpos($colName, "l__") !== false){
                                    $colName = str_replace("le__", "", $colName);
                                    $model->where($colName, '<=', $value);
                                }

                    //check value of column not equals value provided
                    if(strpos($colName, "not__") !== false){
                        $colName = str_replace("not__", "", $colName);
                        $model->where($colName, '!=', $value);
                    }

                    //check if value is null
                    if(strpos($colName, "null__") !== false){
                        $colName = str_replace("null__", "", $colName);
                        $model->whereNull($colName);
                    }
                    //default condition equals
                    else{
                        $model->where($colName, $value);
                    }
                    
                }
                //if there are more than one value, we switch to use whereIn
                //comma identify that it has multiple value
                else{
                    $lstVal = explode(",", $value);
                    $model->whereIn($colName, $lstVal);
                }
        }

        if(!empty($withObject)){
            foreach ($withObject as $index => $withName) {
               // $model->with($withName);
            }
        }

        if(!empty($withCountObj)){
            foreach ($withCountObj as $index => $withName) {
               // $model->withCount($withName);
            }
        }
        $model->orderBy($orderCol, $orderby);

        $lstResults = $model->paginate($limit)->appends(Request::input('page'));
        return $lstResults;
    }
}

