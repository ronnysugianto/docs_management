/*function untuk mengembalikan list berupa string dengan delimiter ',' value yang sesuai dengan checked (true/false) dari suatu list checkboxes
 */
function getSelectedCheckboxes(optionName, checked){
    var selectedText = '';
    var arryCheck = document.getElementsByName(optionName);
    if(arryCheck === null || arryCheck === undefined){
        return false;
    }

    var checkCounter = 0;
    for(var i=0;i<arryCheck.length;i++){
        if(arryCheck[i].checked === checked) {
            if(checkCounter > 0) selectedText += ',';

            selectedText += arryCheck[i].value;
            checkCounter++;
        }
    }
    return selectedText;
}


/*function untuk mengembalikan hasil radiobutton/checkbox.. min harus dipilih satu/lebih
 optionName = nama checkBox/Radiobutton
 type : return boolean
 */
function isOneSelected(optionName,minSelect){
    var minSelected;
    var isValid = false;
    var counter  = 0;

    //var arryCheck = document.forms[formName].elements[optionName];
    var arryCheck = document.getElementsByName(optionName);

    if(arryCheck == null || arryCheck == undefined){
        return false;
    }
    if(minSelect < 1){ minSelected = 1;}
    else {minSelected = minSelect; }

    for(var i=0;i<arryCheck.length;i++){
        if(arryCheck[i].checked) { counter++; }
        if(counter >= minSelected){
            isValid = true;
            break;
        }
    }

    return isValid;
}
/*function untuk menuliskan error yang muncul
 nameId = idDari tag error HTML						isItalic = style italic
 errorText = pesan error yang ingin disampaikan		textColor = error text color
 type = void
 */
function showError(nameId,errorText){
    document.getElementById(nameId).innerHTML = ""+errorText;
}
/*function untuk memeriksa apakah input value sudah ada atau tidak
 check = value yg diinput
 arry = array berisi data yang sudah ada
 type = type yang valid untuk dicheck (ex: 'string' ==> arry value & check hrslah string,'number' ==> arry value & check hrslah number
 */
function isExist(check,arry){
    var isExist = false;
    for(var i=0;i<arry.length;i++){
        if((typeof check) == (typeof arry[i])){
            if(check.toLowerCase() == arry[i].toLowerCase() || check == ''){
                isExist = true;
                break;
            }
        }else{
            alert('Can not check, because not the same type');
            break;
        }
    }
    return isExist;
}
/*function untuk mencheck format dari email
 */
function checkEmail(value){
    var regEmail=/^[\w\.-_\+]+@[\w-]+(\.\w{1,3}\D)+$/;
    if(!regEmail.test(value)){
        return false;
    }
    return true;
}
/*function untuk memeriksa inputan tidak boleh ada whitespace,new line, tabs
 return boolean --> false jika value terdapat whitespace,new line, tabs
 */
function checkWhitespace(value){
    var regex = /^[\S]*$/;
    return regex.test(value);
}
/*function untuk memeriksa inputan apakah blank, null, hanya whitespace
 return boolean --> false jika value kosong/terdiri dari whitespaces saja/ada whitespace didepan value
 */
