let options = { weekday: 'long', year: 'numeric', month: 'numeric', day: 'numeric' }
let today  = new Date()

var url_string = window.location.href
var url = new URL(url_string)
var KN = url.searchParams.get("KN") == null ? "" : url.searchParams.get("KN")
var PN = url.searchParams.get("PN") == null  ? "" : url.searchParams.get("PN")

var dict = {"Nico": "richard@randmuzik.de"};  
var bearbeiter = "Nico"; // über DB-Abfrage laden



function collapse_table(){
    document.querySelectorAll('.collapsible_button').forEach(button => {

      button.classList.toggle('collapsible_button--active');
    })

}


function openNav() {
    document.getElementById("sidebar_left").style.width = "250px";
  }
  
  function closeNav() {
    document.getElementById("sidebar_left").style.width = "0";
  }

  function open_sidebar_right(){
    
    document.querySelectorAll('.sidebar_right_button').forEach(button => {
      button.classList.toggle('sidebar_right_button--active');
    })
    document.getElementById("sidebar_right").style.width = "34%";

}


function close_sidebar_right(){
    
  document.querySelectorAll('.sidebar_right_button').forEach(button => {
    button.classList.toggle('sidebar_right_button--active');
  })
  document.getElementById("sidebar_right").style.width = "0px";

}


function open_rekla_nav(){

  closeNav();
  close_sidebar_right();

  document.getElementsByClassName("rekla_popup")[0].style.display = "flex";

}

function open_rekla_bestellen(){
  
  document.getElementsByClassName("rekla_content_outer")[0].style.display = "none";
  document.getElementsByClassName("rekla_bestellen")[0].style.display = "grid";

}


function closeRekla(){
  document.getElementsByClassName("rekla_popup")[0].style.display = "none";

}


function back_to_rekla_nav(){
  document.getElementsByClassName("rekla_bestellen")[0].style.display = "none";
  document.getElementsByClassName("rekla_content_outer")[0].style.display = "flex";
}


function writeMail(){
  
  window.location.href = `mailto:${dict[bearbeiter]}?subject=${PN} - ${KN}&body=Hallo ${bearbeiter},%0d%0a%0d%0a`;

}



