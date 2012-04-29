/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function login(){
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    //alert(username+password);
    var req = new XMLHttpRequest();
    var url = "login.php";
    var params = "username="+username+"&password="+password;
    req.open("post", url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function(){
        if(req.readyState==4&&req.status==200){
            if(req.responseText==1){
                alert("geht");
                window.location.reload();
            }else{
                //alert("error");
                document.getElementById("error").style.display="inline-block";
            }
        }
    }
    req.send(params);
}

function postcomment(id){
    var email=null;
    if(document.getElementById("email")){
        email  = document.getElementById("email").value;
    }
    var comment= document.getElementById("comment").value;
    var req = new XMLHttpRequest();
    var url = "comment.php";
    var params = "id="+id+"&comment="+comment;
    if(email){
        params+="&email="+email;
    }
    req.open("post", url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function(){
        if(req.readyState==4&&req.status==200){
            alert("comment abgeschickt");
            window.location.reload();
        }
    }
    req.send(params);
}

function logout(){
    var req = new XMLHttpRequest();
    var url = "logout.php";
    req.open("post", url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function(){
        if(req.readyState==4&&req.status==200){
            window.location.reload();
        }
    }
    req.send();
}