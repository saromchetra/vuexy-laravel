<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\OrderDetail;

class TestingController extends Controller
{
    protected $CONT_RE = "Test va";

    public function testPHP(){

        return $this->CONT_RE;
        $lstOrderDetails = OrderDetail::with("order")->get()->toArray();
        $orderDetail = $lstOrderDetails[0];

        return $orderDetail["order"]["customer_id"];


        $strDate = '2019-06-01';
        $date = date_create($strDate);
        
        return date("Y-m-d");
        return date('Y-m-d' , strtotime("+3 months", strtotime($strDate)));

        $orderIds = array("ord05d0b1218c39e2");
        $lstCategories = Categories::where("slug", "interest")->orderBy("created_date", "asc")->get()->toArray();
        $lstItems = Products::where("category_ids", $lstCategories[0]["id"])->get()->toArray();
        return $lstItems;

        // return $lstTermDetails;
        // return isset($paymentTerm["term_details"]) ? "1": "0";
    }
}
