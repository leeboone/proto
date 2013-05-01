// JavaScript Document

var j$ = jQuery;

j$(document).ready(init);
//j$(window).load(loaded);

var pageHeight;
var winHeight;

var agent = navigator.userAgent;
if(agent.indexOf('Windows NT 5.1') > -1)
{
  j$("html").addClass('winXP');
}


function init()
{
    pageHeight = j$('body').height();
    winHeight = j$(window).height();
    var $backtotop = j$("<a id='backtotop' href='#pageTitle' class='btn backtotop-btn' style='clear:both;'>Back<br/>to top</a>");

    j$("#heart .time span").contents().stretch({'max':40
        });
    
    if(pageHeight > winHeight) {
        j$('body').append($backtotop);
        $backtotop.hide();
        j$(function () {
            j$(window).scroll(function(){
                if (j$(this).scrollTop() > 100){
                    $backtotop.fadeIn();
                } else {
                    $backtotop.fadeOut();
                }
            });
            $backtotop.click(function(){
                j$('body,html').animate({
                    scrollTop:0
                }, 800);
                return false;
            });
        });
    }





}
function loaded()
{
}

