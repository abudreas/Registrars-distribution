/** result is an array defined in the HTML template */
var hosarray = result[0];
var remainarray = result[1];
var hos = document.getElementById("hos");
var hoscontain = document.getElementById("hoscontain");
var remainBox = document.getElementById("remBox");
/*var ph = document.getElementById("ph"); // this one was for some animation effects , but i droped the idea*/
var regbutton = [];
var regbuttonProtoType = document.createElement("div");
regbuttonProtoType.className = "dragon";
regbuttonProtoType.id = "reg";
var msgbox = document.getElementById("msgbox");
var hosptitals = [];
regbuttonProtoType.draggable = true;
var dragged;
initHospitals();
initRemains();
checkAll();
document.addEventListener("drop", droped);
function droped(event) {
  event.preventDefault();

  if (event.target.className == "drop" || event.target.className == "remains") {
    event.target.style.background = "";
    dropingAction(dragged, event.target);
  } else if (
    (event.target.classList.contains("dragon") ||
      event.target.id == "hosname") &&
    event.target != dragged
  ) {
    event.target.style.background = "";
    dropingAction(dragged, event.target.parentNode);
  } else if (event.target.className == "regname") {
    event.target.style.background = "";
    let parent = event.target.parentNode;
    dropingAction(dragged, parent.parentNode);
  }
}
document.addEventListener(
  "dragstart",
  function (event) {
    if (event.target.id == "reg") {
      dragged = event.target;

      event.target.style.opacity = 0.5;
    } else {
      dragged = undefined;
    }
  },
  false
);
document.addEventListener(
  "dragover",
  function (event) {
    event.preventDefault();
  },
  false
);
document.addEventListener(
  "dragend",
  function (event) {
    event.target.style.opacity = "";

    /* window.setTimeout(function(){ph.classList.toggle("expand");},20); // animation stuff *AS*/
  },
  false
);
document.addEventListener("mousedown", function (event) {
  if (event.target.id == "reg") {
    fillinfo(event.target);
  } else if (event.target.parentNode.id == "reg") {
    fillinfo(event.target.parentNode);
  }
});
document.getElementById("publish").addEventListener("submit", function (event) {
  if (
    remainBox.childElementCount > 0 &&
    !confirm("يوجد نواب لم يتم توزيعهم,نشر على أي حال؟")
  ) {
    event.preventDefault();
  } else {
    saveit(true);
  }
});
function initHospitals() {
  let i = 0;
  for (const item of hosarray) {
    hosptitals.push(hos.cloneNode(true));
    hosptitals[i].firstElementChild.innerText = item["name"];

    hosptitals[i]["info"] = item;
    hosptitals[i]["warning"] = [];
    hoscontain.appendChild(hosptitals[i]);
    // hosptitals.push(hos.cloneNode(true));

    for (const reg of item["registrar"]) {
      regbutton.push(regbuttonProtoType.cloneNode(true));
      let x = regbutton.length - 1;
      regbutton[x].innerHTML = "<p class='regname'>" + reg["name"] + "</p>";
      regbutton[x]["warning"] = [];
      regbutton[x]["danger"] = [];
      regbutton[x]["info"] = reg;

      regbutton[x].classList.add("shift" + reg.shift);

      hosptitals[i].appendChild(regbutton[x]);
      x++;
    }
    hosptitals[i].querySelector("small").textContent =
      hosptitals[i].childElementCount - 2;
    i++;
  }
  hoscontain.removeChild(hoscontain.firstElementChild);
}
function initRemains() {
  for (const reg of remainarray) {
    regbutton.push(regbuttonProtoType.cloneNode(true));
    let x = regbutton.length - 1;
    regbutton[x].innerHTML = "<p class='regname'>" + reg["name"] + "</p>";
    regbutton[x]["warning"] = [];
    regbutton[x]["danger"] = [];
    regbutton[x]["info"] = reg;

    regbutton[x].classList.add("shift" + reg.shift);

    remainBox.appendChild(regbutton[x]);
    x++;
  }
}
function fillinfo(regbtn) {
  let registrar = regbtn.info;
  document.querySelector(".info>h1").textContent = registrar["name"];
  let li = document.querySelectorAll(".info li");
  li.forEach((element) => {
    element.textContent = "";
  });
  li[0].textContent = "الشفت الحالي   " + registrar["shift"];
  li[1].textContent = "السكن   " + registrar["verbosresid"];
  let x = 3;
  for (const shift of registrar.prev) {
    li[x].textContent = shift.name;
    x++;
  }

  li[10].textContent = "الرغبة الأولى:  " + registrar.apps[0].name;
  li[11].textContent = "الرغبة الثانية:  " + registrar.apps[1].name;
  li[12].textContent = "الرغبة الثالثة:  " + registrar.apps[2].name;
  x = 13;
  for (const msg of regbtn.danger) {
    li[x].textContent = msg;
    x++;
  }
  for (const msg2 of regbtn.warning) {
    li[x].textContent = msg2;
    x++;
  }
}
function checkregistrar(registrarbtn, hospitalcon) {
  if (hospitalcon.id != "hos") return;
  let registrar = registrarbtn.info;
  let hospital = hospitalcon.info;
  let checkpbyn = checkPrevByName(registrar, hospital);

  registrarbtn.classList.remove("danger");
  registrarbtn.classList.remove("warning");
  registrarbtn.danger = [];
  registrarbtn.warning = [];

  if (
    hospital.tier == 4 &&
    !checkApp(registrar, hospital) &&
    registrar.state != hospital.state
  ) {
    registrarbtn.danger.push(
      registrar.name +
        " لم يقدم ل " +
        hospital.name +
        " ولا يسكن في نفس الولاية "
    );
    registrarbtn.classList.add("danger");
  } else if (
    (hospital.tier == 3 || hospital.tier == 1) &&
    checkpbyn > 0 &&
    registrar.distro.id != hospital.id
  ) {
    registrarbtn.warning.push(
      "لقد عمل " + registrar.name + " بهذا المستشفى سابقا"
    );
    registrarbtn.classList.add("warning");
  }
  if (
    hospital.tier != 1 &&
    registrar.shift > 5 &&
    !checkPrevByTier(registrar, 1).length
  ) {
    registrarbtn.warning.push(
      registrar.name + " سينير و لم يعمل بمستشفى من الطبقة الأولى"
    );
    registrarbtn.classList.add("warning");
  }
  if (checkpbyn > 3) {
    registrarbtn.warning.push(
      "لقد عمل " + registrar.name + " ب" + hospital.name + " أكثر من أربع شفتات"
    );
    registrarbtn.classList.add("warning");
  }
}
function checkPrevByName(registrar, hospital) {
  let x = 0;
  for (const hos of registrar.prev) {
    if (hos.name == hospital.name) x++;
  }
  return x;
}
function checkPrevByTier(registrar, tier) {
  let x = [];
  for (const hos of registrar.prev) {
    if (hos.tier == tier) {
      if (!x.includes(hos.name)) x.push(hos.name);
    }
  }
  return x;
}
function checkApp(registrar, hospital) {
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
  /**
   * I don't why i did it as async func
   * but here it's :
   */
  let x = 1;
  let allmsg = new Promise(function (resolve, reject) {
    let msg = "";

    for (const reg of regbutton) {
      for (const danger of reg.danger) {
        msg += "<strong>" + x + ") " + danger + "</strong>" + "<br><br>";
        x++;
      }
      for (const warn of reg.warning) {
        msg +=
          x + ") " + "<span class='warning'>" + warn + "</span>" + "<br><br>";

        x++;
      }
    }
    for (const hos of hosptitals) {
      for (const warn of hos.warning) {
        msg += x + ") " + warn + "<br><br>";
        x++;
      }
    }

    resolve(msg);
  });
  document.querySelector("#messagesTitle").textContent = "ملاحظات (" + x + ")";
  msgbox.innerHTML = await allmsg;
  return x;
}
function dropingAction(btn, container) {
  let old = btn.parentNode;
  //btn.after(ph) //*AS;
  old.removeChild(dragged);
  if (container.id == "remBox") {
    container.prepend(dragged);
  } else {
    container.appendChild(dragged);
  }

  /*ph.classList.toggle("expand",true);//*AS*/
  updateHospital(container);
  updateHospital(old);

  checkregistrar(dragged, container);

  checkHospital();
  updateMsgBox();
  fillinfo(btn);
}
function updateHospital(hoscontainer) {
  if (hoscontainer.id == "hos") {
    hoscontainer.querySelector("small").textContent =
      hoscontainer.childElementCount - 2;
  }
}
function checkHospital() {
  let x = 0;
  for (const hoscontainer of hosptitals) {
    x = hoscontainer.childElementCount - 2;
    hoscontainer.warning = [];
    hoscontainer.classList.remove("warning");
    if (x > hoscontainer.info.capacity) {
      hoscontainer.warning.push(
        "لقد تم تخطي السعة الإستيعابية " +
          hoscontainer.info.capacity +
          " لمستشفى " +
          hoscontainer.info.name
      );
      hoscontainer.classList.add("warning");
    } else if (x == 0) {
      hoscontainer.warning.push(
        "لا يوجد نائب موزع لمستشفى " + hoscontainer.info.name
      );
    }
  }
  x = remainBox.childElementCount;
  document.querySelector("#remcnt").textContent = x;
}
function saveit(hidden = false) {
  let xml = new XMLHttpRequest();
  document.getElementById("saveitbtn").disabled = true;
  let result = [];
  result[0] = [];
  result[1] = [];
  for (const hos of hosptitals) {
    hos.info.registrar = [];
    if (!hos.childElementCount - 2) {
      for (const reg of hos.children) {
        if (reg.id == "reg") {
          hos.info.registrar.push(reg.info);
        } else {
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
  xml.open("POST", window.location.pathname, !hidden);
  xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  if (!hidden) {
    xml.onreadystatechange = function () {
      if (xml.readyState === XMLHttpRequest.DONE) {
        var status = xml.status;
        document.getElementById("saveitbtn").disabled = false;

        if (status === 0 || (status >= 200 && status < 400)) {
          alert("تم الحفظ");
        } else {
          alert("حدث خطأ");
        }
      }
    };
  }
  xml.send("result=" + JSON.stringify(result));
}
function checkAll() {
  for (const reg of regbutton) {
    if (reg.parentNode.id == "hos") checkregistrar(reg, reg.parentNode);
  }
  checkHospital();
  updateMsgBox();
}
