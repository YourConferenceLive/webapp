
$(()=>{
let heightDiff = getRowHeight();
    console.log("Height difference:", Math.abs(parseInt(heightDiff)));

$('.row2').css('min-height',"calc(100vh - "+Math.abs(parseInt(heightDiff))+"px)");
})

function getRowHeight() {
let height_diff;

let row1Height = $('.row1').height();
let menuHeight = $('#mainMenu').height()
height_diff = 100 - (parseInt(row1Height) + parseInt(menuHeight) + 100);
return height_diff;
}
