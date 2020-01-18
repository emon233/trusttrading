<?php

namespace App;

use App\DebitClaim;
use App\DamageClaim;
use App\Calculation;
use App\DailySheet;
use App\DailyZoneDeliverymanCombo;


use App\AccBrandTotal;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    public static function calculateNetReceivableForDailyZone($comboId)
    {
        $combos = DailySheet::where([['daily_zone_delivery_man_combo_id','=',$comboId]])->get();
        $amount = 0;
        foreach($combos as $key=>$value)
        {
            $amount += ($value->product_out_amount - $value->product_return_amount) * $value->net_unit_price;
        }

        return $amount;
    }

    public static function calculateTotalReceivableForDailyZone($comboId)
    {
        $combos = DailySheet::where([['daily_zone_delivery_man_combo_id','=',$comboId]])->get();
        $amount = 0;

        foreach($combos as $key=>$value)
        {
            $amount += ($value->product_out_amount - $value->product_return_amount) * $value->unit_price;
        }

        return $amount;
    }

    public static function calculateTotalDueForDailyZone($comboId)
    {
        $netAmount = Calculation::calculateNetReceivableForDailyZone($comboId);
        $receivableAmount = Calculation::calculateTotalReceivableForDailyZone($comboId);
        $combo = DailyZoneDeliverymanCombo::getCompanyClaimForCombo($comboId);

        return $receivableAmount - ($combo->total_received + $combo->total_company_claim + $combo->total_damage);
    }

    public static function calculateCompanyClaimAmountForDailyZone($comboId)
    {
        $netAmount = Calculation::calculateNetReceivableForDailyZone($comboId);
        $receivableAmount = Calculation::calculateTotalReceivableForDailyZone($comboId);
        $combo = DailyZoneDeliverymanCombo::getCompanyClaimForCombo($comboId);

        if((($netAmount - $receivableAmount)+$combo->total_company_claim) > 0)
        {
            return (($netAmount - $receivableAmount) + $combo->total_company_claim);
        }

        return 0;
    }

    public static function calculateRemainingClaimForBrand($brandId)
    {
        $combos = DailyZoneDeliverymanCombo::where([['brand_id','=',$brandId]])->get();
        $amount = 0;

        foreach($combos as $key=>$combo)
        {
            $amount += Calculation::calculateCompanyClaimAmountForDailyZone($combo->id);
        }

        $claims = DebitClaim::where([['brand_id','=',$brandId]])->get();
        $paid = 0;

        foreach($claims as $key=>$claim)
        {
            $paid += $claim->debit_received;
        }

        return $amount - $paid;
    }

    public static function calculateRemainingDamageForBrand($brandId)
    {
        $combos = DailyZoneDeliverymanCombo::where([['brand_id','=',$brandId]])->get();
        $amount = 0;

        foreach($combos as $key=>$combo)
        {
            $amount += $combo->total_damage;
        }

        $claims = DamageClaim::where([['brand_id','=',$brandId]])->get();
        $paid = 0;

        foreach($claims as $key=>$claim)
        {
            $paid += $claim->damage_received;
        }

        return $amount - $paid;
    }

    public static function setTotalMarketDueForBrand($brandId)
    {
        $combos = DailyZoneDeliverymanCombo::where([['brand_id','=',$brandId]])->get();
        $amount = 0;

        foreach($combos as $key=>$combo)
        {
            $amount += Calculation::calculateTotalDueForDailyZone($combo->id);
        }

        $paid = 0;

        foreach($combos as $key=>$combo)
        {
            $transactions = AccClientTransaction::where([['daily_zone_deliveryman_id','=',$combo->id],['transaction_type','=','Paid']])->get();

            foreach($transactions as $key=>$transaction)
            {
                $paid += $transaction->transaction_amount;
            }
        }

        $data = AccBrandTotal::where([['brand_id','=',$brandId]])->first();

        $data->total_market_due_amount = $amount - $paid;
        $data->save();
        
        return 1;
    }

    public static function setTotalClaimAmountForBrand($brandId)
    {
        $combos = DailyZoneDeliverymanCombo::where([['brand_id','=',$brandId]])->get();
        $amount = 0;

        foreach($combos as $key=>$combo)
        {
            $amount += Calculation::calculateCompanyClaimAmountForDailyZone($combo->id);
        }

        $claims = DebitClaim::where([['brand_id','=',$brandId]])->get();
        $paid = 0;

        foreach($claims as $key=>$claim)
        {
            $paid += $claim->debit_received;
        }

        $data = AccBrandTotal::where([['brand_id','=',$brandId]])->first();

        $data->total_claim_amount = $amount - $paid;
        $data->save();
        
        return 1;
    }

    public static function setTotalDamageAmountForBrand($brandId)
    {
        $combos = DailyZoneDeliverymanCombo::where([['brand_id','=',$brandId]])->get();
        $amount = 0;

        foreach($combos as $key=>$combo)
        {
            $amount += $combo->total_damage;
        }

        $claims = DamageClaim::where([['brand_id','=',$brandId]])->get();
        $paid = 0;

        foreach($claims as $key=>$claim)
        {
            $paid += $claim->damage_received;
        }

        $data = AccBrandTotal::where([['brand_id','=',$brandId]])->first();

        $data->total_damage_amount = $amount - $paid;
        $data->save();
        
        return 1;
    }

    public static function calculateEntryDueForDailyZone($comboId)
    {
        $combos = AccClientTransaction::where([['daily_zone_deliveryman_id','=',$comboId],['transaction_type','=','Due']])->get();
        $amount = 0;

        foreach($combos as $key=>$combo)
        {
            $amount += $combo->transaction_amount;
        }

        return $amount;
    }

    public static function calculateEntryPaidForDailyZone($comboId)
    {
        $combos = AccClientTransaction::where([['daily_zone_deliveryman_id','=',$comboId],['transaction_type','=','Paid']])->get();
        $amount = 0;

        foreach($combos as $key=>$combo)
        {
            $amount += $combo->transaction_amount;
        }

        return $amount;
    }
}
