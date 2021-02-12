var item ="";
var show = document.getElementById('show');
function getResponse(){
    var response = new XMLHttpRequest();
    var api = "data.json";
    response.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
             var obj = JSON.parse(this.response);
            for(var i = 0; i < obj.length; i++){
                item += obj[i].username + "<br>";
            }
            show.innerHTML = item;
        }
    }
    response.open('POST', api, true);
    response.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    response.send();    
}
