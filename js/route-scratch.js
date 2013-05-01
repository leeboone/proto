		$(document).ready(function() {
			// Global Variables :: Begin
			var i = 1;
			var directionArray = new Array();
			
			// Global Variables :: End
			
			// App setup :: Begin
			// Create first droppable box
			createDropBox();
			$('#directions').children().hide();
			$('#restart').hide();
			$('#print').hide();
			
			
			// li dragging options
			$('.drag').children().draggable({
				revert: 'invalid',
				cursor: 'move',
				helper: 'clone',
				opacity: .85,
				snap: '.dropper',
				snapMode: 'inner',
				snapTolerance: 10
			});
			
			// App setup :: End
			
			// Functions :: Begin
			
			// createDropBox()
			// definition:: Creates a new drop box in the #direction-order ul
			//				should be called whenever a new direction is dropped
			//				onto the last box.
			function createDropBox() {
				// Add the a new box
				$("#direction-order").append("<li id=\"box" + i + "\" class=\"dropper\"><h2>" + i + "</h2></li>");
				i++;

				if (i>=2){
					$('#restart').show();
				}
				
				// li dropping options
				$('#direction-order').children().droppable({
					greedy: true,
					hoverClass: 'dropperHover',
					tolerance: 'intersect',
					drop: function(event, ui){
						$('.city').fadeOut();
						$('#d').fadeOut();
						// Create a new drop box
						if (i<=9) {
							createDropBox();
						}
						$(this).droppable('disable');
						// Hide dropped item
						$(ui.draggable).fadeOut();
						// Don't need the dropped helper anymore
						$(ui.helper).remove();
						
						// Get information about dropped item
						var droppedId = $(ui.draggable).attr('id');
						var droppedContent = $(ui.draggable).text();

						// Insert droppedId into the direction array
						arrayNumber = directionArray.length;
						directionArray[arrayNumber] = droppedId;
						
						// Add dragged name to drop box
						$(this).html('<h4>' + droppedContent + '</h4>');
						return false;
					}
				});
			}
			// Functions :: End
			// Show selected map directions
			$('#generate').click(function(){
				// Check for enough boxes
				if (i<3) {
					alert('Please select two or more destinations.');
				} else {
					// Hide generate button
					$('#generate').fadeOut();
					$('#print').show();
					// Hide the selector div to show directions
					$('#selector').slideUp();
					$('h3:first').fadeOut();
					// Print the entire array
					for (var f = 0; f < directionArray.length; f++) {
						if (f==0) {
							var previousArrayElement = f;
						} else {
							var previousArrayElement = f - 1;
						}
						
						if (f==0) {
							// console.log('on the next one');
						} else {
							var directionCode = directionArray[previousArrayElement] + "-" + directionArray[f];

							var linkId = "#[id=" + directionCode + "]";
							var linkHTML = $("" + linkId + "").html();
							$('#direction-results').append("<div class=\"result\">" + linkHTML + "</div>");
							$('.result:even').css("background-color", "#ecaf5f");
						}
					};
				return false;
				}
			});
			// Reset map functions
			$('#restart').click(function(){
				directionArray = [];
				$('#directions').children().hide();
				$('#direction-order').children().remove();
				$('#d').show();
				$('h3:first').show();
				$('.city').show();
				$('#distilleries').children().show();
				$('#selector').slideDown();
				i = 1;
				createDropBox();
				$('#generate').fadeIn();
				$('#restart').fadeOut();
				$('#print').fadeOut();
				$('#direction-results').empty();
				return false;
			});
			// Print map
			$('#print').click(function(){
				print();
			});
		});
