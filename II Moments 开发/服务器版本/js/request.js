function sendAjax(url,method,param,fnSucc)
{
    //url="./../../fuckwebsite/eventback.php?id=1";
    var request = new ajaxRequest();
    //request.open("GET", "urlget.php?url=amazon.com/gp/aw" + nocache, true)
    //request.open("GET", "./../../fuckwebsite/eventback.php?id=1",true);
    if(method==="GET")
    {
        //alert(url+"?"+param);
        request.open("GET",url+"?"+param,true);
        request.send(null);
    }
    else if(method==="POST")
    {
        request.open("POST",url,true)
        request.setRequestHeader('content-type','application/x-www-form-urlencoded');
        request.send(param);
    }



    request.onreadystatechange = function()
    {
        if (this.readyState === 4)
        {
            if (this.status === 200)
            {
                if (this.responseText != null)
                {
                    //document.getElementById('info').innerHTML =String(this.responseText);
                    //fnSucc(this.responseText);
                    //alert(this.responseText)
                    var obj=JSON.parse(this.responseText);
                    fnSucc(obj);
                }
                else alert("Ajax error: No data received")
            }
            else alert( "Ajax error: " + this.statusText)
        }
    }
}

function getHsonLength(json){
    var jsonLength=0;
    for (var i in json) {
        jsonLength++;
    }
    return jsonLength;
}

function ajaxRequest()
{
    try
    {
        var request = new XMLHttpRequest()
    }
    catch(e1)
    {
        try
        {
            request = new ActiveXObject("Msxml2.XMLHTTP")
        }
        catch(e2)
        {
            try
            {
                request = new ActiveXObject("Microsoft.XMLHTTP")
            }
            catch(e3)
            {
                request = false
            }
        }
    }
    return request
}