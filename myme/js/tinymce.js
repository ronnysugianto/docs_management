function fillTinyText(id,text){
    if(text.length > 4000){
        alert("Number of characters EXCEEDS THE LIMIT allowed. \nPlease reduce your characters or styles... ");
        return false;
    }else{
        document.getElementById(id).value=text;
        return true;
    }
}