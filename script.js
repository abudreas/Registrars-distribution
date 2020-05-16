var myform = document.getElementById("g");
var mycheck = document.getElementById("available");
var newhoscon = document.getElementById("newhoscontainer");
var hospitals;
var hoscount = 1;
var stateSelectArray = document.querySelectorAll("#state");
var popup = document.getElementById("popup");
var hosSelect = document.getElementById("hosSelect");
var deletTarget;

fillall();
filhosp(hosSelect,hosarray);
filltier();
myform.addEventListener("submit",function(){
let tosave = document.getElementById("tosave");
tosave.value = "OK";
});
myform.addEventListener("change",function (event) {
    if (event.target.id == "available"){
    let parent = event.target.parentElement;
    parent.classList.toggle("available");
    let x = Number(event.target.nextElementSibling.value);
    event.target.nextElementSibling.value = Number((x || 1) && !(x&&1));
    }else if (event.target.id == "state"){
        let lable= event.target.nextElementSibling;
        fillcity(lable,lable.nextElementSibling,event.target,-1);
    }
})
myform.addEventListener("click",function(event){
  if(event.target.id == "delet"){
    deletit(event.target);
  }else if (event.target.id == "deletnew"){
    let parent = event.target.parentElement;
    parent.remove();
  }
})
popup.addEventListener("submit",confirmDelet);
/*######################################*/
function addit(){

newhoscon.appendChild(hospitals.cloneNode(true));

}
function CreateOpt(t) {
    let option = document.createElement("option");
    if (Array.isArray(t)) {
      option.value = t[0];
      option.text = t[1];
    } else {
      option.text = t;
    }
    return option;
  }
function fillstate(state,previndex) {
    let option = CreateOpt("--إختر ولاية--");
    let x = 0;
    option.value = "";
    //other.value = states[0].value;
  
    state.add(option);
    for (const element of statsarry) {
      state.add(CreateOpt(element[0]));
    }
    for (const arr of statsarry) {
      if (arr[0].includes(prevstate[previndex])) {
        state.selectedIndex = x + 1;
        break;
      }
      x++;
    }
  }
  
  function fillcity(citylable,city,state,prevcityindex) {
    
   // city.disabled = true;
    city.hidden = true;
    citylable.hidden = true;
    if (state.selectedIndex > 0) {
      //clean city
      let z = city.options.length;
      for (var x = z + 1; x >= 0; x--) {
        city.remove(x);
      }
      ////
      let xam = state.selectedIndex - 1;
      let option = CreateOpt("--إختر مدينة--");
        option.value = 0;
        city.add(option);
      if (statsarry[xam].length > 1) {
        
  
        for (const element of statsarry[xam]) {
          city.add(CreateOpt(element));
        }
        city.remove(1);
        let x = statsarry[xam].length;
        for (let index = 1; index < x; index++) {
          if (statsarry[xam][index].includes(prevcity[prevcityindex])){
            city.selectedIndex = index;
          }
          
        }
        
        if (!(city.selectedIndex > 0)) city.selectedIndex = 0;
       // city.disabled = false;
        city.hidden = false;
        citylable.hidden = false;
      }
    }
  }
  function fillall() {
      let x = 0;
      for (const stateselect of stateSelectArray) {
          fillstate(stateselect,x);
          let lable= stateselect.nextElementSibling;
          fillcity(lable,lable.nextElementSibling,stateselect,x);
          x++;
      }
      hospitals = document.getElementById("newhos").cloneNode(true);
  }
  function filhosp(filselect, hosp) {
    
    let option = document.createElement("option");
    option.text = "--الرجاء إختيار مستشفى--";
    option.value = "";
    filselect.add(option);
    for (const element of hosp) {
      filselect.add(CreateOpt(element));
    }
    
  }
  function deletit(target){
    if (target.nextElementSibling.value=="0"){
    popup.style.display="block";
    deletTarget = target;
    }else{
      
      enableUnDelet(target.parentElement);
      target.classList.remove("grean");
      target.classList.add("warning");
      target.textContent="حذف";
      target.nextElementSibling.value="0";
    }
  }
 function closepopup(){
    popup.style.display="none";
    deletTarget=null;
  }
  function confirmDelet(event){
    popup.style.display="none";
    deletTarget.nextElementSibling.value = hosSelect.value;
    deletTarget.textContent="إلغاء الحذف";
    deletTarget.classList.add("grean");
    deletTarget.classList.remove("warning");
    disableDeleted(deletTarget.parentElement);
    event.preventDefault();
  }
  function disableDeleted(parent){
    parent.classList.toggle("deleted");
    for (const element of parent.children) {
      if (element.id != "delet" && element.id != "id" && element.id != "deletbox")element.disabled=true;
      
    }
  }
  function enableUnDelet(parent){
    parent.classList.toggle("deleted");
    for (const element of parent.children) {
      element.disabled=false;
      
    }
  }
function saveit(){
  let nameinputarray = document.querySelectorAll("#name");
  for (const name of nameinputarray) {
    if (name.value==""){
      name.parentElement.remove();
    }
  }
  myform.submit();
}
function filltier () { 
  let el = document.querySelectorAll("#tier");
  let x =0;
  for (const tier of prevtier) {
    el[x].selectedIndex = tier-1;
    x++;
  }
 }