function isFilled(value){
    var reg = /^[\S]/;
    return reg.test(value);
}
//function untuk membandingkan apakah date1 > date2
function IsDateGreater(Date1, Date2)
{
    var DaysDiff;

    DaysDiff = Math.floor((Date1.getTime() - Date2.getTime())/(1000*60*60*24));
    if(DaysDiff > 0)
        return true;
    else
        return false;
}
//function untuk membandingkan apakah date1 < date2
function IsDateLess(Date1, Date2)
{
    var DaysDiff;

    DaysDiff = Math.floor((Date1.getTime() - Date2.getTime())/(1000*60*60*24));

    if(Date1 <= Date2)
        return true;
    else
        return false;
}
//function untuk membandingkan apakah date1 == date2
function IsDateEqual(Date1, Date2)
{
    var DaysDiff;

    DaysDiff = Math.floor((Date1.getTime() - Date2.getTime())/(1000*60*60*24));
    if(DaysDiff == 0)
        return true;
    else
        return false;
}
//function untuk membuat request javascript
function createRequest(requesting) {
    try {
        requesting = new XMLHttpRequest();
    } catch (tryMS) {
        try {
            requesting = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (otherMS) {
            try {
                requesting = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (failed) {
                requesting = null;
            }
        }
    }
    return requesting;
}
//function untuk menyusun url dari form dengan parameter nama dari input type text
function getFormValues(fobj){
    var str = "";
    var arry = new Array();
    var key;
    var value;
    for(var i = 0;i < fobj.elements.length;i++){
        key = value = '';
//       fobj.elements[i].type; >>> to get value type (text,select-one,checkbox,radio)
        if(fobj.elements[i].type == 'checkbox' || fobj.elements[i].type == 'radio' || fobj.elements[i].type == 'select-one' || fobj.elements[i].type == 'text' || fobj.elements[i].type == 'password' || fobj.elements[i].type == 'hidden' || fobj.elements[i].type == 'file'){

            if(fobj.elements[i].type == 'checkbox' || fobj.elements[i].type == 'radio'){
                if(fobj.elements[i].checked){
                    value = escape(fobj.elements[i].value);
                    key = fobj.elements[i].name;
                }
            }else{
                value = escape(fobj.elements[i].value);
                key = fobj.elements[i].name;
            }
        }

        if(key != '' && value != ''){
            if(!arry.hasOwnProperty(key)) arry[key] = escape(value);
            else arry[key] += ','+escape(value);
        }
    }

    //construct parameter url
    for (var key in arry) {
        if (key === 'length' || !arry.hasOwnProperty(key)) continue;
        str += key+'='+arry[key]+'&';
    }

    return str;
}

//function untuk delay pada javascript
function pausecomp(millis)
{
    var date = new Date();
    var curDate = null;

    do { curDate = new Date(); }
    while(curDate-date < millis);
}
// Returns the version of Windows Internet Explorer or a -1
// (indicating the use of another browser).
function getInternetExplorerVersion(){
    var rv = -1; // Return value assumes failure.
    if (navigator.appName == 'Microsoft Internet Explorer')
    {
        var ua = navigator.userAgent;
        var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
            rv = parseFloat( RegExp.$1 );
    }
    return rv;
}
/*function untuk trim dari value awal dan akhir*/
function trim(str, chars) {
    return ltrim(rtrim(str, chars), chars);
}
/*function untuk trim dari value awal saja*/
function ltrim(str, chars) {
    chars = chars || "\\s";
    return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
/*function untuk trim dari value akhir saja*/
function rtrim(str, chars) {
    chars = chars || "\\s";
    return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}
/*function untuk melakukan fungsi trim pada suatu field sekaligus merubah value dari field tersebut*/
function trimAndReplace(idName,trimChar){
    document.getElementById(idName).value = trim(document.getElementById(idName).value,trimChar);
    return document.getElementById(idName).value;
}

/*function untuk mengganti item selected in combobox*/
function setSelectedComboBoxItemByValue(idSelect,valSelect){

    for(i=0;i<document.getElementById(idSelect).length;i++){
        if(document.getElementById(idSelect).options[i].value == valSelect){
            document.getElementById(idSelect).selectedIndex=i;
            break;
        }
    }
}

/*function untuk mengambil label/value dari combobox*/
function getSelectedComboBox(idSelect,type){
    var selectIndex = document.getElementById(idSelect).selectedIndex;
    var value = '';

    if(type === 'label') value = document.getElementById(idSelect).options[selectIndex].text;
    if(type === 'value') value = document.getElementById(idSelect).value;

    return value;
}

/*function untuk mencheck checkboxes*/
function setCheckedCheckboxes(fields,checked){
//    for(var i=0;i<checked.length;i++){
//        alert(checked[i]);
//    }
    for(var i=0;i<fields.length;i++){
        fields[i].checked = false;
        if((checked.indexOf(fields[i].value)) > -1){ fields[i].checked = true; }
    }
}

/*function untuk mencheck/uncheck all checkboxes*/
function checkAllCheckboxes(name,ischecked){
    var fields = document.getElementsByName(name);
    for(var i=0;i<fields.length;i++){
        fields[i].checked = ischecked;
    }
}


