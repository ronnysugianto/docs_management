var countImg = 0;
function addImageInput(id){
    if(getInternetExplorerVersion() == 8.0 || getInternetExplorerVersion() == 7.0){
        var temp = document.getElementsByName('temp')[0];
        var text = "";
        for(var i=0;i<countImg;i++){
            text += "<tr><td>Gambar "+(i+1)+"</td><td>"+
                "<input type=file name='images[]' class='bginput'></td>"+
                "<td><label>Nama "+(i+1)+"</label><input type=text name='nama[]' size='30'/></td></tr>"+
                "<tr><td colspan=2 height=\"5px\"></td></tr>"
        }
        countImg++;
        temp.innerHTML = '<table border="0" cellspacing="1" cellpadding="2" width="620px"><tbody id="uploadTable" name="uploadTable">'+text+'</tbody></table>';
        var tb = document.getElementsByName('uploadTable')[0];
        tb.parentNode.replaceChild(temp.firstChild.firstChild, tb);
        tb.style="font-size:0.8em;";
    }else{
        document.getElementById(id).innerHTML += "<tr><td width=300><label>Gambar "+(countImg)+"</label></td><td>"+
            "<input type=file name='images[]' class='bginput'></td>"+
            "<td><label>Nama "+(countImg++)+"</label></td><td><input type=text name='nama[]' size='30'/></td></tr>"+
            "<tr><td colspan=2 height=\"5px\"></td></tr>";
        document.getElementById('uploadTable').style.fontSize="0.8em";
    }
}

function uploadGambar(idShow){

    if(countImg == 0){
        if(getInternetExplorerVersion() == 8.0 || getInternetExplorerVersion() == 7.0){
            countImg = 3;
            addImageInput('uploadTable');
        }else{
            countImg = 1;
            addImageInput('uploadTable');
            addImageInput('uploadTable');
            addImageInput('uploadTable');
        }
    }

    document.getElementById(idShow).style.display = "block";
}
