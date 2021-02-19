<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CustomException;
use App\Http\Controllers\TriggerHandler;
use App\Http\Resources\RestResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use Illuminate\Database\QueryException;

abstract class RestAPI extends TriggerHandler
{
    protected abstract function getQuery();

    protected abstract function getModel();

    /**
     * Method to check input value before insert/update
     * @param array $lstRecords list object records or object record as array
     * @param array $rules array rules to check
     * @param array $customMsg array custom message
     */
    public function validation($lstRecords, $rules = [], $customMsg = [])
    {
        if (empty($rules)) return;

        foreach ($lstRecords as $index => $record) {
            $validate = Validator::make($record, $rules, $customMsg);
            if ($validate->fails()) {
                throw new CustomException($validate->errors()->first(),
                    CustomException::$INVALID_FIELD,
                    $validate->errors());
            }
        }
    }

    /** Function that need to override in controller */

    /**
     * Function to get validation rule before create
     * @return array list of rules
     */
    public function getCreateRules()
    {
        return [];
    }

    /**
     * Function to get validation rule before update
     * @return array list of rules
     */
    public function getUpdateRules()
    {
        return [
            "id" => "required"
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $model = $this->getModel();
            $lstRecords = $model->queryByModel($request->all());
            //return RestResource::collection($lstRecords);
            //return RestResource::collection($lstRecords);
            //return $lstRecords;
            //return RestResource::collection($lstRecords);
            return $lstRecords;
        } catch (\Exception $ex) {
            return $this->respondError($ex);
        }
    }
    public function query(Request $request){
        try {
            $db = $this->getQuery();
            //             $db = DB::table($table);
            $sql = $request->all();
            $pag = null;
            if(isset($sql['limit'])){
                $pag = $db->select($sql['sql'])->paginate($sql['limit']);
            }
            $results = DB::select($sql['sql']);
            return response()->json(["success"=>true, "data"=>$results,"paginate"=> $pag,"message"=>"Retreved data successfully", "error_code"=>null]);
        } catch (\Exception $ex) {
            return $this->respondError($ex);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $model = $this->getModel();
            $record = $model::findOrFail($id);

            //return single record as resource
            return new RestResource($record);
        } catch (\Exception $ex) {
            return $this->respondError($ex);
        }
    }
    
    /**
     * Store many newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $lstRequestData = $request->all();
            $model = $this->getModel();
            return $this->respondSuccess($model->bulkUpsert($lstRequestData));
        } catch (\Exception $ex) {
            return $this->respondError($ex);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $record = $request->all();
            $model = $this->getModel();
            $record = $model->doUpdate($record);
            return $this->show($record["id"]);
        } catch(QueryException $e){
            $errorCode = $e->errorInfo[1];
            $ms = $e->getMessage();
            if($errorCode == 1062) {
                $ms = 'Record is already exist';
            }
            throw new CustomException( $ms , $e->getCode(), $e->getTrace());
        } catch (\Exception $ex) {
            return $this->respondError($ex);
        }    
    }
    public function updates(Request $request)
    {
        try {
            $lstRequestData = $request->all();
            $model = $this->getModel();
            return $this->respondSuccess($model->doUpdate($lstRequestData));
        } catch(QueryException $e){
            $errorCode = $e->errorInfo[1];
            $ms = $e->getMessage();
            if($errorCode == 1062) {
                $ms = 'Record is already exist';
            }
            throw new CustomException( $ms , $e->getCode(), $e->getTrace());
        } catch (\Exception $ex) {
            return $this->respondError($ex);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $model = $this->getModel();
            $record = $model->doDelete($id);
            if ($record != null) {
                return new RestResource($record);
            }
            return false;
        } catch (\Exception $ex) {
            return $this->respondError($ex);
        }
    }

    public function destroys(Request $request)
    {
        try {
            $ids = $request->all();
            $model = $this->getModel();
            $record = $model::whereIn("id", $ids);

            if ($record->delete()) {
                return $this->respondSuccess([]);
            } else {
                return $this->clientError("Cannot Delete!");
            }

        } catch (\Exception $ex) {
            return $this->respondError($ex);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function search(Request $request)
    {
        try {
            
            $db = $this->getQuery();
//             $db = DB::table($table);
            $parent_table = $this->getModel()->getTableName();
            //$table = $tableSeeting['tablename'];
            if (isset($request['Columns'])) {
                $db->select(explode(',', $request->Columns));
            }
            if (isset($request['SumColumns'])) {
                $db->select(DB::raw($request->SumColumns));
            }
            $db->where($parent_table.'.deleted', false);
            if (isset($request['Filter'])) {
                $this->criteria($db, $request->Filter);
            }
            
            if (isset($request['JoinTable'])) {
                foreach ($request['JoinTable'] as $table) {
                    if('leftJoin' == $table['type']){
                        $db->leftJoin($table['table'], $table['key'], '=', $table['destKey']);
                    }else if('rightJoin' == $table['type']){
                        $db->rightJoin($table['table'], $table['key'], '=', $table['destKey']);
                    }else if('innerJoin' == $table['type']){
                        $db->join($table['table'], $table['key'], '=', $table['destKey']);
                    }
                   
                }

            }
            if(isset($request['Sort'])){
                if(isset($request['Sort']['Direction'])){
                    $db->orderBy($request['Sort']['Column'],$request['Sort']['Direction']);
                }else{
                    $db->orderBy($request['Sort']['Column']);
                }
                
            }

            if (isset($request['Offset'])) {
                $db->skip($request->Offset);
            }

            if (isset($request['Limit'])) {
                $db->take($request->Limit);
            }else{
                $db->take(1001);
            }
            $db->distinct();
            
            //$pagination = $db->groupBy($parent_table.'.id')->paginate($request->Limit);
            //return $db->toSql();
            return response()->json(["success"=>true, "data"=>$db->get(),"paginate"=> $db->groupBy($parent_table.'.id')->paginate($request->Limit),"message"=>"Retreved data successfully", "error_code"=>null]);

        } catch (\Exception $ex) {
            return $this->respondError($ex);
        }
    }

    public function criteria($db, $filter)
    {
        if(!isset($filter["AND"]) && !isset($filter["OR"])){
            return;
        }
        $arrAnd = array_key_exists("AND", $filter) ? $filter["AND"] : [];
        $arrOr = array_key_exists("OR", $filter) ? $filter["OR"] : [];
        
        if(sizeOf($arrAnd)<1 && sizeOf($arrOr)<1){
            return;
        }
        /*
        foreach ($arr as $json) {
            if (array_key_exists("AND", $json)) {
                $this->criteria($db, $json);
            } else if (array_key_exists("OR", $json)) {
                return $this->orCriteria($db, $json);
            } else if (array_key_exists("AND", $filter)) {
                if ($json["Operator"] == "NULL") {
                    $db->whereNull($json["Column"]);
                }else if ($json["Operator"] == "NOT_NULL"){
                    $db->whereNotNull($json["Column"]);
                }else{
                    $db->where($json["Column"], $json["Operator"], $json["Value"]);
                }
                
            } else if (array_key_exists("OR", $filter)) {
                $db->orWhere($json["Column"], $json["Operator"], $json["Value"]);
                if ($json["Operator"] == "NULL") {
                    $db->whereNull($json["Column"]);
                }else if ($json["Operator"] == "NOT_NULL"){
                    $db->whereNotNull($json["Column"]);
                }else{
                    $db->orWhere($json["Column"], $json["Operator"], $json["Value"]);
                }
            }
        }
        */
        
