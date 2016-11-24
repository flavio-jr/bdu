var box = document.querySelectorAll(".pag-base");
var pages = document.querySelectorAll(".pag-base a");
var control = 1;
while(control<=10) {
  if(pages[control-1].textContent=='{{pg'+control+'}}') {
    box[control-1].style.display = 'none';
  }
  else {
    if(document.URL) {
      var urlCompleta = document.URL;
      var get = urlCompleta.split("?")[1];
      var object;
      if(get) {
        object = (get.indexOf("&")==-1) ? get : get.split("&")[0];
      }
      else {
        object = "class=Home";
      }
      var pg = pages[control-1].textContent;
      var href = pages[control-1].href;
      var link = href.split("?")[1] + pg;

      pages[control-1].href = "?" + object + link;
    }
  }
  control++;
}
