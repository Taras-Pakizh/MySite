/* global document, alert */

//Form
function ValidateLoggingForm(FormName){
    var form = document.forms[FormName];
    var username = form['username'].value;
    var password = form['password'].value;
    var result;
    
    result = CheckUsername(username);
    if(result == true) result = CheckPassword(password);
    
    if(result != true){
        alert(result);
        result = false;
    }
    
    return result;
}   
function CheckUsername(username){
    return true;
}
function CheckPassword(password){
    return true;
}

function ValidateSingUpForm(FormName){
    if(ValidateLoggingForm(FormName)){
        var password = document.forms[FormName]['password'].value;
        var repeat = document.forms[FormName]['repeat'].value;
        if(password != repeat) return false;
    }
    else return false;
    return true;
}

//Admin
function ValidateAddForm(){
    var form = document.forms['AddForm'];
    if(!form['Test1'].value) form['Test1'].value = 0;
    if(!form['Test2'].value) form['Test2'].value = 0;
    if(!form['Exam'].value) form['Exam'].value = 0;
    if(!form['Lab1'].value) form['Lab1'].value = 0;
    if(!form['Lab2'].value) form['Lab2'].value = 0;
    if(!form['Lab3'].value) form['Lab3'].value = 0;
    if(!form['Lab4'].value) form['Lab4'].value = 0;
    if(!form['Lab5'].value) form['Lab5'].value = 0;
    return true;
}
function ValidateRemoveForm(){
    
}
function ValidateModifyForm(){
    
}
function ValidateAddTable(){
    var form = document.forms['ff'];
    if(!form['TableName'].value) return false;
    return true;
}