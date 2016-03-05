var typeaheadSource = [{
    id: 10, firstName: '500-067', who: 'Отделением УФМС России по Московской обл. в гор. Лобне'}, {
    id: 2, firstName: '321-133' , who: 'СПХ1'}, {
    id: 3, firstName: '413-441' , who: 'СПХ2'
}];

var options =  {
    onComplete: function(cep) {
        $.ajax({
            type: "GET",
            url: "request.php",
            data: "query="+cep+'&method=passport',
            success: function(html){
                document.getElementById('who').value = '';
                document.getElementById('who').value = html;
                console.log('cep changed! ', html);
            }
        });
        //alert('CEP Completed!:' + cep);


    },
    placeholder: "999-999",

    onChange: function(cep){
        console.log('cep changed! ', cep);
    },
    onInvalid: function(val, e, f, invalid, options){
        var error = invalid[0];
        console.log ("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
    }
};

$(document).ready(function() {
    $("#query").mask("999-999", options);
    $("#passSerial").mask("99 99");
    $("#passNumber").mask("999999");

});
$('#family').typeahead({
    onSelect: function(item) {
        console.log(item);
    },
    source: typeaheadSource,
    displayField: 'firstName',
    property: 'who',
    val: 'id'
});


$('#subject_rf').typeahead({

    onSelect: function(html) {
        console.log(html);
        document.getElementById('subject_rf_h').value = '';
        document.getElementById('subject_rf_h').value = html.value;
    },
    ajax: {
        url: '/request.php',
        triggerLength: 1,
        displayField: 'name',
        val: 'id',
        preDispatch: function (query) {
            //showLoadingMask(true);
            //alert (query);
            var w = document.getElementById('subject_rf_h').value;
            //alert (w);
            return {
                method: 'subject',
                query: query
            }
        },
        success: function(json) {
        }
    }
});

$('#city').typeahead({

    onSelect: function(data) {
        console.log(data);
        document.getElementById('city_h').value = '';
        document.getElementById('city_h').value = data.value;
    },
    ajax: {
        url: '/request.php',
        data: {query: document.getElementById('subject_rf_h').value},
        triggerLength: 1,
        displayField: 'name',
        val: 'id',
        preDispatch: function (query) {
            //showLoadingMask(true);
            //alert (query);
            var w = document.getElementById('subject_rf_h').value;
            //alert (w);
            return {
                method: 'city',
                param: w,
                query: query
            }
        },
        success: function(json) {
        }
    }

});

$('#street').typeahead({

    onSelect: function(data) {
        console.log(data);
        document.getElementById('street_h').value = '';
        document.getElementById('street_h').value = data.value;

    },
    ajax: {
        url: '/request.php',
        data: {query: document.getElementById('city_h').value},
        triggerLength: 1,
        displayField: 'name',
        val: 'id',
        preDispatch: function (query) {
            //showLoadingMask(true);
            //alert (query);
            var w = document.getElementById('city_h').value;
            //alert (w);
            return {
                method: 'street',
                param: w,
                query: query
            }
        },
        success: function(json) {
        }
    }
});
