/*
 * Obtiene la session 
 */
$.peticion = function (route, dataJson) {
    $.ajax({url: route,
        type: "POST",
        dataType: "json",
        success: function (response) {
            return response;
        },
        error: function (error) {
            console.log(error);
        }
    });
}

$.loadList = function (file) {
    $.post(file, null).error(function (error) {
        console.log(error);
    }).success(function (response) {
        console.log(response);
    });
}

function getParameterFromUrl1(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


function getParameterFromUrl(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if (pair[0] == variable) {
            return pair[1];
        }
    }
    return false;
}