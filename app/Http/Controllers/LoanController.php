<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoanController extends Controller
{

    public function customerLoans(Request $request)
    {  
        $loansAvaliable = ["name" => $request->name];
        if ($personalLoan = self::personalLoan($request->income,$request->age,$request->location)) {
            $loansAvaliable += $personalLoan;
        }
        if($assignedLoan = self::assignedLoan($request->income)){
            $loansAvaliable += $assignedLoan;
        }
        if($loanWithGrant = self::loanWithGrant($request->income,$request->age,$request->location)){
            $loansAvaliable += $loanWithGrant;
        }
        return response()->json($loansAvaliable);
    }

    /*
        *   Conceder o empréstimo pessoal se o salário do cliente for igual ou inferior a R$ 3000.
        *   Conceder o empréstimo pessoal se o salário do cliente estiver entre R$ 3000 e R$ 5000, 
        *   se o cliente tiver menos de 30 anos e residir em São Paulo (SP). 
    */
    public function personalLoan(int $income,int $age, String $location): array
    {
        $type = "PERSONAL";
        $interest_rate = 4;
        $personalLoan = ['type' => 'personal','interest_rate' => '4'];
        if($income <= 3000){
            return $personalLoan;
        }elseif($income >= 3000 && $income <= 5000){
            if($age < 30 && $location == "SP"){
                return $personalLoan;
            }
        }
        return [];
    }   
    /* 
    *  Conceder o empréstimo consignado se o salário do cliente for igual ou superior a R$ 5000.
    */
    public function assignedLoan(int $income): array
    {
        $assignedLoan = ["type"=>"GUARANTEED","interest_rate"=>'3'];
        if($income>=5000){
            return $assignedLoan;
        }
        return [];
    }
    /* 
        *   Conceder o empréstimo com garantia se o salário do cliente for igual ou inferior a R$ 3000.
        *   Conceder o empréstimo com garantia se o salário do cliente estiver entre R$ 3000 e R$ 5000, 
        *   se o cliente tiver menos de 30 anos e residir em São Paulo (SP).
    */
    public function loanWithGrant(int $income, int $age, string $location): array
    {
        $loanWithGrant = ["type"=>"CONSIGNMENT","interest_rate"=>2];
        if($income <= 3000){
            return $loanWithGrant;
        }elseif($income >= 3000 && $income <= 5000){
            if ($age < 30 && $location == "SP") {
                return $loanWithGrant;
            }
        }
        return [];
    }

}
