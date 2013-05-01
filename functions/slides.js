// JavaScript Document

var j$ = jQuery;

j$(document).ready(init);
//j$(window).load(loaded);


function init()
{



    j$("#homeSlider .slides").anythingSlider({
        buildArrows     :   false,
        buildNavigation :   false,
        buildStartStop  :   false,
        autoPlay        :   true,
        delay           :   4000,
        hashTags        :   false,
        expand          :   true,
        resizeContents  :   false,
        mode            :   'f'
    });



}
function loaded()
{
}

