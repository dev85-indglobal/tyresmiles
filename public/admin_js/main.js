$(document).ready(function(){

	$('#general-table').DataTable({
		dom: 'Bfrtip',
        buttons: ['csv', 'excel','pdf'],
        pageLength: 10,
	});

	(function (factory) {
		if (typeof define === "function" && define.amd) {
			define(["jquery", "moment", "datatables"], factory);
		} else {
			factory(jQuery, moment);
		}
	}(function ($, moment) {
	 
	$.fn.dataTable.moment = function ( format, locale ) {
		var types = $.fn.dataTable.ext.type;
	 
		// Add type detection
		types.detect.unshift( function ( d ) {
			// Strip HTML tags if possible
			if ( d && d.replace ) {
				d = d.replace(/<.*?>/g, '');
			}
	 
			// Null and empty values are acceptable
			if ( d === '' || d === null ) {
				return 'moment-'+format;
			}
	 
			return moment( d, format, locale, true ).isValid() ?
				'moment-'+format :
				null;
		} );
	 
		// Add sorting method - use an integer for the sorting
		types.order[ 'moment-'+format+'-pre' ] = function ( d ) {
			if ( d && d.replace ) {
				d = d.replace(/<.*?>/g, '');
			}
			return d === '' || d === null ?
				-Infinity :
				parseInt( moment( d, format, locale, true ).format( 'x' ), 10 );
		};
	};
	 
	}));

	$.fn.dataTableExt.afnFiltering.push(
		function( oSettings, aData, iDataIndex ) {
			if (document.getElementById('date-from') != null && document.getElementById('date-to') != null) {
				var iFini = document.getElementById('date-from').value;
				var iFfin = document.getElementById('date-to').value;

				var iStartDateCol = 11;
				var iEndDateCol = 11;

				var datofini=aData[iStartDateCol];
				var datoffin=aData[iEndDateCol];
				
				if ( iFini === "" && iFfin === "" )
				{
					return true;
				}
				else if ( iFini <= datofini && iFfin === "")
				{
					return true;
				}
				else if ( iFfin >= datoffin && iFini === "")
				{
					return true;
				}
				else if (iFini <= datofini && iFfin >= datoffin)
				{
					return true;
				}
				return false;
			}
			else{
				return true;
			}
		}
	);

	$.fn.dataTable.moment( 'YYYY-MM-DD' );
	$.fn.dataTable.moment( 'MMM D YYYY, h:mm a' );

	var ledgerTable = $('#ledger-table').DataTable({
		order: [[ 0, "desc" ]],
		columnDefs: [ 
			{
				"visible": false,
				"targets": [-1, -2]
			} 
		],
		footerCallback: function ( row, data, start, end, display ) {
			var api = this.api(), data;
 
			// Remove the formatting to get integer data for summation
			var intVal = function ( i ) {
				return typeof i === 'string' ?
					i.replace(/[\$,]/g, '')*1 :
					typeof i === 'number' ?
						i : 0;
			};
 
			// Total over all pages
			total = api
				.column( 7 )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
 
			// Total over this page
			pageTotal = api
				.column( 7, { page: 'current'} )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );

			// Update footer
			$( api.column( 7 ).footer() ).html(
				'Rs. '+pageTotal +' ( Rs. '+ total +' total)'
			);

			// Total over all pages
			total = api
				.column( 8 )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
 
			// Total over this page
			pageTotal = api
				.column( 8, { page: 'current'} )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
 
			// Update footer
			$( api.column( 8 ).footer() ).html(
				'Rs. '+pageTotal +' ( Rs. '+ total +' total)'
			);
		}
	});

	$('.ledgerdatepicker#date-from').datetimepicker({
		useCurrent : false,
		format : 'YYYY-MM-DD',
		showClear : true
	});

	$('.ledgerdatepicker#date-to').datetimepicker({
		useCurrent : false,
		format : 'YYYY-MM-DD',
		showClear : true
	});

	$("#date-from").on("dp.change", function (e) {
		$('#date-to').data("DateTimePicker").minDate(e.date);
	});

	$("#date-to").on("dp.change", function (e) {
		$('#date-from').data("DateTimePicker").maxDate(e.date);
	});

	$('#ledger-filter-form .ledger-select-filter').on('change', function(){
		var col = $(this).attr('data-column');
		var val = $(this).val();
		ledgerTable.column( col ).search(
			val
		).draw();
	});

	$('#ledger-filter-form .ledger-text-filter').on('keyup click dp.change', function(){
		ledgerTable.draw();
	});

	var datetimepicker = $('.datetimepicker').datetimepicker({
		useCurrent : false,
		format : 'YYYY-MM-DD'
	});

	$('.select2').select2();

	$('.delete-btn').click(function(){
		var $this = $(this);
		bootbox.confirm("Are you sure?<br />This action cannot be undone", function(result) {
			if (result) {
				$this.parent('form').submit();
			}
		});
	});

	$('.reject-doc-button').click(function(event){
		var $this = $(this);
		bootbox.prompt("Please provide a reason for rejecting this document", function(result) {
			console.log(result);
			if (result === null || result == '') {
				// Do Nothing
			} else {
				$this.prev('.reject-doc-form').find('.reason').val(result);
				$this.prev('.reject-doc-form').submit();
			}
		});
	});


	function initToolbarBootstrapBindings() {
		var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
			'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
			'Times New Roman', 'Verdana'
			],
			fontTarget = $('[title=Font]').siblings('.dropdown-menu');
		$.each(fonts, function(idx, fontName) {
			fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
		});
		$('a[title]').tooltip({
			container: 'body'
		});
		$('.dropdown-menu input').click(function() {
			return false;
			})
			.change(function() {
			$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
			})
			.keydown('esc', function() {
			this.value = '';
			$(this).change();
			});

		$('[data-role=magic-overlay]').each(function() {
			var overlay = $(this),
			target = $(overlay.data('target'));
			overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
		});

		if ("onwebkitspeechchange" in document.createElement("input")) {
			var editorOffset = $('#editor').offset();

			$('.voiceBtn').css('position', 'absolute').offset({
			top: editorOffset.top,
			left: editorOffset.left + $('#editor').innerWidth() - 35
			});
		} else {
			$('.voiceBtn').hide();
		}
	}

	function showErrorAlert(reason, detail) {
		var msg = '';
		if (reason === 'unsupported-file-type') {
			msg = "Unsupported format " + detail;
		} else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
			'<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
	}

	initToolbarBootstrapBindings();

	$('#editor').wysiwyg({
		fileUploadError: showErrorAlert
	});

	window.prettyPrint;
	prettyPrint();

	$('#promo-code-form').on('submit', function(){
		$('#promo-code-form #content').val($('#promo-code-form #editor').cleanHtml(false));
	});
});