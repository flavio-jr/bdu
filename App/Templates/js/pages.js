var box = document.querySelectorAll(".pag-base");
var pages = document.querySelectorAll(".pag-base a");
var control = 1;
console.log(pages[0].textContent);
while(control<=10) {
  if(pages[control-1].textContent=='{{'+control+'}}') {
    box[control-1].style.display = 'none';
  }
  else {
    pages[control-1].href="?class=Home&method=flip";
  }
  control++;
}