        foreach ($arrAnd as $json) {
            if (array_key_exists("OR", $json) && sizeOf($json["OR"])>0) {
                return $this->orCriteria($db, $json);
            }else if ($json["Operator"] == "NULL") {
                $db->whereNull($json["Column"]);
            }else if ($json["Operator"] == "NOT_NULL"){
                $db->whereNotNull($json["Column"]);
            }else if ($json["Operator"] == "IN"){
                $db->whereIn($json["Column"],$json["Value"]);
            }else if ($json["Operator"] == "NOT_IN"){
                $db->whereNotIn($json["Column"],$json["Value"]);
            }else if ($json["Operator"] == "IN_SUB"){
                $db->whereIn(function ($query) use ($json) {
                    $col = $json['Column'];
                    $sub = $json['Value'];
                    $subTable = $sub['Table'];
                    $subCol = $sub['Column'];
                    $subVal = $sub['Value'];
                    $operator = $sub['Operator'];
                    $query->select($col)->from($subTable)
                    ->where($subCol,$operator, $subVal)
                    ->where($subTable.'.deleted', false);
                    
                });
            }else{
                $db->where($json["Column"], $json["Operator"], $json["Value"]);
                //return $json;
            }
        }
        foreach ($arrOr as $json) {
            if ($json["Operator"] == "NULL") {
                $db->orWhereNull($json["Column"]);
            }else if ($json["Operator"] == "NOT_NULL"){
                $db->orWhereNotNull($json["Column"]);
            }else{
                $db->orWhere($json["Column"], $json["Operator"], $json["Value"]);
            }
        }
        
        
    }

    public function orCriteria($db, $arr)
    {
        $resultError = "";
        
        $db->where(function ($q) use ($arr, &$resultError) {
            foreach ($arr["OR"] as $index => $json) {
                if ($index == 0) {
                    $q->where($arr["Column"], $arr["Operator"], $arr["Value"]);
                }
                if ($json["Operator"] == "NULL") {
                    $q->orWhereNull($json["Column"]);
                }else if ($json["Operator"] == "NOT_NULL"){
                    $q->orWhereNotNull($json["Column"]);
                }else{
                    $q->orWhere($json["Column"], $json["Operator"], $json["Value"]);
                }
                
            }
        });
        return $resultError;
    }


}



