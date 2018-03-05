<html>
<script type="text/javascript" src="activity.js"></script>
<body>

<input type="hidden" onclick="createDarkerContainer()" id="darkHidden" value="">
<input type="hidden" onclick="createContainer()" id="hiddenTab" value="">
<input type="hidden" id="json">
<script>
var index=0;
var array = new Array();
function createDarkerContainer(){
	var d = new Date();
	var darkContainer = document.createElement("DIV");
	darkContainer.className = "container darker";
	darkContainer.id = index;
	darkContainer.onclick = function (){
		window.parent.document.getElementById("textarea").innerHTML = array[darkContainer.id];
	};
	array[index] = document.getElementById("json").value;
	var paraGraph = document.createElement("P");
	paraGraph.appendChild(document.createTextNode(document.getElementById("darkHidden").value));
	darkContainer.appendChild(paraGraph);
	var timeleft = document.createElement("SPAN");
	timeleft.className = "time-left";
	timeleft.appendChild(document.createTextNode(d.toLocaleTimeString()));
	darkContainer.appendChild(timeleft);
	document.body.appendChild(darkContainer);	
	document.body.scrollTop += 300;
	index++;
}

function createContainer(){
	var d = new Date();
	var container = document.createElement("DIV");
	container.className = "container";
	container.id = index;
	container.onclick = function (){
		window.parent.document.getElementById("textarea").innerHTML = array[container.id];
	};
	array[index] = document.getElementById("json").value;
	var paragraph = document.createElement("P");
	paragraph.appendChild(document.createTextNode(document.getElementById("hiddenTab").value));
	container.appendChild(paragraph);
	var timeright = document.createElement("SPAN");
	timeright.className = "time-right";
	timeright.appendChild(document.createTextNode(d.toLocaleTimeString()));
	container.appendChild(timeright);
	document.body.appendChild(container);
	
	var activity = JSON.parse(document.getElementById("json").value);
	
	for(var i=0;i<activity.attachments.length;i++){
		var attachment = activity.attachments[i];
		if(attachment.type == "Video"){
			var frame = document.createElement("IFRAME");
			frame.src = attachment.contentUrl + "&user=Mayank&pass=12345";
			container.appendChild(frame);
		}
		else if(attachment.type == "Image"){
			var image = document.createElement("IMG");
			image.src = attachment.contentUrl;
			container.appendChild(image);
		}
		else if(attachment.type == "List"){
			var combo = document.createElement("SELECT");
			combo.onchange = function(){
				window.parent.document.getElementById("queryBox").value = combo.value;
				window.parent.document.getElementById("sendBtn").click();
			}	
			for(var j=0;j<attachment.buttons.length;j++){
				var button = attachment.buttons[j];
				var select = document.createElement("OPTION");
				select.value = button.text;
				select.appendChild(document.createTextNode(button.text));	
				combo.appendChild(select);
			}
			container.appendChild(combo);
		}
		else if(attachment.type == "MultiList"){
			var combo = document.createElement("SELECT");
			combo.multiple = true;
			combo.size = attachment.buttons.length;
			window.parent.document.getElementById("queryBox").value = "";
			combo.onclick = function(){
				window.parent.document.getElementById("queryBox").value += combo.value+";";
				//window.parent.document.getElementById("sendBtn").click();
			}	
			for(var j=0;j<attachment.buttons.length;j++){
				var button = attachment.buttons[j];
				var select = document.createElement("OPTION");
				select.value = button.text;
				select.appendChild(document.createTextNode(button.text));	
				combo.appendChild(select);
			}
			container.appendChild(combo);
		}
		else if(attachment.type == "Confirmation"){
			var buttons = attachment.buttons;
			for(var i=0;i<buttons.length;i++){
				var button = document.createElement("INPUT");
				button.type = "button";
				button.className = "confoButton";
				button.value = buttons[i].text;
				button.onclick = function(){
					window.parent.document.getElementById("queryBox").value = this.value;
					window.parent.document.getElementById("sendBtn").click();
				};
				container.appendChild(button);
			}
		}
	}

	document.body.scrollTop += 1000;
	index++;
}

</script>
<style>
.confoButton{
    padding: 10px;
    font-size: 16px;
    background-color: inherit;
    border-radius: 20px;
    width: 100px;
    margin-left: 50px;
    margin-top: 10px;
    display: block; 
}
select{
    background-color: inherit;
    font-size: 16px;
    padding: 14px;
    border-radius: 5px;
}
option{
    padding: 5px;
}
iframe{
    width: 600px;
    height: 400px;
    display: inline;
}
body {
    margin: 0 auto;
    //max-width: 800px;
    padding: 0 20px;
    overflow-y: scroll;
    vertical-align: bottom;
}

.container {
    border: 2px solid #dedede;
    background-color: #f1f1f1;
    border-radius: 5px;
    padding: 10px;
    margin: 10px 0;
    width: 80%;
    float:left;
}

.darker {
    border-color: #ccc;
    background-color: #ddd;
    float: right;
}

.container::after {
    content: "";
    clear: both;
    display: table;
}

.container img {
    float: left;
    max-width: 60px;
    width: 100%;
    margin-right: 20px;
    border-radius: 50%;
}

.container img.right {
    float: right;
    margin-left: 20px;
    margin-right:0;
}

.time-right {
    float: right;
    color: #aaa;
}

.time-left {
    float: left;
    color: #999;
}
</style>
</html>