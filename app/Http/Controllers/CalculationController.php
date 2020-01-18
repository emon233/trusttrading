<?php

namespace App\Http\Controllers;

use App\Calculation;

use Illuminate\Http\Request;

class CalculationController extends Controller
{
    public function calculateNetReceivableForDailyZone($comboId)
    {
        return Calculation::calculateNetReceivableForDailyZone($comboId);
    }

    public function calculateTotalReceivableForDailyZone($comboId)
    {
        return Calculation::calculateTotalReceivableForDailyZone($comboId);
    }

    public function calculateCompanyClaimAmountForDailyZone($comboId)
    {
        return Calculation::calculateCompanyClaimAmountForDailyZone($comboId);
    }

    public function calculateTotalDueForDailyZone($comboId)
    {
        return Calculation::calculateTotalDueForDailyZone($comboId);
    }

    public function calculateRemainingClaimForBrand($brandId)
    {
        return Calculation::calculateRemainingClaimForBrand($brandId);
    }

    public function calculateRemainingDamageForBrand($brandId)
    {
        return Calculation::calculateRemainingDamageForBrand($brandId);
    }

    public function calculateEntryDueForDailyZone($comboId)
    {
        return Calculation::calculateEntryDueForDailyZone($comboId);
    }
    
    public function calculateEntryPaidForDailyZone($comboId)
    {
        return Calculation::calculateEntryPaidForDailyZone($comboId);
    }
}
