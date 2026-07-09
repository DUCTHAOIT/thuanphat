jssor_slider1_starter = function (containerId) {
    var jssor_slider1 = new $JssorSlider$(containerId, {
        $ShowLoading: true,                                 //[Optional] Show loading screen or not default value is false
        $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
        $AutoPlaySteps: 3,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
        $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
        $PauseOnHover: false,                               //[Optional] Whether to pause when mouse over if a slideshow is auto playing, default value is false

        $ArrowKeyNavigation: false,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
        $SlideDuration: 300,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 400
        $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
        $SlideWidth: 150,                                   //[Optional] Width of every slide in pixels, default value is width of 'slides' container
        //$SlideHeight: 150,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
        $SlideSpacing: 5, 					                //[Optional] Space between each slide in pixels, default value is 0
        $DisplayPieces: 9,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
        $ParkingPosition: 0,                              //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
        $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, direction navigator container, thumbnail navigator container etc).
        $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, default value is 1
        $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

        $NavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
            $Class: $JssorNavigator$                       //[Required] Class to create navigator instance
//            $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
//            $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both
//            $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
//            $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
//            $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
//            $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
//            $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
        },

        $DirectionNavigatorOptions: {
            $Class: $JssorDirectionNavigator$,              //[Requried] Class to create direction navigator instance
            $ChanceToShow: 1,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
            $Steps: 3                                       //[Optional] Steps to go for each navigation request, default value is 1, default value is 1
        }
    });
};