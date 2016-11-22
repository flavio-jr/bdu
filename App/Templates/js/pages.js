var box = document.querySelectorAll(".pag-base");
var pages = document.querySelectorAll(".pag-base a");
var control = 1;
while(control<=10) {
  if(pages[control-1].textContent=='{{pg'+control+'}}') {
    box[control-1].style.display = 'none';
  }
  control++;
}
