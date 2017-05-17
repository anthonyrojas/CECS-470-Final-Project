window.onload = function(){
	var slideshow=document.getElementsByClassName("slideshow-container");
	var slideIndex = 1;
	showSlides(slideIndex);
	document.getElementById('left').onclick =  function(){
		console.log("left");
		plusSlides(-1);
	}
	document.getElementById('right').onclick =  function(){
		plusSlides(+1);
	}
	function plusSlides(n) {
		showSlides(slideIndex += n);
	}
	function currentSlide(n) {
		showSlides(slideIndex = n);
	}
	function showSlides(n) {
		var i;
		var slides = document.getElementsByClassName("slides");
		if (n > slides.length) {
			slideIndex = 1
		} 
		if (n < 1) {
			slideIndex = slides.length
		}
		for (i = 0; i < slides.length; i++) {
			slides[i].style.display = "none"; 
		}
		slides[slideIndex-1].style.display = "block"; 
	}	
}