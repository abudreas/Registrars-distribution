var pshift = document.getElementById("currentShift");
var state = document.getElementById("resid");
const form = document.getElementsByTagName("form")[0];
var prev = [];
//testa

//
notavailhops = notavailhops.concat(availhops);
prev.push(document.getElementById("firstShift"));
prev.push(document.getElementById("secondShift"));
prev.push(document.getElementById("thirdShift"));
prev.push(document.getElementById("forthShift"));
prev.push(document.getElementById("fifthShift"));
prev.push(document.getElementById("sixShift"));
prev.push(document.getElementById("seventhtShift"));
//
let f1 = document.getElementById("firstApplication");
let f2 = document.getElementById("seconApplication");
let f3 = document.getElementById("thirdApplication");
//show popup
if(isfound){
document.getElementById('popupform').style.display= "block";
form.style.display= "none";
}
///
pshift.selectedIndex = prevshift;
filit();
filapp();
fillstate();
fillcity()
addHos();
pshift.addEventListener("change", addHos);
state.addEventListener("change", fillcity);
function addHos() {
  let x = 0;
  let y = pshift.selectedIndex;

  for (;;) {
    if (x < y) {
      prev[x].disabled = false;
    } else if (x >= y) {
      prev[x].disabled = true;
      prev[x].selectedIndex = 0;
    }
    x++;
    if (x >= 7) break;
  }
}
function filhosp(filselect, hosp, selindex) {
  let x = 0;
  let option = document.createElement("option");
  option.text = "--الرجاء إختيار مستشفى--";
  option.value = "";
  filselect.add(option);
  for (const element of hosp) {
    filselect.add(CreateOpt(element));
  }
  for (const arr of hosp) {
    if (arr.includes(selindex)) {
      filselect.selectedIndex = x + 1;
      break;
    }
    x++;
  }
}
function filit() {
  let x = 0;
  for (;;) {
    filhosp(prev[x], notavailhops, myregprev[x]);
    x++;
    if (x >= prev.length) break;
  }
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
//check the name input
const nameInput = document.getElementById("name");

nameInput.addEventListener("input", () => {
  nameInput.setCustomValidity("");
  nameInput.checkValidity();
});
nameInput.addEventListener("focusout", () => {
  nameInput.setCustomValidity("");
  nameInput.value = nameInput.value.trim();
  nameInput.checkValidity();
});

nameInput.addEventListener("invalid", () => {
  if (nameInput.value === "") {
    nameInput.setCustomValidity("الرجاء إدخال الإسم!");
  } else {
    nameInput.setCustomValidity("الإسم باللغة العربية ,من غير تشكيل أو أرقام");
  }
});
//check phone input
const telInput = document.getElementById("tele");

telInput.addEventListener("input", () => {
  telInput.setCustomValidity("");
  telInput.checkValidity();
});

telInput.addEventListener("invalid", () => {
  if (telInput.value === "") {
    telInput.setCustomValidity("الرجاء إدخال الرقم!");
  } else {
    telInput.setCustomValidity("الرقم غير صحيح");
  }
});
function filapp() {
  filhosp(f1, availhops, myregapp[0]);
  filhosp(f2, availhops, myregapp[1]);
  filhosp(f3, availhops, myregapp[2]);
}
//check applications
form.addEventListener("submit", function (event) {
  err = document.getElementById("err");
  err.hidden = true;
  if (
    f1.selectedIndex === f2.selectedIndex ||
    f1.selectedIndex === f3.selectedIndex ||
    f3.selectedIndex === f2.selectedIndex
  ) {
    err.hidden = false;
    f1.focus;
    alert("من فضلك ادخل رغبات مختلفة");
    event.preventDefault();
  }
});
function fillstate() {
  let option = CreateOpt("--إختر ولاية--");
  let x = 0;
  option.value = "";
  //other.value = states[0].value;

  state.add(option);
  for (const element of statsarry) {
    state.add(CreateOpt(element[0]));
  }
  for (const arr of statsarry) {
    if (arr.includes(prevstate[1])) {
      state.selectedIndex = x + 1;
      break;
    }
    x++;
  }
}

function fillcity() {
  var city = document.getElementById("city");
  var citylable = document.getElementById("citylable");
  city.disabled = true;
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

    if (statsarry[xam].length > 1) {
      let option = CreateOpt("--إختر مدينة--");
      option.value = "";
      city.add(option);

      for (const element of statsarry[xam]) {
        city.add(CreateOpt(element));
      }
      city.remove(1);
      option = CreateOpt("أخرى");
      option.value = state.selectedOptions[0];
      city.add(option);
      city.selectedIndex = statsarry[xam].indexOf(prevstate[0]);
      if (city.selectedIndex < 0) city.selectedIndex = 0;
    }
    city.disabled = false;
    city.hidden = false;
    citylable.hidden = false;
  }
}
function closeit(){
  document.getElementById('popupform').style.display= "none";
  form.style.display= "block";
}
