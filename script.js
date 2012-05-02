/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function login(){
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    //alert(username+password);
    var req = new XMLHttpRequest();
    var url = "/Weblog/login.php";
    var params = "username="+username+"&password="+password;
    req.open("post", url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function(){
        if(req.readyState==4&&req.status==200){
            if(req.responseText==1){
                //alert("geht");
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
    var url = "/Weblog/comment.php";
    var params = "id="+id+"&comment="+encodeURIComponent(comment);
    if(email){
        params+="&email="+email;
    }
    req.open("post", url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function(){
        if(req.readyState==4&&req.status==200){
            //alert("comment abgeschickt");
            window.location.reload();
        }
    }
    req.send(params);
}

function logout(){
    var req = new XMLHttpRequest();
    var url = "/Weblog/logout.php";
    req.open("post", url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function(){
        if(req.readyState==4&&req.status==200){
            //alert("jaja");
            window.location.reload();
        }
    }
    req.send();
}

var editing=false;
var editelement="";

function edit(id, articleid){
    if(!editing){
        editing=true;
        editelement=id;
        /*window.addEventListener("", function(){
            alert("edit end");
        }, false);*/
        var parent = document.getElementById(id);
        var text = parent.innerHTML.replace(/^\s+|\s+$/g,"");
        parent.innerHTML = "";
        var textarea = document.createElement("textarea");
        textarea.style.width = "650px";    
        textarea.value = text;
        textarea.addEventListener("blur", function(event){
            //event.stopPropagation();
            var text = this.value;
            var req = new XMLHttpRequest();
            var url = "/Weblog/saveorupdatearticle.php";
            var params = "articleid="+articleid;
            if(editelement=="article"){
                params += "&text="+encodeURIComponent(text);
            }else{
                params += "&title="+encodeURIComponent(text);
            }
            req.open("post", url, true);
            req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            req.onreadystatechange = function(){
                if(req.readyState==4&&req.status==200){
                    document.getElementById(editelement).innerHTML = text;
                    editelement="";
                    editing=false;
                //alert("editend")
                }
            }
            req.send(params); 
        }, false);
        parent.appendChild(textarea);
        textarea.focus();
        if(editelement=="article"){
            textarea.style.height = ((25 + textarea.scrollHeight + textarea.style.height)<450) ? "450px" : (25 + textarea.scrollHeight + textarea.style.height)+"px" ;
        }
    }
}

function register(){    
    var namealert  =document.createElement("div");
    namealert.id = "namealert";
    namealert.style.top = window.innerHeight/2-50+"px";    
    namealert.style.left = window.innerWidth/2-150+"px";   
    namealert.innerHTML = '<div style="padding-left:0px;" class="login"><input style="width: 190px" type="text" placeholder="your name" id="name"></div><div style="float:right;" class="login"><div class="button" onclick="register2()"><div id="login">register</div></div></div>';
    document.body.insertBefore(namealert, document.body.childNodes[0]);
    window.onresize = function(){
        var namealert = document.getElementById("namealert");
        namealert.style.top = window.innerHeight/2-50+"px";    
        namealert.style.left = window.innerWidth/2-150+"px";  
    }
}

function register2(){
    //alert(username+password);
    var name = document.getElementById("name").value;
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    window.onresize = null;
    document.body.removeChild(document.getElementById("namealert"));
    var req = new XMLHttpRequest();
    var url = "/Weblog/register.php";
    var params = "username="+username+"&password="+password+"&name="+name;
    req.open("post", url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function(){
        if(req.readyState==4&&req.status==200){
            window.location.reload();
        }else{
            //alert("error");
            document.getElementById("error").style.display="inline-block";
        }
    }
    req.send(params); 
}

function deletecomment(id){
    var req = new XMLHttpRequest();
    var url = "/Weblog/deletecomment.php";
    var params = "id="+id;
    req.open("post", url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function(){
        if(req.readyState==4&&req.status==200){
            //alert("deleting");
            window.location.reload();
        }
    }
    req.send(params); 
}

function addarticle(){
    var namealert  =document.createElement("div");
    namealert.id = "articlealert";
    namealert.style.top = window.innerHeight/2-100+"px";    
    namealert.style.left = window.innerWidth/2-150+"px";   
    namealert.innerHTML = '<div><input type="text" placeholder="title" id="atitle"></div><div><textarea id="atextarea"></textarea></div><div style="float:right;"><div class="button" onclick="addarticle2()"><div id="login">ok</div></div></div>';
    document.body.insertBefore(namealert, document.body.childNodes[0]);
    window.onresize = function(){
        var namealert = document.getElementById("articlealert");
        namealert.style.top = window.innerHeight/2-100+"px";    
        namealert.style.left = window.innerWidth/2-150+"px";  
    }
}

function addarticle2(){
    var title = document.getElementById("atitle").value;
    var text = document.getElementById("atextarea").value
    var req = new XMLHttpRequest();
    var url = "/Weblog/saveorupdatearticle.php";
    var params = "&text="+encodeURIComponent(text)+"&title="+encodeURIComponent(title);
    req.open("post", url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function(){
        if(req.readyState==4&&req.status==200){
            window.location.reload();
        }
    }
    req.send(params); 
}