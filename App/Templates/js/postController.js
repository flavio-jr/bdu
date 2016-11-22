var content = document.querySelectorAll(".prev");
var posts = document.querySelectorAll(".prev h2 a");
var i = 1;
while(i<=5) {
  console.log(posts[i-1].textContent);
  if(posts[i-1].textContent=='null') {
    content[i-1].style.display = 'none';
  }
  i++;
}
