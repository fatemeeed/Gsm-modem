const sidebar = document.querySelector('.sidebar');
const hamber = document.querySelector('.hamburger-icon');
const mainContent = document.querySelector('.main-content');
const menuToggle = document.querySelector('#menu-toggle');


// var btns = document.getElementsByClassName("sidebar-menu-link-item");

// for (var i = 0; i < btns.length; i++) {
//   btns[i].addEventListener("click", function () {
     
//     var current = document.getElementsByClassName("active");
   
//     if (current.length > 0) {
     
//       current[0].className = current[0].className.replace(" active", "");
//     }
//     this.className += " active";
//   });
// }


hamber.addEventListener('click', function () {

     sidebar.classList.toggle('active')
     mainContent.classList.toggle('active');
     menuToggle.classList.toggle('active')
})

menuToggle.addEventListener('click', function () {

     sidebar.classList.toggle('active')
     mainContent.classList.toggle('active');
     menuToggle.classList.toggle('active')
});







