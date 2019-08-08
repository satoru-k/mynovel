/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

//小ジャンルの要素を変数に入れる
var $children = $('.children');
//後のイベントで、不要なoption要素を削除するため、オリジナルをとっておく
var original = $children.html();
//大ジャンル側のselect要素が変更になるとイベントが発生
$('.parent').change(function() {
  //選択された大ジャンルのvalueを取得し、変数に入れる
  var val1 = $(this).val();
  //削除された要素を元に戻すため.html(original)を入れておく
  $children.html(original).find('option').each(function() {
    //data-valの値を取得
    var val2 = $(this).data('val');
    //valueと異なるdata-valを持つ要素を削除
    if (val1 != val2) {
      $(this).not(':first-child').remove();
    }
  });
  //大ジャンル側のselect要素が未選択の場合、小ジャンルをdisabledにする
  if ($(this).val() == "") {
    $children.attr('disabled', 'disabled');
  } else {
    $children.removeAttr('disabled');
  }
});

//ページトップへ
$("#back-top").hide();
  $(function () {
      $(window).scroll(function () {
          //100pxスクロールしたら
          if ($(this).scrollTop() > 150) {
              //フェードインで表示
              $('#back-top').fadeIn();
          } else {
              $('#back-top').fadeOut();
          }
      });
      //ここからクリックイベント
      $('#back-top a').click(function () {
          $('body,html').animate({
              scrollTop: 0
          }, 500);
          return false;
      });
  });

//ページの一番下へ
$("#go-bottom").show();
  $(function () {
      $(window).scroll(function () {
          //100pxスクロールしたら
          if ($(this).scrollTop() > 150) {
              //フェードインで表示
              $('#go-bottom').fadeOut();
          } else {
              $('#go-bottom').fadeIn();
          }
      });
      //ここからクリックイベント
      $('#go-bottom a').click(function () {
          $('body,html').animate({
              scrollTop: $(document).height()
          }, 500);
          return false;
      });
  });

//検索タイプ切り替え
$('select[name="search"]').change(function() {
  var val = $('select[name="search"] option:selected').val();
  if (val == 'select[name="search"]') return;
  $('div[name="search_type"]').hide();
  $('div#' + val).show();
});
