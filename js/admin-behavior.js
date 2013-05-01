// JavaScript Document

var j$ = jQuery;

j$(document).ready(init);
//j$(window).load(loaded);





function init()
{
jQuery('.repeatable-add').click(function() {
    var $field = jQuery('#tbt-repeatable-list li:last').clone(true);
    jQuery('input', $field).val('').attr('name', function(index, name) {
        return name.replace(/(\d+)/, function(fullMatch, n) {
            return Number(n) + 1;
        });
    });
    alert($field);
    jQuery("#tbt-repeatable-list").append($field);
    return false;
});

jQuery('.repeatable-remove').click(function(){
    jQuery(this).parent().remove();
    return false;
});

// jQuery('.custom_repeatable').sortable({
//     opacity: 0.6,
//     revert: true,
//     cursor: 'move',
//     handle: '.sort'
// });
}
function loaded()
{
}

