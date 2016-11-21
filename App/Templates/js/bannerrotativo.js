var imgs = ["1","2","3","4","5"];
var indice = -1;
function trocaImagem(i) {
  if((i==0)||(i==1)||(i==2)||(i==3)||(i==4)) {
    indice = i;
    limpa(indice);
  }
  else {
    if(indice==imgs.length-1) {
      indice = 0;
    }
    else {
      indice++;
    }
  }
  document.getElementById("b"+imgs[indice]).style.backgroundColor = "#673AB7";
  document.getElementById(imgs[indice]).style.display = "inline-block";
  document.getElementById(imgs[indice]).style.opacity = "1";
  return setTimeout("inicio()",5000);

}
function inicio() {
  document.getElementById(imgs[indice]).style.opacity = "0.5";
  return setTimeout("meio()",50);

}
function meio(i) {
  document.getElementById(imgs[indice]).style.opacity = "0";
   return setTimeout("fim()",50);
}
function fim() {
  document.getElementById(imgs[indice]).style.display = "none";
  document.getElementById("b"+imgs[indice]).style.backgroundColor = "yellow";
  if(indice==imgs.length-1) {
    var i = 0;
    document.getElementById(imgs[i]).style.opacity = "0.5";
    document.getElementById(imgs[i]).style.display = "inline-block";
  }
  else {
    document.getElementById(imgs[indice+1]).style.opacity = "0.5";
    document.getElementById(imgs[indice+1]).style.display = "inline-block";
  }
  return setTimeout("trocaImagem()",100);
}
function bot(i) {
  var a = trocaImagem(i);
  document.getElementById("b"+imgs[i]).style.backgroundColor = "#673AB7";
  clearTimeout(a);
}
function limpa(i) {
  for(var k=0; k<imgs.length ;k++) {
    if(k!=i) {
      document.getElementById(imgs[k]).style.display = "none";
      document.getElementById("b"+imgs[k]).style.backgroundColor = "yellow";
    }
  }
}
