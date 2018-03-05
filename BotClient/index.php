<html>
<title>Bot Client</title>
<script type="text/javascript" src="activity.js"></script>
<body>
<center>
	<div>
		<input type="text" id="urlBox" value="http://localhost:8085/BotFramework_V2/ServletClass" />
		<input type="button" id="idBtn" value="Connect" onclick="connectServer()" />
	</div>
<div id="frame">
	<iframe src="panel.php" id="iframeElement"></iframe>
	<textarea cols="40" id="textarea"></textarea>
</div>
<div id="footer">
	<input type="text" id="queryBox"/>
	<input type="button" id="sendBtn" onclick="retrieveJSON()"/>
</div>
</center>
</body>
</html>

<script type="text/javascript">
const http = new XMLHttpRequest();
var iframe = document.getElementById("iframeElement");
var activity  = new Activity();
http.onload = () => {
	var jsonStr = http.responseText;
	activity = JSON.parse(jsonStr);
	var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
	innerDoc.getElementById("json").value = jsonStr;
	document.getElementById("textarea").innerHTML = jsonStr;
	if(activity.replyMessage){
		innerDoc.getElementById("hiddenTab").value = activity.replyMessage;
		innerDoc.getElementById("hiddenTab").click();
	}
	document.getElementById("queryBox").value = "";
}
function connectServer(){
	var url = document.getElementById("urlBox").value;
	iframe.contentWindow.location.reload()
	if(activity.contextId){
		url +=  "?contextId="+activity.contextId;
	}
	http.open("GET",url);
	http.send();
}
function retrieveJSON(){	
	var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
	innerDoc.getElementById("darkHidden").value = document.getElementById("queryBox").value;
	activity.text = document.getElementById("queryBox").value;
	var json = JSON.stringify(activity,null,2);
	innerDoc.getElementById("json").value = json;
	innerDoc.getElementById("darkHidden").click();		
	var url = document.getElementById("urlBox").value;
	http.open("POST", url);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-type", "application/json");
	http.send(json);
}

</script>
<style>
iframe{
    height: 100%;
    width: 80%;
}
textarea{
    height:100%;
    float: right;
    background-color: black;
    color: white;
    text-decoration: none;
}
#frame{
    height: 90%;
    width: 95%;
    margin-top: 10px;
}
#footer{
    margin-top: 30px;
    vertical-align: bottom;
}
#sendBtn{
    padding: 9px 28px;
}
#queryBox{
    font-size: 20px;
    padding: 5px 10px;
    width: 70%;
}
body{
    width: 95%;
    height: 95%;
    border: none;
}
#idBtn{
    font-size: 16px;
    color: white;
    font-weight: bold;
    background-color: rgb(53,150,255);
    padding: 10px;
    border: none;
    border-radius: 5px;
    margin-left: 10px;
}
#urlBox{
    font-size: 20px;
    padding: 5px 10px;
    width: 600px;
}
</style>