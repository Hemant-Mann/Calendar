// Makes sure the document is ready before executing scripts
var pageUrl = window.location;
var pathname = pageUrl.pathname;
var home = pathname.split("/")[1];
home = "/" + home;
$(document).ready(function(){
    
	// Functions to manipulate the modal window
	var fx = {
		// Checks for a modal window and returns it, or
		// else creates a new one and returns that
		"initModal" : function() {
			// If no elements are matched, the length
			// property will return 0
			if($(".modal-window").length==0) {
				// Creates a div, adds a class, and
				// appends it to the body tag
				return $("<div>").hide().addClass("modal-window").appendTo("body");
			} else {
				// Returns the modal window if one
				// already exists in the DOM
				return $(".modal-window");
			}
		},

		// Adds the window to the markup and fades it in
		"boxin" : function(data, modal) {
			// Creates an overlay for the site, adds
			// a class and a click event handler, then
			// appends it to the body element
			$("<div>").hide().addClass("modal-overlay").click(function(event){
				// Removes event
				fx.boxout(event);
			}).appendTo("body");
			
			// Loads data into the modal window and
			// appends it to the body element
			modal.hide().append(data).appendTo("body");
			
			// Fades in the modal window and overlay
			$(".modal-window,.modal-overlay").fadeIn("slow");
		},
		
		// Fades out the window and removes it from the DOM
		"boxout" : function(event) {
			// If an event was triggered by the element
			// that called this function, prevents the
			// default action from firing
			if ( event!=undefined ) {
				event.preventDefault();
			}

			// Removes the active class from all links
			$("a").removeClass("active");
			// Fades out the modal window and overlay,
			// then removes both from the DOM entirely
			$(".modal-window,.modal-overlay").fadeOut("slow", function() {
				$(this).remove();
			});
			
		}	
	};

	// Takes two arguments month and year and render the calendars
	function renderCal(month, year) {
		$.ajax({
			type: "GET",
			url: home + "/home",
			// Pass in the month and year to the url
			data: { month: month, year: year }
		})
		.done(function(data) {
			// remove the old calendar
			$('#calendar').remove();
			
			// Modify the links to point to new months
			modifyLinks(data);

			// add the new calendar
			var content = $(data).find("#calendar");
			$('#content').append(content);

			changedCal();

		})
		.fail(function(msg){
			console.log(msg);
		})
		.always(function(){
			console.log("complete");
		});
	}

	// Display the selected event in a modal window
	function displayEvent(url) {
		// Checks if the modal window exists and
		// selects it, or creates a new one
		modal = fx.initModal();

		// Creates a button to close the window
		$("<a>").attr("href", "#").addClass("modal-close-btn").html("&times;")
			.click(function(event){
				event.preventDefault();
				// Removes modal window
				fx.boxout(event);
			}).appendTo(modal);

		$.ajax({
			type: "GET",
			url: url,
			success: function(data){
				var print = $(data).find("#eventInfo");
				fx.boxin(print, modal);

				// if edit event button is clicked
				$("#editEvent").on("click", function(event) {
					event.preventDefault();

					renderEventForm($("#editEvent"));
				});

				// if the delete button is clicked
				$("#deleteEvent").on("click", function(event) {
					event.preventDefault();

					deleteEvent($("#deleteEvent"));
					// Fades out the modal window
					fx.boxout(event);
				});		
			},
			error: function(msg) {
				console.log(msg);
			}
		});
	}

	// Display the add/edit event form
	function renderEventForm(selector) {
		// remove the event-viewer modal window if any
		var modalWindow = $(".modal-window,.modal-overlay");
		if(modalWindow.length !== 0) {
			modalWindow.remove();
		}
		
		// Find the url
		var url = selector.attr("href");
		
		// render the edit event page
		$.ajax({
			type: "GET",
			url: url,
			success: function(data) {
				// Instantiate a new modal window
				modal = fx.initModal();

				var print = $(data).find("#form");
				fx.boxin(print, modal);

				// Make cancel link behave like close button
				$("#cancel").on("click", function(event){
					event.preventDefault();
					fx.boxout(event);
				});

				// Now submit the form using ajax
				$("#form").submit(function(event) {
					event.preventDefault();
					
					submitEventForm($("#form"));
					
					$(".modal-window,.modal-overlay").remove();
				});
			},
			error: function(msg) { 
				console.log(msg);
			}
		});
	}

	// Submitting the event form using ajax
	function submitEventForm(selector) {
		var url = selector.attr("action"),
			formData = selector.serialize();

		formData = formData + "&submit=true";
		// Sends the data to the processing file
		$.ajax({
			type: "POST",
			url: url,
			data: formData,
			success: function(data) {
				var messages = $(data).find("#message");

				var month = $(data).find("#info").attr("data-month"),
					year = $(data).find("#info").attr("data-year");

				// Now update the calendar
				renderCal(month, year);

				// Display the messages to the user
				$("#messages").html(messages);
			},
			error: function(msg) {
				console.log(msg);
			}		
		});
	}

	// Deleting the event using ajax
	function deleteEvent(selector) {
		// Find the url
		var url = selector.attr("href"),
			x = confirm('Are You sure?');

		if(x) {
			$.ajax({
				type: "GET",
				url: url,
				success: function(data) {
					var messages = $(data).find("#message");
					
					var month = $(data).find("#info").attr("data-month"),
						year = $(data).find("#info").attr("data-year");

					// Now update the calendar
					renderCal(month, year);

					// Display the messages to the user
					$("#messages").html(messages);
					console.log(messages);
				},
				error: function(msg) {
					console.log(msg);
				}
			});
		} 
	}

	// Pull up event display 
	$("li>a").on("click", function(event) {
		event.preventDefault();
		// Adds an "active" class to the link
		$(this).addClass("active");
		
		// Gets the query string from the link href
		var url = $(this).attr("href");
		displayEvent(url);
	});

	// Pull up new event form modal window
	$("#newEvent").on("click", function(event) {
		event.preventDefault();
		renderEventForm($("#newEvent"));
	});
	
	// Change Date using the form and render cal using ajax
	$("#changeDate").submit(function(event) {
		event.preventDefault();
		var month = $(this).find("#month").val(),
			year = $(this).find("#year").val(),
			url = $(this).attr("action");

		renderCal(month, year);	
	});

	// Fire ajax when navigation links are clicked
	
	$("#goLeft").on("click", function(event) {
		event.preventDefault();
		linksAjax("goLeft");
	});

	$("#goRight").on("click", function(event) {
		event.preventDefault();
		linksAjax("goRight");
	});

	// Ajax call for navigation links
	function linksAjax(string) {
		var selector = $("#"+string),
		 	url = selector.attr("href"),
		 	month = selector.attr("data-month"),
		 	year = selector.attr("data-year");

		renderCal(month, year);
	}
	
	// Since the cal is changed we need to modify the 
	// navigation links with the data received from the ajax call
	function modifyLinks(data) {
		// Retrieve the necessary information
		var left = $(data).find("#goLeft").attr("data-month"),
		leftYr = $(data).find("#goLeft").attr("data-year"),
		right = $(data).find("#goRight").attr("data-month"),
		rightYr = $(data).find("#goRight").attr("data-year"),

		currentMon = $(data).find("#info").attr("data-month"),
		currentYr = $(data).find("#info").attr("data-year");

		// change the links
		$("#goLeft").attr("data-month", left); $("#goLeft").attr("data-year", leftYr);
		$("#goRight").attr("data-month", right); $("#goRight").attr("data-year", rightYr);

		// change the info field which provides current month and yr
		$("#info").attr("data-month", currentMon); $("#info").attr("data-year", currentYr);
	}

	// The cal is changed so the old selectors would become obsolete
	// So the selectors have to be set again for ajax calls
	// Otherwise the page would reload and settings would lost
	function changedCal() {
		$("li>a").on("click", function(event) {
			event.preventDefault();
			$(this).addClass("active");
			
			var url = $(this).attr("href");
			displayEvent(url);
		});

		$("#newEvent").on("click", function(event) {
			event.preventDefault();
			renderEventForm($("#newEvent"));
		});
	}
});
