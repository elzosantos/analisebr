/**
 * This object is responsible for showing messages
 */
var flashMessenger = {
  // JQuery selector for getting the element in which the message is placed
  message: $('#messenger'),
  // setText is the function that sets the text and puts a timer on it when 
  // to fadeOut
  setText: function(text) {
    // Checks if the html element exists if not create a new one 
    if(this.message.length === 0) {
      $('<div id="messenger">' + text + '</div>').prependTo($('body'));
      this.message = $('#messenger');
    }
    // If html element exists put the text in and show it
    else this.message.html(text).show();
    // Clears the timer
    clearTimeout(this.timer);
    // Set the timer to two seconds
    this.timer = setTimeout(function() {
      flashMessenger.message.fadeOut('1000'); // FadeOut in one second
    },2000);
  }
};