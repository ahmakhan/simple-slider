/*
* Custom Script for Simple Slider
* Author: Mohammad khan
*/

jQuery(document).ready(function() {

  var slideIndex = 0;
  var slides = jQuery('.simple-slides li');
  var indices = jQuery('.slider-index-holder li');
  var totalSlides = slides.length;
  var autoSlide = 0;

  function cycleSlides() {
    slides.hide();
    slides.removeClass('current-slide').eq(slideIndex).addClass('current-slide').fadeIn('slow');
    indices.removeClass('current-index').eq(slideIndex).addClass('current-index');
  }

  function startSlide() {
    autoSlide = setInterval(function() {
      slideIndex += 1;
      if (slideIndex > totalSlides - 1) { slideIndex = 0; }
      cycleSlides();
    }, 5000);
  }

  indices.on('click', function() {
    slideIndex = jQuery(this).data('index')-1;
    clearInterval(autoSlide);
    cycleSlides();
    startSlide();
  });

  startSlide();

});
