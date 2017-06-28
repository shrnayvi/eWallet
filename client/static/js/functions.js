function show_templates(templates,id,json=""){
    $.ajax({
        url: templates,
        dataType: 'html',
        success: function(data){
            var template = $(data).filter("#"+id).html();
            var compile_template = Handlebars.compile(template);
            $("#main-content").html(compile_template(json));
        }
    });
}

function request_token_template(email){
    $.ajax({
        url: 'http://localhost/eWallet/client/templates/request_token.php',
        dataType: 'html',
        success: function(data){
            var email_data = { email : email};
            var template = $(data).filter("#request-token").html();
            var compile_template = Handlebars.compile(template);
            $("#main-content").html(compile_template(email_data));
        }
    });
}


//gets cookie by name if exists
function get_cookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}