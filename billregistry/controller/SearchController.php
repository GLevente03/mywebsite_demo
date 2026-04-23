<?php
class SearchController extends Search{
    private $bill_number;
    private $from_date;
    private $to_date;
    private $provider_id;
    private $id;
    private $user_id;

    public function __construct($bill_number, $from_date, $to_date, $provider_id, $id, $user_id)
    {
        $this->bill_number = $bill_number;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->provider_id = $provider_id;
        $this->id = $id;
        $this->user_id = $user_id;
    }

    public function getBillEntries(){
        $results = $this->fetchBillEntries($this->bill_number, $this->from_date, $this->to_date, $this->provider_id, $this->user_id);
        return $results;
    }

    public function deleteBill(){
        $this->eraseBill($this->id, $this->user_id);
    }
}