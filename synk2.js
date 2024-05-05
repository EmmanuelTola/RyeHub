

window.global = {}; 
window.xer = {};
window.deff = []; 
window.scripts = []; 


function simulateNetworkActivity() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "https://jsonplaceholder.typicode.com/posts/1", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
        if(window.ready == "true") {
            
        } else {
         simulateNetworkActivity();    
        }
        }
    };
    xhr.send();
}

simulateNetworkActivity(); 






// Create a Proxy for the window.xer object
let xerProxy = new Proxy(window.xer, {
set: function(target, property, value) {
console.log(`Property "${property}" of window.xer set to:`, value.slice(0, 10) + "...");
target[property] = value;
setHashx(property);
return true;
    }
});

// Replace the original window.xer object with the Proxy
window.xer = xerProxy;





let xbody; 
document.addEventListener('DOMContentLoaded', function() {

console.error = function(message, error){
    alert(error); 
};
 
});

let css = document.createElement("style"); 
css.innerText = `body { display: none; }`; 
document.head.appendChild(css); 

function copyTell(text, call) {
    console.log(text); 
  let temp = document.createElement("input");
  document.body.append(temp);
  temp.value = text;  
  temp.select();
  document.execCommand("copy");
  temp.remove();
  if(call !== undefined) {
  let newFunc = new Function(call);
  newFunc.call(this);
  }
}




function getGlobe(){
let globe = document.querySelector('global'); 
if(globe){
let string = globe.innerHTML;
let regex = /use\s+(\w+)\s+as\s+['"]([^'"]+)['"]/gi;
let match;
while ((match = regex.exec(string)) !== null) {
let key = match[1];
let val = match[2];
window.global[key] = val;
}
globe.remove(); 
}
}
getGlobe(); setInterval(getGlobe, 10);


function gloBal(func){
    let gex = /global\s(\w+)/g;
let poll;
while ((poll = gex.exec(func)) !== null) {
let glo = poll[1].trim();
let tot = "global " + glo;
let rem = new RegExp(tot, "g");
let tval = window.global[glo];
func = func.replace(rem, `"${tval}"`);
}
return func; 
}

function reTurn(func, key, val){
let rex = /return\s(.*?);/g;
let roll;
while ((roll = rex.exec(func)) !== null) {
let rlo = roll[1].trim();
let tem = `window.xer['${key}'] = ${rlo};`; 

func = func.replace(rex, tem);
}
return func; 
}

async function xPlates() {
let temp = document.querySelectorAll('sync');
let promises = []; 
let script; 
temp.forEach(function(port) {
let string = port.innerText; 
let par = port.getAttribute("parse"); 
port.remove(); 
let duty = parsePlate(string); 
if(par) {
 eval(par)
}
}); 
}

function parsePlate(strip){
let string = strip; 
script = string; 

let regex = /export\s+(\w+)\s*\((.*?)\)\s*\{([^}]*)\};*/g; 

let match;
let count = 0; 
while ((match = regex.exec(string)) !== null) {
let key = match[1].trim();
window.deff.push(key); 
let val = match[2].trim();
let func = match[3].trim();

func = gloBal(func);
func = reTurn(func, key, val); 

if(val == "") {} else {
func = func + `\nwindow.xer['${key}'] = ${val};`;

}
string = string.replace(match[0], func); 

script = string; 

count++;
}


if(script.includes("export")) {  
parsePlate(script); 
} else {
let por = document.createElement("script"); 
por.textContent = script;

document.body.appendChild(por); 
return eachHash();   
}
}






let geton = 
setInterval(function() {
let body = document.body; 
if(body) {
xPlates(); 
clearInterval(geton); 
} 
}, 10); 


function eachHash(){

let string = document.body.innerHTML; 
let keys = []; 
let regex = /\$(\w+);/g;
let rep = string.replace(regex, (match, key) => {
keys.push(key); 
return key; 
}); 
return allLoop(keys); 
}


function allLoop(key) {
for(let i = 0; i < key.length; i++){
let row = key[i]; 
let val = window.xer[row]; 
let form = window.deff; 
if(form.includes(row)) {
if(val == undefined) {
setTimeout(function() {
allLoop(key);
}, 50);
break;   
} else {
let tot = key.length; 
tot = tot - 1; 
if(i == tot) {
  document.body.style.display = 'block';   
  window.ready = "true"; 
}
} 

} else {
window.xer[row] = "";
window.deff.push(row) 
if(i == key.length - 1) {
  document.body.style.display = 'block';   
}   
} 
}
return "done"; 
}


function setHashx(el) {
if(el){
console.log(window.xer[el].slice(0, 10) + "..."); 
let string = document.body.innerHTML; 
let regex = new RegExp(`\\$${el};`, 'g');
string = string.replace(regex, (match) => {
let variableName = match.slice(1, -1);
if (window.xer.hasOwnProperty(variableName)) {
return window.xer[variableName];
  } else {
return match;
}
});
document.body.innerHTML = string; 

}
    
}
