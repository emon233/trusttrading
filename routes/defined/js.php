<?php

    Route::get('/calculateNetReceivableForDailyZone/{comboId}','CalculationController@calculateNetReceivableForDailyZone');
    Route::get('/calculateTotalReceivableForDailyZone/{comboId}','CalculationController@calculateTotalReceivableForDailyZone');
    Route::get('/calculateCompanyClaimAmountForDailyZone/{comboId}','CalculationController@calculateCompanyClaimAmountForDailyZone');
    Route::get('/calculateTotalDueForDailyZone/{comboId}','CalculationController@calculateTotalDueForDailyZone');


    Route::get('/calculateRemainingClaimForBrand/{brandId}','CalculationController@calculateRemainingClaimForBrand');
    Route::get('/calculateRemainingDamageForBrand/{brandId}','CalculationController@calculateRemainingDamageForBrand');
    
    Route::get('/calculateEntryDueForDailyZone/{comboId}','CalculationController@calculateEntryDueForDailyZone');
    Route::get('/calculateEntryPaidForDailyZone/{brandId}','CalculationController@calculateEntryPaidForDailyZone');

    

?>