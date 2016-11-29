var content = document.querySelectorAll(".prev");
var posts = document.querySelectorAll(".prev-infos>a");
var tags = document.querySelectorAll(".prev-tag a");
var supertag = document.querySelectorAll(".prev-tag");
var infos = document.querySelectorAll(".subject");
var subject;
var i = 1;
var j = 1;
while(i<=5) {
  if(posts[i-1].textContent=='null') {
    content[i-1].style.display = 'none';
  }
  else {
    switch (tags[i-1].textContent) {
      case 'Análise':
        supertag[i-1].style.borderBottom = "4px solid #F44336";
        break;
      case 'Notícias':
        supertag[i-1].style.borderBottom = "4px solid #3F51B5";
        break;
      case 'Entretenimento':
        supertag[i-1].style.borderBottom = "4px solid #8BC34A" ;
        break;
      case 'Contos':
        supertag[i-1].style.borderBottom = "4px solid #795548";
        break;

      default:
      supertag[i-1].style.borderBottom = "4px solid #F44336";
      break;
    }
    j = 0;
    while(j<4) {
      subject = infos[i-1].children;
      var k = j + 1;
      if(subject[j].textContent=="{{sub"+i+k+"}}") {
        subject[j].style.display = 'none';
      }
      j++;
    }
  }
  j = 1;
  i++;
}
