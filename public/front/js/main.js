(function ($) {
  "use strict";
  var windowOn = $(window);
  
  
        // $('#portfolio-grid,.blog-masonry').imagesLoaded(function() {

        //     /* Filter menu */
        //     $('.mix-item-menu').on('click', 'button', function() {
        //         var filterValue = $(this).attr('data-filter');
        //         $grid.isotope({
        //             filter: filterValue
        //         });
        //     });

        //     /* filter menu active class  */
        //     $('.mix-item-menu button').on('click', function(event) {
        //         $(this).siblings('.active').removeClass('active');
        //         $(this).addClass('active');
        //         event.preventDefault();
        //     });

        //     /* Filter active */
        //     var $grid = $('#portfolio-grid').isotope({
        //         itemSelector: '.pf-item',
        //         percentPosition: true,
        //         masonry: {
        //             columnWidth: '.pf-item',
        //         }
        //     });

            
        // });

  // main slider
  $(document).ready(function () {
    var swiper = new Swiper(".sc-main-slider", {
      speed: 800,
      effect: "fade",
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      autoplay: {
        delay: 8000,
      },
    });
  });
  // Slider Two
  $(document).ready(function () {
    var swiper = new Swiper(".sc-slider-2", {
      speed: 800,
      effect: "fade",
      autoplay: {
        delay: 8000,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      loop: true,
    });
  });
  // Slider Two
  $(document).ready(function () {
    var swiper = new Swiper(".sc-slider-3", {
      speed: 800,
      effect: "fade",
      loop: true,
      autoplay: {
        delay: 8000,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
  });
  // team and project
  $(document).ready(function () {
    var swiper = new Swiper(".sc-swiper-slider", {
      slidesPerView: 3,
	  slidesPerGroup: 3, // Move 2 slides at a time
      spaceBetween: 25,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
	  pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      autoplay: {
        delay: 8000,
      },
      loop: true,
      breakpoints: {
        576: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
        640: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        },
      },
    });
  });
  // Blog Slider
  $(document).ready(function () {
    var swiper = new Swiper(".sc-blog-slider", {
      slidesPerView: 3,
      spaceBetween: 30,
      navigation: {
       // nextEl: ".swiper-button-next",
       // prevEl: ".swiper-button-prev",
      },
	  pagination: {
      el: window.innerWidth < 1024 ? ".swiper-pagination" : null, // Only show pagination on smaller screens
      clickable: true,
    },
    autoplay: window.innerWidth < 1024 ? {
      delay: 8000,
    } : false,  // Stop autoplay on desktop
    loop: true,
    grabCursor: window.innerWidth < 1024,  // Disable drag for desktop
    allowTouchMove: window.innerWidth < 1024,  // Disable drag for desktop
    breakpoints: {
        640: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
        576: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        },
      },
    });
  });
  // choose Slider
  $(document).ready(function () {
    var swiper = new Swiper('.sc-choose-slider', {
    slidesPerView: 1,  // Show one slide at a time for mobile view
    spaceBetween: 10,   // Space between slides
    loop: true,         // Enable loop
    pagination: {
      el: '.swiper-pagination',
      clickable: true
    }
  });
  });
  // Team Slider
/*  $(document).ready(function () {
    var swiper = new Swiper(".sc-team-slider-carousel", {
      slidesPerView: 3,
      spaceBetween: 30,
      autoplay: {
        delay: 8000,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      loop: true,
      breakpoints: {
        640: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        },
      },
    });
  });
*/  // brand Slider
  $(document).ready(function () {
    var swiper = new Swiper(".sc-brand-slider", {
      slidesPerView: 5,
      spaceBetween: 30,
      autoplay: {
        delay: 8000,
      },
      loop: true,
      breakpoints: {
        640: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
        576: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 3,
        },
        1024: {
          slidesPerView: 5,
        },
      },
    });
  });
  // brand Slider
  $(document).ready(function () {
    var swiper = new Swiper(".sc-tes-slider", {
      slidesPerView: 1,
      spaceBetween: 30,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      autoplay: {
        delay: 7000,
      },
      loop: true,
    });
  });

  /*-- boxfin scroll top scripts start --*/
  var boxfinScrollTop = document.querySelector(".boxfin-scroll-top");
  if (boxfinScrollTop != null) {
    var scrollProgressPatch = document.querySelector(".boxfin-scroll-top path");
    var pathLength = scrollProgressPatch.getTotalLength();
    var offset = 50;
    scrollProgressPatch.style.transition =
      scrollProgressPatch.style.WebkitTransition = "none";
    scrollProgressPatch.style.strokeDasharray = pathLength + " " + pathLength;
    scrollProgressPatch.style.strokeDashoffset = pathLength;
    scrollProgressPatch.getBoundingClientRect();
    scrollProgressPatch.style.transition =
      scrollProgressPatch.style.WebkitTransition =
        "stroke-dashoffset 10ms linear";
    window.addEventListener("scroll", function (event) {
      var scroll =
        document.body.scrollTop || document.documentElement.scrollTop;
      var height =
        document.documentElement.scrollHeight -
        document.documentElement.clientHeight;
      var progress = pathLength - (scroll * pathLength) / height;
      scrollProgressPatch.style.strokeDashoffset = progress;
      var scrollElementPos =
        document.body.scrollTop || document.documentElement.scrollTop;
      if (scrollElementPos >= offset) {
        boxfinScrollTop.classList.add("progress-done");
      } else {
        boxfinScrollTop.classList.remove("progress-done");
      }
    });
    boxfinScrollTop.addEventListener("click", function (e) {
      e.preventDefault();
      window.scroll({
        top: 0,
        left: 0,
        behavior: "smooth",
      });
    });
  }
  /*-- boxfin scroll top scripts end --*/

  // Testiminials Slider
  var galleryThumbs = new Swiper(".sc-swiper-gallery-two", {
    centeredSlides: true,
    centeredSlidesBounds: true,
    slidesPerView: 3,
    watchOverflow: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    direction: "vertical",
  });

  var galleryMain = new Swiper(".sc-swiper-gallery", {
    watchOverflow: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    preventInteractionOnTransition: true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    effect: "fade",
    fadeEffect: {
      crossFade: true,
    },
    thumbs: {
      swiper: galleryThumbs,
    },
  });
  // Home 3 Services Slider
  var swiper = new Swiper(".services_scroll_slider", {
    slidesPerView: 4,
    spaceBetween: 30,
    pagination: {
      el: ".swiper-pagination",
      type: "progressbar",
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    autoplay: {
      delay: 2000,
    },
    loop: true,
    breakpoints: {
      320: {
        slidesPerView: 1,
      },
      640: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
    },
  });

  // image loaded portfolio init
  var gridfilter = $(".grid");
  if (gridfilter.length) {
    $(".grid").imagesLoaded(function () {
      $(".gridFilter").on("click", "button", function () {
        var filterValue = $(this).attr("data-filter");
        $grid.isotope({
          filter: filterValue,
        });
      });
      var $grid = $(".grid").isotope({
        itemSelector: ".grid-item",
        percentPosition: true,
        masonry: {
          columnWidth: ".grid-item",
        },
      });
    });
  }

  // project Filter
  if ($(".gridFilter button").length) {
    var projectfiler = $(".gridFilter button");
    if (projectfiler.length) {
      $(".gridFilter button").on("click", function (event) {
        $(this).siblings(".active").removeClass("active");
        $(this).addClass("active");
        event.preventDefault();
      });
    }
  }

  jQuery(document).ready(function ($) {
    let autoPlayDelay = 1500;
    let options = {
      init: true,
      // Optional parameters
      loop: false,

      autoplay: {
        delay: autoPlayDelay,
      },
      slidesPerView: 4,
      spaceBetween: 30,

      // Navigation arrows
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    };

    let mySwiper = new Swiper(".swiper-container", options);

    let slidersCount = mySwiper.params.loop
      ? mySwiper.slides.length - 2
      : mySwiper.slides.length;
    let widthParts = 100 / slidersCount;

    $(".swiper-counter .total").html(slidersCount);
    for (let i = 0; i < slidersCount; i++) {
      $(".swiper-progress-bar .progress-sections").append("<span></span>");
    }

    function initProgressBar() {
      let calcProgress =
        (slidersCount - 1) * (autoPlayDelay + mySwiper.params.speed);
      calcProgress += autoPlayDelay;
      $(".swiper-progress-bar .progress").animate(
        {
          width: "100%",
        },
        calcProgress,
        "linear",
      );
    }
    initProgressBar();

    mySwiper.on("slideChange", function () {
      let progress = $(".swiper-progress-bar .progress");

      $(".swiper-counter .current").html(this.activeIndex + 1);

      if (
        (this.progress == -0 || (this.progress == 1 && this.params.loop)) &&
        !progress.parent().is(".stopped")
      ) {
        progress.css("width", "0");
        if (this.activeIndex == 0) {
          initProgressBar();
        }
      }

      if (progress.parent().is(".stopped")) {
        progress.animate(
          {
            width: Math.round(widthParts * (this.activeIndex + 1)) + "%",
          },
          this.params.speed,
          "linear",
        );
      }
    });

    mySwiper.on("touchMove", function () {
      $(".swiper-progress-bar .progress").stop().parent().addClass("stopped");
    });
  });
  // Popup Video;
  var popupvideos = $(".popup-videos-button");
  if (popupvideos.length) {
    $(".popup-videos-button").magnificPopup({
      disableOn: 10,
      type: "iframe",
      mainClass: "mfp-fade",
      removalDelay: 160,
      preloader: false,
      fixedContentPos: false,
    });
  }
  // Header Sticky  Js
 $(window).on("scroll", function () {
  const scroll = $(window).scrollTop();
  const tooltipVisible = $("#overlay").is(":visible");

  /*if (tooltipVisible) {
    $("#sc-header-sticky").removeClass("sc-header-sticky");
    return; // stop processing if tooltip is visible
  }

  if (scroll < 100) {
    $("#sc-header-sticky").removeClass("sc-header-sticky");
  } else {
    $("#sc-header-sticky").addClass("sc-header-sticky");
  }*/
});

  /*-- canvas menu scripts start --*/
  var navexpander = $("#canva_expander");
  if (navexpander.length) {
    $("#canva_expander, #canva_close, #sc-overlay-bg2").on(
      "click",
      function (e) {
        e.preventDefault();
        $("body").toggleClass("canvas_expanded");
      },
    );
  }

  $(".mobile-navbar-menu a").each(function () {
    var href = $(this).attr("href");
    if ((href = "#")) {
      $(this).addClass("hash");
    } else {
      $(this).removeClass("hash");
    }
  });

  $.fn.menumaker = function (options) {
    var mobile_menu = $(this),
      settings = $.extend(
        {
          format: "dropdown",
          sticky: false,
        },
        options,
      );

    return this.each(function () {
      mobile_menu.find("li ul").parent().addClass("has-sub");
      var multiTg = function () {
        mobile_menu
          .find(".has-sub")
          .prepend('<span class="submenu-button"><em></em></span>');
        mobile_menu.find(".hash").parent().addClass("hash-has-sub");
        mobile_menu.find(".submenu-button").on("click", function () {
          if ($(this).parent().siblings("li").hasClass("active")) {
            $(this).parent().siblings("li").removeClass("active");
            $(this)
              .parent()
              .siblings("li")
              .find(".submenu-button")
              .removeClass("submenu-opened");
            $(this).parent().addClass("active");
            $(this).addClass("submenu-opened");
            if (
              $(this)
                .parent()
                .siblings("li")
                .find(".submenu-button")
                .siblings("ul")
                .hasClass("open-sub")
            ) {
              $(this)
                .parent()
                .siblings("li")
                .find(".submenu-button")
                .siblings("ul")
                .removeClass("open-sub")
                .hide("fadeIn");
              $(this)
                .parent()
                .siblings("li")
                .find(".submenu-button")
                .siblings("ul")
                .hide("fadeIn");
            } else {
              $(this)
                .parent()
                .siblings("li")
                .find(".submenu-button")
                .siblings("ul")
                .addClass("open-sub")
                .hide("fadeIn");
              $(this)
                .parent()
                .siblings("li")
                .find(".submenu-button")
                .siblings("ul")
                .slideToggle()
                .show("fadeIn");
            }

            if ($(this).siblings("ul").hasClass("open-sub")) {
              $(this).siblings("ul").removeClass("open-sub").hide("fadeIn");
              $(this).siblings("ul").hide("fadeIn");
              $(this).parent().removeClass("active");
              $(this).removeClass("submenu-opened");
            } else {
              $(this).siblings("ul").addClass("open-sub").hide("fadeIn");
              $(this).siblings("ul").slideToggle().show("fadeIn");
            }
          } else {
            $(this).parent().addClass("active");
            $(this).addClass("submenu-opened");
            if ($(this).siblings("ul").hasClass("open-sub")) {
              $(this).siblings("ul").removeClass("open-sub").hide("fadeIn");
              $(this).siblings("ul").hide("fadeIn");
              $(this).parent().removeClass("active");
              $(this).removeClass("submenu-opened");
            } else {
              $(this).siblings("ul").addClass("open-sub").hide("fadeIn");
              $(this).siblings("ul").slideToggle().show("fadeIn");
            }
          }
        });
      };

      if (settings.format === "multitoggle") multiTg();
      else mobile_menu.addClass("dropdown");
      if (settings.sticky === true) mobile_menu.css("position", "fixed");
      var resizeFix = function () {
        if ($(window).width() > 991) {
          mobile_menu.find("ul").show("fadeIn");
          mobile_menu.find("ul.sub-menu").hide("fadeIn");
        }
      };
      resizeFix();
      return $(window).on("resize", resizeFix);
    });
  };
  // Sal Animation
  sal({
    threshold: 0.1,
    once: true,
  });

  $(document).ready(function () {
    $("#mobile-navbar-menu").menumaker({
      format: "multitoggle",
    });
  });

  $(document).ready(function () {
    // ========== odometer initialize==========
    $(".odometer").appear(function (e) {
      var odo = $(".odometer");
      odo.each(function () {
        var countNumber = $(this).attr("data-count");
        $(this).html(countNumber);
      });
    });
  });

  // Select Box Style
  var servicesSelect = $(".select-services");
  if (servicesSelect.length) {
    var x, i, j, l, ll, selElmnt, a, b, c;
    /*look for any elements with the class "Services":*/
    x = document.getElementsByClassName("select-services");
    l = x.length;
    for (i = 0; i < l; i++) {
      selElmnt = x[i].getElementsByTagName("select")[0];
      ll = selElmnt.length;
      /*for each element, create a new DIV that will act as the selected item:*/
      a = document.createElement("DIV");
      a.setAttribute("class", "select-selected");
      a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
      x[i].appendChild(a);
      /*for each element, create a new DIV that will contain the option list:*/
      b = document.createElement("DIV");
      b.setAttribute("class", "select-items select-hide");
      for (j = 1; j < ll; j++) {
        /*for each option in the original select element,
        create a new DIV that will act as an option item:*/
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function (e) {
          /*when an item is clicked, update the original select box,
            and the selected item:*/
          var y, i, k, s, h, sl, yl;
          s = this.parentNode.parentNode.getElementsByTagName("select")[0];
          sl = s.length;
          h = this.parentNode.previousSibling;
          for (i = 0; i < sl; i++) {
            if (s.options[i].innerHTML == this.innerHTML) {
              s.selectedIndex = i;
              h.innerHTML = this.innerHTML;
              y = this.parentNode.getElementsByClassName("same-as-selected");
              yl = y.length;
              for (k = 0; k < yl; k++) {
                y[k].removeAttribute("class");
              }
              this.setAttribute("class", "same-as-selected");
              break;
            }
          }
          h.click();
        });
        b.appendChild(c);
      }
      x[i].appendChild(b);
      a.addEventListener("click", function (e) {
        /*when the select box is clicked, close any other select boxes,
          and open/close the current select box:*/
        e.stopPropagation();
        closeAllSelect(this);
        this.nextSibling.classList.toggle("select-hide");
        this.classList.toggle("select-arrow-active");
      });
    }
    function closeAllSelect(elmnt) {
      /*a function that will close all select boxes in the document,
      except the current select box:*/
      var x,
        y,
        i,
        xl,
        yl,
        arrNo = [];
      x = document.getElementsByClassName("select-items");
      y = document.getElementsByClassName("select-selected");
      xl = x.length;
      yl = y.length;
      for (i = 0; i < yl; i++) {
        if (elmnt == y[i]) {
          arrNo.push(i);
        } else {
          y[i].classList.remove("select-arrow-active");
        }
      }
      for (i = 0; i < xl; i++) {
        if (arrNo.indexOf(i)) {
          x[i].classList.add("select-hide");
        }
      }
    }
    document.addEventListener("click", closeAllSelect);
  }
  $(window).on("load", function () {
    // Animate loader off screen
    const preloader = $(".preloader");
    preloader.delay(600).fadeOut();
  });
})(jQuery);
