/*!
 * Fullscreen extension for jQuery Magnify (http://thdoan.github.io/magnify/)
 *
 * Released under the MIT License. Read a copy of the license in the LICENSE file or at
 * https://choosealicense.com/licenses/mit/
 */

(function($) {
  'use strict';
  // Ensure this is loaded after jquery.magnify.js
  if (!$.fn.magnify) return;
  //$.fn.magnify.defaults.fullscreen = true;
  // Add required CSS
  $('<style>' +
    '.magnify-lens { visibility:hidden; }' +
    '.lens-fullscreen {' +
      'position:fixed;' +
      'top:0;' +
      'left:0;' +
      'width:100%;' +
      'height:100%;' +
      'background:#ccc;' +
      'cursor:move;' +
      'display:none;' +
      'overflow:scroll;' +
      '-webkit-overflow-scrolling:touch;' +
      'text-align:center;' +
      'z-index:9999;' +
    '}' +
    '.magnify-fullscreen {' +
      '-webkit-user-select:none;' +
      '-moz-user-select:none;' +
      '-ms-user-select:none;' +
    '}' +
    '.magnify-fullscreen>.close {' +
      'position:fixed;' +
      'top:10px;' +
      'right:10px;' +
      'width:32px;' +
      'height:32px;' +
      'background:#333;' +
      'border-radius:16px;' +
      'color:#fff;' +
      'cursor:pointer;' +
      'display:inline-block;' +
      'font:normal bold 20px/32px sans-serif;' +
      'letter-spacing:0;' +
      'opacity:0.8;' +
      'text-align:center;' +
      'text-shadow:none;' +
      'z-index:9999;' +
    '}' +
    '@media only screen and (min-device-width:320px) and (max-device-width:773px) {' +
      '/* Assume QHD (1440 x 2560) is highest mobile resolution */' +
      '.lens-fullscreen { display:block; }' +
    '}' +
    '</style>').appendTo('head');
  // Ensure .magnify is rendered
  $(window).on('load', function() {
    $('body').append('<div class="magnify-fullscreen"><div class="lens-fullscreen"></div></div>');
    var $magnify = $('.magnify'),
      $magnifyFullscreen = $('.magnify-fullscreen'),
      $lensFullscreen = $('.lens-fullscreen'),
      bDesktopFullscreen = true,//$magnify.data('fullscreen'),
      getPos = function(e, sProp) {
        return e[sProp]
          || (e.originalEvent.touches && e.originalEvent.touches[0] && e.originalEvent.touches[0][sProp])
          || (e.originalEvent.changedTouches && e.originalEvent.changedTouches[0] && e.originalEvent.changedTouches[0][sProp])
          || 0;
      };
    if (bDesktopFullscreen) {
      $magnify.children('.magnify-lens').hide();
      $magnify.css('cursor', 'zoom-in');
      $lensFullscreen.css({
        'display': 'block',
        'overflow': 'hidden'
      });
    } else {
      // Prevent FOUC
      $magnify.children('.magnify-lens').css('visibility', 'visible');
    }
    // Only enable fullscreen zoom if 'fullscreen' option is enabled or on smartphones
    if (bDesktopFullscreen || ($lensFullscreen.is(':visible') && !!('ontouchstart' in window || (window.DocumentTouch && document instanceof DocumentTouch) || navigator.msMaxTouchPoints))) {
      // Remove magnifying lens event handlers
      $magnify.off();
      // Initiate fullscreen zoom
      // NOTE: Fixed elements inside a scrolling div have issues in iOS, so we need to insert the
      // close icon at the same level as the lens.
      $magnifyFullscreen.hide().append('<i title="Close" class="close">&times;</i>');
      // Hook up event handlers
      $magnifyFullscreen.children('.close').on('mouseup touchend', function(e) {
        e.preventDefault();
        $magnifyFullscreen.hide();
      });
      $magnify.children('img').data({
        // Store initial scroll offsets
        'scrollOffset': {
          'x': 0,
          'y': 0
        }
      }).on({
        'mouseup touchend': function(e) {
          // Only execute on click/tap (not drag/swipe)
          var $this = $(this),
            nX = getPos(e, 'pageX'),
            nY = getPos(e, 'pageY');
          if ($this.data('dragging') && (Math.abs(nX-$this.data('prevX'))>4 || Math.abs(nY-$this.data('prevY'))>4)) return;
          var oScrollOffset = $this.data('scrollOffset');
          $magnifyFullscreen.show();
          // Zoom into click/touch point
          $lensFullscreen.scrollLeft(oScrollOffset.x);
          $lensFullscreen.scrollTop(oScrollOffset.y);
        },
        'mousemove touchmove': function() {
          // Set drag state
          $(this).data('dragging', true);
        },
        'mousedown touchstart': function(e) {
          // Determine zoom position
          var $this = $(this),
            oZoomSize = $this.data('zoomSize'),
            nX = getPos(e, 'pageX'),
            nY = getPos(e, 'pageY'),
            nXPct = (nX-$this.offset().left) / $this.width(),
            nYPct = (nY-$this.offset().top) / $this.height();
          // Render zoom image
          // NOTE: In iOS background-image is url(...), not url("...").
          $lensFullscreen.html('<img src="' + $this.prev('.magnify-lens').css('background-image').replace(/url\(["']?|["']?\)/g, '') + '" alt="">');
          $this.data({
            // Reset drag state
            'dragging': false,
            // Save start coordinates
            'prevX': nX,
            'prevY': nY,
            // Update scroll offsets
            'scrollOffset': {
              'x': (oZoomSize.width*nXPct)-(window.innerWidth/2),
              'y': (oZoomSize.height*nYPct)-(window.innerHeight/2)
            }
          });
        }
      });
      if (bDesktopFullscreen) {
        var bDragging = false,
          nPreviousX,
          nPreviousY,
          pan = function(e) {
            if (bDragging) {
              e.preventDefault();
              var nX = getPos(e, 'clientX'),
                nY = getPos(e, 'clientY'),
                nDirectionX = (nPreviousX-nX)>0 ? 1 : -1,
                nDirectionY = (nPreviousY-nY)>0 ? 1 : -1;
              $lensFullscreen.scrollLeft($lensFullscreen.scrollLeft()+(nPreviousX-nX));
              $lensFullscreen.scrollTop($lensFullscreen.scrollTop()+(nPreviousY-nY));
              nPreviousX = nX;
              nPreviousY = nY;
            }
          };
        $lensFullscreen.on({
          'mousedown touchstart': function(e) {
            e.preventDefault();
            nPreviousX = getPos(e, 'clientX');
            nPreviousY = getPos(e, 'clientY');
            bDragging = true;
          },
          'mousemove touchmove': pan
        });
        $(document).on({
          'keyup': function(e) {
            // Close on Escape
            if (e.which===27) $magnifyFullscreen.hide();
          },
          'mouseleave mouseup touchend': function() {
            bDragging = false;
          }
        });
      }
    }
  });
}(jQuery));


$(document).ready(function() {
  $('#lightslider-demo').lightSlider({
    controls: true,
    item: 3,
    loop: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          item: 3
        }
      },
      {
        breakpoint: 768,
        settings: {
          item: 2
        }
      },
      {
        breakpoint: 640,
        settings: {
          item: 1
        }
      }
    ]
  });
  $('#lightslider-demo img').magnify();
});

//video
$(document).ready(function() {
  $('#content-slider-video').lightSlider({
    controls: true,
    item: 3,
    loop: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          item: 3
        }
      },
      {
        breakpoint: 768,
        settings: {
          item: 2
        }
      },
      {
        breakpoint: 640,
        settings: {
          item: 1
        }
      }
    ]
  });
  $('#content-slider-video iframe').magnify();
});