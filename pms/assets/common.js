var horizontal_offset="9px" //horizontal offset of hint box from anchor link

/////No further editting needed

var vertical_offset="0" //horizontal offset of hint box from anchor link. No need to change.
var ie=document.all
var ns6=document.getElementById&&!document.all

function getposOffset(what, offsettype){
var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
var parentEl=what.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset;
}

function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge){
var edgeoffset=(whichedge=="rightedge")? parseInt(horizontal_offset)*-1 : parseInt(vertical_offset)*-1
if (whichedge=="rightedge"){
var windowedge=ie && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-30 : window.pageXOffset+window.innerWidth-40
dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure+obj.offsetWidth+parseInt(horizontal_offset)
}
else{
var windowedge=ie && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure-obj.offsetHeight
}
return edgeoffset
}

function showhint(menucontents, obj, e, tipwidth){
if ((ie||ns6) && document.getElementById("hintbox")){
dropmenuobj=document.getElementById("hintbox")
dropmenuobj.innerHTML=menucontents
dropmenuobj.style.left=dropmenuobj.style.top=-500
if (tipwidth!=""){
dropmenuobj.widthobj=dropmenuobj.style
dropmenuobj.widthobj.width=tipwidth
}
dropmenuobj.x=getposOffset(obj, "left")
dropmenuobj.y=getposOffset(obj, "top")
dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+obj.offsetWidth+"px"
dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+"px"
dropmenuobj.style.visibility="visible"
obj.onmouseout=hidetip
}
}

function hidetip(e){
dropmenuobj.style.visibility="hidden"
dropmenuobj.style.left="-500px"
}

function createhintbox(){
var divblock=document.createElement("div")
divblock.setAttribute("id", "hintbox")
document.body.appendChild(divblock)
}

if (window.addEventListener){
window.addEventListener("load", createhintbox, false)
}else if (window.attachEvent){
window.attachEvent("onload", createhintbox);
}else if (document.getElementById){
window.onload=createhintbox;
}

function modifyCategory(catId)
{
	window.location.href = 'index.php?q=modifycat&catId=' + catId;
}

function deleteCategory(catId)
{
	if (confirm('Deleting category will also delete all products in it.\nContinue anyway?')) {
		window.location.href = 'delcategory.php?catId=' + catId;
	}
}

function viewProduct()
{
	with (window.document.frmListProduct) {
		if (cboCategory.selectedIndex == 0) {
			window.location.href = 'index.php?q=prdlist';
		} else {
			window.location.href = 'index.php?q=prdlist&catId=' + cboCategory.options[cboCategory.selectedIndex].value;
		}
	}
}

function move( idcurr, idnext, ordercurr, ordernext, cate, sub )
{
	window.location.href = 'index.php?q=3734a903022249b3010be1897042568e&idc=' + idcurr + '&idn=' + idnext + '&odc=' + ordercurr + '&odn=' + ordernext + '&catId=' + cate + '&subId=' + sub;
}

function movenews( idcurr, idnext, ordercurr, ordernext)
{
	window.location.href = 'index.php?q=d5038120449bb0c8f7031d4569f11de6&idc=' + idcurr + '&idn=' + idnext + '&odc=' + ordercurr + '&odn=' + ordernext;
}


function pagingOption(self,strGet)
	{
	with (window.document.frmPaging) {
		if (cboPanging.options[cboPanging.selectedIndex].value == 1) {
			window.location.href = self + "&" + strGet;
		} else {
			window.location.href = self + "&" + "page=" + cboPanging.options[cboPanging.selectedIndex].value + "&" + strGet;
		}
	}
	}

function addJob()
{
	window.location.href = 'index.php?q=3f5ba00679c5be449e4675710a793819';
}

function addnews()
{
	window.location.href = 'index.php?q=0d6dc3421d6a2c6c21987631bf7bf869';
}


function findCand()
{
	statusList = window.document.searchCand.cboJobId;
	status     = statusList.options[statusList.selectedIndex].value;

	if (status != '') {
		window.location.href = 'index.php?q=aaea8e805a118b90e86f7044ecfb6d59&jb=' + status;
	} else {
		window.location.href = 'index.php?q=aaea8e805a118b90e86f7044ecfb6d59';
	}
}

function findCandByQual()
{
	statusList = window.document.frmCandQual.qual;
	status     = statusList.options[statusList.selectedIndex].value;

	if (status != '') {
		window.location.href = 'index.php?q=829518a7710f02c65a2480514c47e241&cat=' + status+'&we35ks';
	} else {
		window.location.href = 'index.php?q=829518a7710f02c65a2480514c47e241';
	}
}


function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
}


function updateGrade(g,id) {		
		
	var strURL="includes/upgradecv.php?g="+g+"&id="+id;
	var req = getXMLHTTP();
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('gradediv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
}

