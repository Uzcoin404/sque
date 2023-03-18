
jQuery(document).ready(function ($) {


  // ----------------------------------simplebar
  // $('[data-simplebar]').each(element, new SimpleBar());
  // ----------------------------------left sidebar toggler
  if ($(window).width() > 1024) {
    $('.sidebar__toggler i').on('click', function (e) {
      e.stopPropagation()
      $(this).toggleClass('active')
      $('.header').css('padding-left', '0px')
      $('aside.sidebar').fadeToggle()
      if ($('.sidebar__toggler i').hasClass('active')) {
        $(this).attr('title', 'Открыть боковую панель')
      } else {
        $('.header').css('padding-left', '')
        $(this).attr('title', 'Скрыть боковую панель')
      }
      setTimeout(UpdateHoderRowGroup,500);
    })
  } else {
    $('aside.sidebar').addClass('is-mobile')
    $('.mobile-sidebar__toggler').on('click', function (e) {
      $(this).toggleClass('active')
      $('body').toggleClass('mobile-on')
      $('.sidebar.is-mobile').not('.sidebar-right').toggleClass('sidebar-show')
      $('.mobile-sidebar__overlay').toggleClass('overlay-show')
    })
    $('.mobile-sidebar__toggler_right').on('click', function (e) {
      $(this).toggleClass('active')
      $('body').toggleClass('mobile-on')
      $('.sidebar.sidebar-right.is-mobile').toggleClass('sidebar-show')
      $('.mobile-sidebar__overlay').toggleClass('overlay-show')
    })
   
  }
  // -----------------------------------light dark theme toggle js



  // получаем куку
  function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
  }
  // проверяем
  if (getCookie('theme') == 'dark') {
    $('.ballun').addClass('active')
    $('body').addClass('theme-dark')
  }
  // ==устанавливаем \ удаляем куки
  function dark() {
    document.cookie = "theme=dark; samesite=lax; path=/;"
    $('.ballun').addClass('active')
    $('body').addClass('theme-dark')
  }
  function light() {
    document.cookie = "theme=dark; samesite=lax;max-age=0;path=/;"
    $('.ballun').removeClass('active')
    $('body').removeClass('theme-dark')
  }
  // переключаем тему
  $('.theme-style-toggler').on('click', function (e) {
    e.stopPropagation()
    if (e.target.className == 'dark') {
      dark()
    }
    if (e.target.className == 'light') {
      light()
    }
  })
  //  --------------------------------------toggle mobile menu
  $('[data="mobile-toggle"]').on('click', function (e) {
    e.stopPropagation()
    $('[data="main-nav"]').toggleClass('mobile-open')
    if ($('[data="main-nav"]').hasClass('mobile-open')) {
      $('body').css('overflow', 'hidden')
    } else {
      $('body').css('overflow', 'visible')
    }
  })
  // input style for left sidebar
  $('.groups-item label').on('click', function (e) {
    if ($('input', this).prop('checked') == true) {
      $(this).addClass('checked')
    } else {
      $(this).removeClass('checked')
    }
  })
})


