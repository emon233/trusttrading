
function calculations()
{
    let comboId = $('#comboId').val();

    calculateNetReceivableForDailyZone(comboId);
    calculateTotalReceivableForDailyZone(comboId);
    calculateCompanyClaimAmountForDailyZone(comboId);
    calculateTotalDueForDailyZone(comboId);
}

function transactions()
{
    let comboId = $('#comboId').val();

    calculateEntryDueForDailyZone(comboId);
    calculateEntryPaidForDailyZone(comboId);
}


function calculateNetReceivableForDailyZone(comboId)
{
    var url = '/calculateNetReceivableForDailyZone/'+comboId;

    $.ajax({
        url:url,
        method:'get',
        success:function(data)
        {
            $('#net_receivable').val(data);
            $('#net_receivable').html(data);
        },
        error:function(data)
        {
            console.log(data);
        }
    });
}

function calculateTotalReceivableForDailyZone(comboId)
{
    var url = '/calculateTotalReceivableForDailyZone/'+comboId;

    $.ajax({
        url:url,
        method:'get',
        success:function(data)
        {
            $('#total_receivable').val(data);
            $('#total_receivable').html(data);
        },
        error:function(data)
        {
            console.log(data);
        }
    });
}

function calculateCompanyClaimAmountForDailyZone(comboId)
{
    var url = '/calculateCompanyClaimAmountForDailyZone/'+comboId;

    $.ajax({
        url:url,
        method:'get',
        success:function(data)
        {
            $('#total_claimable').val(data);
            $('#total_claimable').html(data);
        },
        error:function(data)
        {
            console.log(data);
        }
    });
}

function calculateTotalDueForDailyZone(comboId)
{
    var url = '/calculateTotalDueForDailyZone/'+comboId;

    $.ajax({
        url:url,
        method:'get',
        success:function(data)
        {
            $('#total_due').val(data);
            $('#total_due').html(data);
        },
        error:function(data)
        {
            console.log(data);
        }
    });
}


function calculateRemainingClaimForBrand(brandId)
{
    var url = '/calculateRemainingClaimForBrand/'+brandId;

    $.ajax({
        url:url,
        method:'get',
        success:function(data)
        {
            $('#claimable_amount').val(data);
        },
        error:function(data)
        {
            console.log(data);
        }
    });
}

function calculateRemainingDamageForBrand(brandId)
{
    var url = '/calculateRemainingDamageForBrand/'+brandId;

    $.ajax({
        url:url,
        method:'get',
        success:function(data)
        {
            console.log(data);
            $('#damage_amount').val(data);
        },
        error:function(data)
        {
            console.log(data);
        }
    });
}

function calculateEntryDueForDailyZone(comboId)
{
    var url = '/calculateEntryDueForDailyZone/'+comboId;

    $.ajax({
        url:url,
        method:'get',
        success:function(data)
        {
            $('#due-today').html(data);
        },
        error:function(data)
        {
            console.log(data);
        }
    });
}

function calculateEntryPaidForDailyZone(comboId)
{
    var url = '/calculateEntryPaidForDailyZone/'+comboId;

    $.ajax({
        url:url,
        method:'get',
        success:function(data)
        {
            $('#due-collection-today').html(data);
        },
        error:function(data)
        {
            console.log(data);
        }
    });
}

