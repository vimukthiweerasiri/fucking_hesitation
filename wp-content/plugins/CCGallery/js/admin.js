jQuery(function($){
    
    // hide and show File Type starting category options
	var $startCategory = $('#startCategory');
	$('#showFileTypeButtons').change(function(){
		if( this.checked ) {
			$startCategory.find('option.filetype').show();
		}
		else {
			$startCategory.find('option.filetype').hide();
		}
	})
	.trigger('change');
	
	
	// generate category names from user entered comma separated list
	var categoryArr = [];
	$('#categories').change(function(){
		var list = $(this).val(),
			html = '',
			catname = '';
			
		categoryArr = list.split(',');
		
		$.each(categoryArr, function(i, val){
			val = $.trim(val);
			catname = val.toLowerCase();
			html += '<option value="'+catname+'">'+val+'</option>';
		});
		
		var selected = $startCategory.val();
		$startCategory.find('option.filetype').last().nextAll().remove().end().after(html);
		$startCategory.val( selected );
	});
	
	
	
	// show appropriate upload fields based on filetype chosen
	var $itemsList = $('#itemsList');
	$itemsList.on('change', 'input[name^="filetype"]', function(e, effect){
		var $this = $(this),
			speed = effect === 'noslide' ? 0 : 400;
			
		if( this.checked ) {
			type = $this.val();
		}
		else {
			return;
		}
		
		$this.siblings('input[name^="fileTypeVal"]').val(type);
		if( type === 'photo' ) {
			$this.siblings('div.audioUpload, div.videoUpload').slideUp(speed).next('br').hide();
		}
		else if( type === 'audio' ) {
			$this.siblings('div.audioUpload').slideDown(speed).next('br').show().end().siblings('div.videoUpload').slideUp(speed).next('br').hide();
		}
		else if( type === 'video' ) {
			$this.siblings('div.videoUpload').slideDown(speed).next('br').show().end().siblings('div.audioUpload').slideUp(speed).next('br').hide();
		}
	})
	.find('input[name^="filetype"]').trigger('change');
    
    
    
    
    // handle image upload
	$('div.uploader').each(function(){
        handleUpload( $(this) );
    });
    
    function handleUpload( $elem ) {
        uploader = new qq.FileUploader({
            element: $elem[0],
            action: uploadParams.upload_php,
            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif', 'mp3', 'ogg', 'mp4', 'webm', 'ogv'],
            params: {
                folder: uploadParams.upload_folder
            },
            onComplete: function( id, fileName, response ) {                
                $elem.prev('input').data('filename', response.filename).val( uploadParams.upload_url + '/' + response.filename );
            }
        });
        
		var text;
		if( $elem.parent().is('div.imageUpload') ) {
			text = 'Upload Image';
		}
		else if( $elem.parent().is('div.audioUpload') ) {
			text = 'Upload Audio';
		}
		else if( $elem.parent().is('div.videoUpload') || $elem.parent().is('div.mobileVideo') ) {
			text = 'Upload Video';
		}
        $elem.find('div.qq-upload-button').addClass('button').contents().first().replaceWith(text);
    }
	
	
    
    
    // make the item list sortable	
	$itemsList.sortable({
        revert: true,
        cursor: 'move',
        axis: 'y',
        containment: 'parent',
        start: function() {
            $(this).find('a.delete, a.expand, a.collapse').addClass('hide');
        },
        stop: function() {
            $(this).find('a.delete, a.expand, a.collapse').removeClass('hide');
        }
    });
	
	
	
	// first store a sample of the item html when page loads
	var $itemClone = $itemsList.children().eq(0).clone(true);
	
	// then add items
	$('#add-item').click(function(){
        var $clone = $itemClone.clone(true),
			$uploader = $clone.find('div.uploader'),
			count = $itemsList.children().length;
			
        $clone.find('input[type="text"], textarea, select').val('');
		$clone.find('input[name^="filetype"]').attr('name', 'filetype'+count).attr('checked', false).first().attr('checked', 'checked');
		$clone.find('input[name^="fileTypeVal"]').val('photo');
		$clone.find('div.audioUpload, div.videoUpload').hide();
        $uploader.empty();
        $itemsList.append($clone);
		$itemsList.children().last().find('div.uploader').each(function(){
			handleUpload( $(this) );
		});
    });
	
	
	
	// expand/collpase gallery item details
	$itemsList.on('click','a.collapse', function(){
		var $item = $(this).closest('li');
		// store current height
		$item.data('height', $item.height() );
		$item.animate({ height: '96px' }, 600).children().not('.no-hide').hide();
	});
	
	$itemsList.on('click','a.expand', function(){
		var $item = $(this).closest('li'),
			height = $item.data('height');
			
		$item.animate({ height: height }, 600, function(){
			$item.removeAttr('style');
			$item.children().not('div.audioUpload, div.audioUpload+br, div.videoUpload, div.videoUpload+br').show();
			$item.find('input[name^="filetype"]').trigger('change', ['noslide']);
		});
	});
	
	// when the page first loads then collapse all items except the first
	$itemsList.find('a.collapse').not(':first').trigger('click');
	
	
    
    // handle item deletion
	$itemsList.on('click', 'a.delete', function(){
        var $this = $(this),
            $parent = $this.parent(),
            fileName = $parent.find('input.upload-val').val(),
            data = {
                action: 'delete_files',
                name: fileName 
            };
            
        $.post( uploadParams.ajaxurl, data, function(data){});
        
        $parent.slideUp(600, function(){
            $parent.remove();
        });
    });
    
});

