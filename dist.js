var hosarray = result[0];
var remainarray = result[1];
var hos = document.getElementById("hos");
var hoscontain = document.getElementById("hoscontain");
var remainBox = document.getElementById("remBox");
/*var ph = document.getElementById("ph");*/
var regbutton = [];
var regbuttonProtoType = document.createElement("div");
regbuttonProtoType.className = "dragon";
regbuttonProtoType.id="reg";
var msgbox = document.getElementById("msgbox");
var hosptitals =[];
regbuttonProtoType.draggable = true;
var dragged;
initHospitals();
initRemains();
checkAll();
document.addEventListener("drop", droped);
function droped(event) {
  // prevent default action (open as link for some elements)
  event.preventDefault();
  // move dragged elem to the selected drop target
  if (event.target.className == "drop") {
    event.target.style.background = "";
    dropingAction(dragged,event.target);
  
    
  }else if((event.target.classList.contains('dragon')||event.target.id=="hosname") && event.target!=dragged){
    event.target.style.background = "";
    dropingAction(dragged,event.target.parentNode);
  
    
  }else if(event.target.className=="regname"){
    event.target.style.background = "";
    let parent = event.target.parentNode;
    dropingAction(dragged,parent.parentNode);
  }
}
document.addEventListener("dragstart", function(event) {
  // store a ref. on the dragged elem
  if (event.target.id=='reg'){
  dragged = event.target;
  // make it half transparent
  event.target.style.opacity = .5;
  }else{
    dragged=undefined;
  }
}, false)
document.addEventListener("dragover", function(event) {
  // prevent default to allow drop
  event.preventDefault();
}, false);
document.addEventListener("dragend", function(event) {
  // reset the transparency
  event.target.style.opacity = "";
  //ph.classList.toggle("collapse",true);

 /* window.setTimeout(function(){ph.classList.toggle("expand");},20); */ 
}, false);
document.addEventListener('mousedown',function(event){
if(event.target.id =='reg'){
  fillinfo(event.target);
}else if(event.target.parentNode.id =='reg'){
  fillinfo(event.target.parentNode);
}
});
document.getElementById("publish").addEventListener("submit",function () {  
  saveit();

});
function initHospitals(){

let i = 0;
for (const item of hosarray) {
  hosptitals.push(hos.cloneNode(true));
  hosptitals[i].firstElementChild.innerText=item['name'];
  
  hosptitals[i]['info']=item;
  hosptitals[i]['warning']=[];
  hoscontain.appendChild(hosptitals[i]);
 // hosptitals.push(hos.cloneNode(true));
  
  for (const reg of item['registrar']) {
    regbutton.push(regbuttonProtoType.cloneNode(true));
    let x = regbutton.length-1;
    regbutton[x].innerHTML="<p class='regname'>"+reg['name']+"</p>";
    regbutton[x]['warning'] = [];
    regbutton[x]['danger'] =[];
    regbutton[x]['info']=reg;
   
        regbutton[x].classList.add('shift'+reg.shift);
        
    hosptitals[i].appendChild(regbutton[x]);
    x++;
  }
  hosptitals[i].querySelector('small').textContent = hosptitals[i].childElementCount-2;
  i++;
}
hoscontain.removeChild(hoscontain.firstElementChild);
}
function initRemains(){
  for (const reg of remainarray) {
    regbutton.push(regbuttonProtoType.cloneNode(true));
    let x = regbutton.length-1;
    regbutton[x].innerHTML="<p class='regname'>"+reg['name']+"</p>";
    regbutton[x]['warning'] = [];
    regbutton[x]['danger'] =[];
    regbutton[x]['info']=reg;
   
        regbutton[x].classList.add('shift'+reg.shift);
        
    remainBox.appendChild(regbutton[x]);
    x++;
    
  }
}
function fillinfo(regbtn){
  let registrar = regbtn.info;
  document.querySelector('.info>h1').textContent = registrar['name'];
  let li = document.querySelectorAll('.info li');
  li.forEach(element=> {
    element.textContent ="";
  });
  li[0].textContent = "الشفت الحالي   "+registrar['shift'];
  li[1].textContent = "السكن   "+registrar['verbosresid'];
  let x =3;
  for (const shift of registrar.prev) {
    li[x].textContent=shift.name;
    x++;
  }
 
    li[10].textContent='الرغبة الأولى:  '+registrar.apps[0].name;
    li[11].textContent='الرغبة الثانية:  '+registrar.apps[1].name;
    li[12].textContent='الرغبة الثالثة:  '+registrar.apps[2].name;
    x= 13;
    for (const msg of regbtn.danger) {
      li[x].textContent=msg;
      x++;
    }
    for (const msg2 of regbtn.warning) {
      li[x].textContent=msg2;
      x++;
    }
    

}
 function checkregistrar(registrarbtn,hospitalcon){
   let registrar = registrarbtn.info;
   let hospital =hospitalcon.info;
   registrarbtn.classList.remove("danger");
   registrarbtn.classList.remove("warning");
   registrarbtn.danger=[];
   registrarbtn.warning=[];
  if (hospital.tier == 4 && !(checkApp(registrar,hospital)) && registrar.state != hospital.state){
    registrarbtn.danger.push(registrar.name+" لم يقدم ل "+hospital.name+" ولا يسكن في نفس الولاية ");
    registrarbtn.classList.add("danger");
  }
  if ((hospital.tier==3 || hospital.tier==1) && checkPrevByName(registrar,hospital) > 0 ){
    registrarbtn.warning.push("لقد عمل "+registrar.name+" بهذا المستشفى سابقا");
    registrarbtn.classList.add("warning");
  }
 }
 function checkPrevByName(registrar,hospital){
   let x = 0;
   for (const hos of registrar.prev) {
     if (hos.name == hospital.name) x++;
   }
   return x;
 }
 function checkPrevByTier(registrar,hospital){
   let x =[];
   for (const hos of registrar.prev) {
     if (hos.tier==hospital.tier){
      if (!x.includes(hos.name)) x.push(hos.name);
     }
   }
   return x;
 }
 function checkApp(registrar,hospital){
  let x = 0;
  for (const hos of registrar.apps) {
    if (hos.name == hospital.name) x++;
  }
  return x;
}
 /*
 function updateMsgBox(){
   let msg ="";
   for (const reg of regbutton) {
     if (reg.warning) msg += reg.warning +"<br>";
     if (reg.danger) msg+= reg.danger+"<br>";
   }
   msgbox.innerHTML = msg;
 }*/
 async function updateMsgBox() {
  let x =1;
   let allmsg = new Promise(function (resolve, reject) {
     let msg = "";
     
     for (const reg of regbutton) {
       for (const danger of reg.danger) {
         msg +="<strong>"+ x+") "+danger +"</strong>"+ "<br><br>";
         x++;
       }
       for (const warn of reg.warning) {
         msg += x+") "+ warn + "<br><br>";
         x++;
       }
     }
     for (const hos of hosptitals) {
       for (const warn of hos.warning) {
        msg += x+") "+ warn + "<br><br>";
        x++;
       }
     }
     
     resolve(msg);
   });
   msgbox.parentNode.querySelector("h2").textContent="ملاحظات ("+x+")";
   msgbox.innerHTML = await allmsg;
   return x;
 }
 function dropingAction(btn,container){
   let old = btn.parentNode;
  //btn.after(ph);
  old.removeChild( dragged );
  container.appendChild( dragged );
  checkregistrar(dragged,container);
  
  /*ph.classList.toggle("expand",true);*/
  updateHospital(container);
  updateHospital(old);
  checkHospital(container);
  updateMsgBox();
 }
 function updateHospital(hoscontainer){
  hoscontainer.querySelector('small').textContent = hoscontainer.childElementCount-2;
 }
 function checkHospital(){
   let x = 0;
   for (const hoscontainer of hosptitals) {
     
   
   x = hoscontainer.childElementCount-2;
  hoscontainer.warning=[];
  if (x>hoscontainer.info.capacity){
    hoscontainer.warning.push("لقد تم تخطي السعة الإستيعابية "+hoscontainer.info.capacity+" لمستشفى "
    + hoscontainer.info.name);

  }else if(x==0){
    hoscontainer.warning.push("لا يوجد رجسترار موزع لمستشفى "+hoscontainer.info.name)
  }
 }}
 function saveit(){
   let xml = new XMLHttpRequest();
   let result = [];
   result[0] = [];
   result[1] = [];
   for (const hos of hosptitals) {
     hos.info.registrar = [];
     if (!hos.childElementCount - 2) {
       for (const reg of hos.children) {
         if (reg.id == "reg") {
           hos.info.registrar.push(reg.info);
         }else{
           continue;
         }
       }
     }
     result[0].push(hos.info);
   }
   for (const reg of remainBox.children) {
     if (reg.id == "reg") {
       result[1].push(reg.info);
     }
   }
  xml.open("POST","http://localhost/formphp2/dist.php",true);
  xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
 xml.onreadystatechange = function () {
   
    if(xml.readyState === XMLHttpRequest.DONE) {
      var status = xml.status;
      if (status === 0 || (status >= 200 && status < 400)) {
       
        alert("تم الحفظ");
      } else {
      alert("حدث خطأ");
      }
    }
  };
  xml.send("result="+JSON.stringify(result));
 }
 function checkAll(){
   for (const reg of regbutton) {
    if (reg.parentNode.id=="hos")checkregistrar(reg,reg.parentNode);
     
   }
   checkHospital();
   updateMsgBox();
 }
 

