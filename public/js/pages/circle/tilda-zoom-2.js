function t_initZoom(){$('[data-zoomable="yes"]').length&&(window.tzoominited=!0,$('[data-zoomable="yes"]').addClass("t-zoomable"),$("body").append('<div class="t-zoomer__wrapper">      <div class="t-zoomer__container">      </div>      <div class="t-zoomer__bg"></div>      <div class="t-zoomer__close">        <div class="t-zoomer__close-line t-zoomer__close-line-first"></div>        <div class="t-zoomer__close-line t-zoomer__close-line-second"></div>      </div>    </div>'),t_showZoom(),$(".t-zoomer__close, .t-zoomer__bg").click(function(o){$("body").removeClass("t-zoomer__show"),$("body").removeClass("t-zoomer__show_fixed"),$(document).unbind("keydown")}))}function t_showZoom(){$(".t-records").on("click",".t-zoomable",function(o){$("body").addClass("t-zoomer__show"),$(".t-zoomer__container").html('<div class="t-carousel__zoomed">      <div class="t-carousel__zoomer__slides">        <div class="t-carousel__zoomer__inner">        </div>        <div class="t-carousel__zoomer__control t-carousel__zoomer__control_left" data-zoomer-slide="prev">          <div class="t-carousel__zoomer__arrow__wrapper t-carousel__zoomer__arrow__wrapper_left">            <div class="t-carousel__zoomer__arrow t-carousel__zoomer__arrow_left t-carousel__zoomer__arrow_small"></div>          </div>        </div>        <div class="t-carousel__zoomer__control t-carousel__zoomer__control_right" data-zoomer-slide="next">          <div class="t-carousel__zoomer__arrow__wrapper t-carousel__zoomer__arrow__wrapper_right">            <div class="t-carousel__zoomer__arrow t-carousel__zoomer__arrow_right t-carousel__zoomer__arrow_small"></div>          </div>        </div>      </div>    </div>');var e=$(this).closest(".r").attr("id"),s=$("#"+e).find(".t-zoomable");$("#"+e).find(".t-slds").length&&(s=$(this).closest(".t-slds").find(".t-zoomable"));s.each(function(){var o=$(this).attr("data-img-zoom-url").split(",");if($(this).is("img"))var e=$(this).attr("title"),s=$(this).attr("data-img-zoom-descr");if($(this).is("div"))e=$(this).attr("title"),s=$(this).attr("data-img-zoom-descr");if(void 0!==e&&!1!==e)var _='<div class="t-zoomer__title t-name t-descr_xxs">'+e+"</div>";else _="";if(void 0!==s&&!1!==s)var t='<div class="t-zoomer__descr t-descr t-descr_xxs">'+s+"</div>";else t="";$(".t-carousel__zoomer__inner").append('<div class="t-carousel__zoomer__item"><div class="t-carousel__zoomer__wrapper"><img class="t-carousel__zoomer__img" src="'+o+'"></div><div class="t-zoomer__comments">'+_+t+"</div></div>")}),$(".t-carousel__zoomer__item").each(function(){$(this).css("display","block");var o=$(this).find(".t-zoomer__comments"),e=o.find(".t-zoomer__title"),s=o.find(".t-zoomer__descr");e.length||s.length||o.css("padding","0");var _=o.innerHeight();$(this).css("display",""),$(this).find(".t-carousel__zoomer__wrapper").css("bottom",_)});var _,t=$(this).attr("data-img-zoom-url"),r=$('.t-carousel__zoomer__img[src="'+t+'"]'),i=$(".t-carousel__zoomer__item");r.closest(i).show(0),i.each(function(){$(this).attr("data-zoomer-slide-number",$(this).index())}),pos=parseFloat($(".t-carousel__zoomer__item:visible").attr("data-zoomer-slide-number")),$(".t-carousel__zoomer__control_right").click(function(){pos=(pos+1)%i.length,i.hide(0).eq(pos).show(0)}),$(".t-carousel__zoomer__control_left").click(function(){pos=(pos-1)%i.length,i.hide(0).eq(pos).show(0)}),$(document).keydown(function(o){37==o.keyCode&&(pos=(pos-1)%i.length,i.hide(0).eq(pos).show(0)),39==o.keyCode&&(pos=(pos+1)%i.length,i.hide(0).eq(pos).show(0)),27==o.keyCode&&($("body").removeClass("t-zoomer__show"),$("body").removeClass("t-zoomer__show_fixed"),$(document).unbind("keydown"))}),$(".t-carousel__zoomer__inner").bind("touchstart",function(o){_=o.originalEvent.touches[0].clientX}),$(".t-carousel__zoomer__inner").bind("touchend",function(o){var e=o.originalEvent.changedTouches[0].clientX;e+50<_?(pos=(pos-1)%i.length,i.hide(0).eq(pos).show(0)):_<e-50&&(pos=(pos+1)%i.length,i.hide(0).eq(pos).show(0))}),1<$(".t-carousel__zoomer__item").size()?$("body").addClass("t-zoomer__show_fixed"):$(".t-carousel__zoomer__control").css("display","none"),$(".t-carousel__zoomer__inner").click(function(o){$("body").removeClass("t-zoomer__show"),$("body").removeClass("t-zoomer__show_fixed"),$(document).unbind("keydown")});var a=0;$(window).scroll(function(o){var e=$(this).scrollTop();a<e&&($("body").not(".t-zoomer__show_fixed").removeClass("t-zoomer__show"),$(document).unbind("keydown")),a=e})})}$(document).ready(function(){t_initZoom()});
