function getListItem(){

}
function getShowSetting(no,idEdit,idShow,idHide){
	if(idEdit != ""){
		document.getElementById('titleEditInput').value=document.getElementById(no+"1").innerHTML;
		if(document.getElementById('tinymceEditText') != null){
			document.getElementById('tinymceEditText').value=document.getElementById(no+"2").innerHTML;
			tinyMCE.get('tinymceEditText').setContent(document.getElementById(no+"2").innerHTML);
		}
		if(document.getElementById(no+"3") != null){
			document.getElementById('speakerEditInput').value=document.getElementById(no+"3").innerHTML;
		}
		if(document.getElementById(no+"4") != null){
			if(document.getElementById('dateEditInput') != null){
				document.getElementById('dateEditInput').value=document.getElementById(no+"4").innerHTML;
			}
		}
		if(document.getElementById(no+"99") != null){
			document.getElementById('imgPrev').src = "../uploads/"+document.getElementById(no+"99").innerHTML;
		}
		document.getElementById('idEdit').value=idEdit;
	}
	if(document.getElementById(idShow) != null){
		document.getElementById(idShow).style.display="block";}
	if(document.getElementById(idHide) != null){
		document.getElementById(idHide).style.display="none";}
}
function getCancelSetting(idHide1,idHide2){
	document.getElementById(idHide1).style.display="none";
	document.getElementById(idHide2).style.display="none";
}
function fillTinyACText(idD,dateV,id,text){
	document.getElementById(id).value=text;
	document.getElementById(idD).value=dateV;
}
function addDate(idValue,dateValue){
	document.getElementById(idValue).value= dateValue;
}
function addPageAct(url){
	location.href=url;
}
function delPageAct(url){
	var ok = confirm('Anda yakin akan menghapus page ini?');
	if(ok){
		location.href=url;
	}
}