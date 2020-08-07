
$( document ).ready(function() {
    listaUrl();
});

function CadastraUrl(){
    if(!$("#url").val()){
        $("#msg").slideDown(100);
        $("#msg").html("URL é obrigatório!");
        setTimeout(function(){ 
            $("#msg").slideUp(100);
        }, 2000);
        return;
    }
    $.ajax({
        type: "POST",
        url: 'http://localhost/TesteEmpresaTCS/api/ShortenURL.php',
        data: {
                url:$("#url").val(),
                alias:$("#alias").val()
              },
        dataType: 'json',
        cache: false
      }).done(function(val) {
            trataRetorno(val);
      }).always(function(val) {
            trataRetorno(val);
      });
}

function trataRetorno(val){
    if(val.ERR_CODE == '000'){
        $("#url").val("");
        $("#alias").val("");
        $("#msg").slideDown(100);
        $("#msg").html(val.message);   
        listaUrl();
    } else {
        $("#msg").slideDown(100);
        $("#msg").html(val.Description);  
    }
    setTimeout(function(){ 
        $("#msg").slideUp(100);
    }, 2000);
}


function listaUrl(){
    var table = "";
    $.ajax({
        type: "POST",
        url: 'http://localhost/TesteEmpresaTCS/api/listaUrl.php',
        dataType: 'json',
        cache: false
      }).done(function(data) {
            for(i=0;i<data.length;i++){
                table = table + "<tr height='40' >"+	
                                "   <th>"+ data[i].id +"</th>"+
                                "   <th>"+ data[i].url +"</th>"+
                                "   <th>"+ data[i].alias +"</th>"+
                                "   <th>"+ data[i].time_taken +"</th>"+
                                "</tr>";
            }
            
            $("#listaUrl").html(table);

      }).always(function(data) {
            
      });
}