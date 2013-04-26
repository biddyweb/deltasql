// main.js
var clip = new ZeroClipboard( document.getElementById("copy-button"), {
  moviePath: "ZeroClipboard.swf"
} );

clip.on( 'load', function(client) {
  //alert( "movie is loaded" );
} );

clip.on( 'complete', function(client, args) {
  this.style.display = 'none'; // "this" is the element that was clicked
  var str = args.text;
  if(str.length > 200) { str = str.substring(0,200)+'\n...';}
  alert("Copied text to clipboard: \n" + str);
} );

clip.on( 'mouseover', function(client) {
  //alert("mouse over");
} );

clip.on( 'mouseout', function(client) {
  //alert("mouse out");
} );

clip.on( 'mousedown', function(client) {

  //alert("mouse down");
} );

clip.on( 'mouseup', function(client) {
  //alert("mouse up");
} );