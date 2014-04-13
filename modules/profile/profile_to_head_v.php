<?php
/**
 * profile_v.php (front)
 *
 * Представление профиля пользователя
 *
 * Данный файл является частью системы управления контентом
 * разработанной студией Дериво
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
if (!defined('IN_APP')) {
    die("not in app");
}

if(isset($friendly_url->url_sub_page) && (isset($friendly_url->url_command['edit']) || isset($friendly_url->url_command['add']))) {
	// загружать другие настройки и картинки в зависимости от языка
	if($friendly_url->url_lang['id']==1) {
		echo "<link rel='stylesheet' type='text/css' href='/assets/css/dropzone-ru.css'>";
		echo "<script type='text/javascript' src='/assets/js/ui/1.jquery.ui.core.1.10.4.js'></script>";
	} /*else {
		echo "<link rel='stylesheet' type='text/css' href='/assets/css/dropzone.css'>";
		echo "<script type='text/javascript' src='/assets/js/dropzone/jquery.dropzone.3.8.4.js'></script>";
	}*/
	echo "<link rel='stylesheet' type='text/css' href='/assets/css/multiple-select.css'>";
	echo "<script type='text/javascript' src='/assets/js/multipleselect/jquery.multiple.select.1.0.5.js'></script>";
}
?>
<script>
    var global_percents = {};
    global_percents[0] = <?=$commercial_const['site_commerce_min']?>;
    global_percents[1] = <?=$commercial_const['site_commerce_middle']?>;
    global_percents[2] = <?=$commercial_const['site_commerce_high']?>;

<? if(isset($friendly_url->url_sub_page) && (isset($friendly_url->url_command['edit']) || isset($friendly_url->url_command['add']))) { ?>
    $(document).ready(function($) {
    	$('select.multiple-checkbox-select').multipleSelect({selectAll: false});
    	
    	$('select.multiple-checkbox-line-select').multipleSelect({
    		selectAll: false,
			onClick: function(view) {
				$input_hidden = $(".multiple-checkbox-line-hidden");
				$selected = $('select.multiple-checkbox-line-select').multipleSelect('getSelects');
			    $input_hidden.val($selected);
			}	
    	});
    	
	    $(".multiple-checkbox-button").click(function() {
	        var $select = $(".multiple-checkbox-line-select"),
	            $input = $(".multiple-checkbox-line"),
	            $input_hidden = $(".multiple-checkbox-line-hidden"),
	            $value = $.trim($input.val()),
	            $opt = $("<option />", {
	                value: $value,
	                text: $value,
	                selected: true
	            });
	        if (!$value) {
	            $input.focus();
	            return;
	        }
	        $input.val("");
	        $selected = $('select.multiple-checkbox-line-select').multipleSelect('getSelects');
	        $input_hidden.val($selected+','+$value);
	        $select.append($opt).multipleSelect("refresh");
	    });
	    
	    
	    // галлерея с возможностью построения сортировки
	    if($('.dropzone').length>0) {
	    	var _this = this,
	    		hiddenFilesOrderArray = [];
	    	
	    	$('#add-product-form').append("<input id='drv-hidden-fileinput' type='hidden' name='product_order_edit_param[9]' style='display:none;' />");
			
			$('#add-product-form').append("<input id='drv-hidden-fileupload' type='file' name='product_edit_param[9][]' multiple style='display:none;' />");
			$('#drv-hidden-fileupload').on('change', function(e) {
				e.preventDefault();

				// получаем список реальных upload файлов
                var files; files = e.target.files;
                
                var editFilesInList = $("#dropzone-edit-files").find('li[class="dz-edit"]').map(function(){
                	return $(this).html();
                }).get();
                
                console.log(editFilesInList);
                
                /*uploadList = document.getElementById('dz-sortable');
                if(uploadList) {
                	hiddenFilesOrderArray = [];
                	while (uploadList.firstChild) {
                		uploadList.removeChild(uploadList.firstChild);
                	}
                }*/
				
				// формируем миниатюры и список скрытых файлов
				// наполняется массив 'hiddenFilesOrderArray'
				handleFiles(files);
				// проверем отображение изображения загрузчика
				if(files.length<=0 || hiddenFilesOrderArray.length>0) {
					checkUploadLabelDisplay();
				}
			});
			
			// Добавляем обработчик к картинке загрузчику
			uploadImg = document.getElementById('dz-message');
			if(!uploadImg){
				uploadImg = document.createElement("div");
				uploadImg.setAttribute("id", "dz-message");
				uploadImg.setAttribute("class", "dz-default dz-message");
				uploadImg.innerHTML = '<span>Добавить картинку</span>';
				uploadImg.addEventListener("click", function (e) {
					e.stopPropagation();
					$('#drv-hidden-fileupload').click();
				});
			}
			
			dropZone = document.getElementById('drv-dropzone');
			if(!dropZone.hasChildNodes()) {
				dropZone.appendChild(uploadImg);
				//dropZone.appendChild(hiddenFileUpload);
				//dropZone.appendChild(hiddenFileInput);
				
	    		uploadList = document.createElement("ul");
				uploadList.setAttribute("id", "dz-sortable");
				uploadList.setAttribute("class", "dropzone-previews");
	            dropZone.appendChild(uploadList);
	            
	            $("#dz-sortable").sortable({
	            	cursor: 'move',
					stop: function(event, ui) {
						var selectedImgIndex = ui.item.data('number');
						files = hiddenFilesOrderArray;
						reorderFiles(files);
					}
	            }).disableSelection();
            }
            
            // при редактировании подгрузить миниатюрки ранее загруженных файлов
            editImgList = document.getElementById('dropzone-edit-files');
            if(editImgList) {
            	var filepathMap = $("#dropzone-edit-files").find('li').map(function(){
                	return $(this).html();
                }).get();
                
                var filenameMap = $("#dropzone-edit-files").find('li').map(function(){
                	return $(this).data('name');
                }).get();
                
                for (_i = 0, _len = filepathMap.length; _i < _len; _i++) {
            		createThumbnailOnEdit(filenameMap[_i],filepathMap[_i]);
            		hiddenFilesOrderArray.push(hiddenFilesOrderArray.length);
            	}
            	checkUploadLabelDisplay();
            }
            
            $('body').on('click', '.dz-error-mark', function() {
            	var cur_item = $(this).parent(),
            		cur_item_number = $(this).parent().data('number'),
            		hiddenFileInput = $('#drv-hidden-fileinput');
            	
            	// если позиция по каким-то причинам пуста
            	/*if(typeof hiddenFilesOrderArray[cur_item_number] === 'undefined') {
            		return;
            	}*/
            	
            	//console.log()
            	
            	/*if() {
            		$.post(
				        "/index.ajax.php",
				        {
				            area        : 'profile',
				            sub_area    : 'public_offer',
				            action      : 'get_public_offer'
				        },
				        function(json){
				        	if(json['result']!=false) {
			                    show_popup();
			                    $(result_ajax).addClass('to_scroll').css('text-align','left').html(nl2br(json['result_msg']));
			                }
				        },
				        'json'
			        );
            	}*/
            	
            	// удаляем элемент из списка скрытых файлов 'hiddenFilesOrderArray'
            	hiddenFilesOrderArray.splice(cur_item_number, 1);
            	cur_item.hide('fast', function(){ cur_item.remove(); });
            	hiddenFileInput.val(hiddenFilesOrderArray.join(','));
            	checkUploadLabelDisplay();
            });
            
            function checkUploadLabelDisplay() {
            	if(hiddenFilesOrderArray.length>0){
					uploadImg.style.opacity = 0;
				} else {
					uploadImg.style.opacity = 1;
				}
            };
            
            /*function jsObj2phpObj(object) {
            	var json = "{";
            	for(property in object) {
            		var value = object[property];
            		if(typeof(value) == "string") {
            			json += '"'+property+'":"'+value+'",';
            		} else {
            			json += '"'+property+'":[';
            			for(prop in value) json += '"'+value[prop]+'",';
            			json = json.substr(0, json.length-1) + "],";
            		}
            	}
            	return json.substr(0, json.length-1) + "}";
            }*/
            
            /*function isLocalStorageAvailable() {
			    try {
			        return 'localStorage' in window && window['localStorage'] !== null;
			    } catch (e) {
			        return false;
			    }
			}*/

            function handleFiles(files) {
                var file, _i, _len, thumbnailBase64 = '',
                	result = true,
                	hiddenFileInput = $('#drv-hidden-fileinput'),
                	maxThumbnailFilesize = 1, // MB
	    			maxFilesize = 1; // MB

                for (_i = 0, _len = files.length; _i < _len; _i++) {
                	file = files[_i];
                	if (file.type.match(/image.*/) && file.size <= maxThumbnailFilesize * 1024 * 1024) {
						
						// создаем миниатюрку изображений и задаем ей порядковый номер
                    	createThumbnail(file, hiddenFilesOrderArray.length);
                    	
                    	// проверка на существование localStorage для html5
                    	/*if(isLocalStorageAvailable()) {
                    		thumbnailBase64 = localStorage.getItem("image-storage");
                       	} else { thumbnailBase64 = ''; }*/
                    	
                    	hiddenFilesOrderArray.push(hiddenFilesOrderArray.length);
					} else {
						result = false;
						return;
					}
                }

                hiddenFileInput.val(hiddenFilesOrderArray.join(','));
                return result;
            };
            
            function reorderFiles(files) {
                var file, _i, _len,
                	hiddenFileInput = $('#drv-hidden-fileinput'),
                	_result = true;
				
				// строим карту для прохода по существующим элементам
                var indexMap = $("#dz-sortable").find('li').map(function(){
                	return $(this).data('number');
                }).get();
				
				// заполняем список скрытых файлов 'hiddenFilesOrderArray' новыми данными
                hiddenFilesOrderArray = [];
				for (_i = 0, _len = indexMap.length; _i < _len; _i++) {
                    hiddenFilesOrderArray[_i] = indexMap[_i];
                }
                
                hiddenFileInput.val(hiddenFilesOrderArray.join(','));
                return _result;
            };
            
            function createThumbnail(file, fileIndex) {
                var fileReader,
                	_this = this,
                	thumbnailWidth = 100,
                	thumbnailHeight = 100;
				
                fileReader = new FileReader;
                fileReader.onload = function () {
                    var img;

                    img = new Image;
                    img.onload = function () {
                        var canvas, ctx, srcHeight, srcRatio, srcWidth, srcX, srcY, thumbnail, trgHeight, trgRatio, trgWidth, trgX, trgY;

                        canvas = document.createElement("canvas");
                        ctx = canvas.getContext("2d");
                        srcX = 0;
                        srcY = 0;
                        srcWidth = img.width;
                        srcHeight = img.height;
                        canvas.width = thumbnailWidth;
                        canvas.height = thumbnailHeight;
                        trgX = 0;
                        trgY = 0;
                        trgWidth = canvas.width;
                        trgHeight = canvas.height;
                        srcRatio = img.width / img.height;
                        trgRatio = canvas.width / canvas.height;
                        if (img.height < canvas.height || img.width < canvas.width) {
                            trgHeight = srcHeight;
                            trgWidth = srcWidth;
                        } else {
                            if (srcRatio > trgRatio) {
                                srcHeight = img.height;
                                srcWidth = srcHeight * trgRatio;
                            } else {
                                srcWidth = img.width;
                                srcHeight = srcWidth / trgRatio;
                            }
                        }
                        srcX = (img.width - srcWidth) / 2;
                        srcY = (img.height - srcHeight) / 2;
                        trgY = (canvas.height - trgHeight) / 2;
                        trgX = (canvas.width - trgWidth) / 2;
                        ctx.drawImage(img, srcX, srcY, srcWidth, srcHeight, trgX, trgY, trgWidth, trgHeight);
                        thumbnail = canvas.toDataURL("image/png");
                        
                        var size = file.size; 
                        if (size >= 100000000000) {
	                        size = size / 100000000000;
	                        string = "TB";
	                    } else if (size >= 100000000) {
	                        size = size / 100000000;
	                        string = "GB";
	                    } else if (size >= 100000) {
	                        size = size / 100000;
	                        string = "MB";
	                    } else if (size >= 100) {
	                        size = size / 100;
	                        string = "KB";
	                    } else {
	                        size = size * 10;
	                        string = "b";
	                    }
	                    var fileSize = "<strong>" + (Math.round(size) / 10) + "</strong> " + string;
                        
                        // создаем миниатюрку
						textBlock = '<li data-number="'+fileIndex+'" class="ui-state-default dz-preview dz-image-preview"><div class="dz-details"><div class="dz-filename"><span data-dz-name>'+file.name+'</span></div><div class="dz-size" data-dz-size>'+fileSize+'</div><img data-dz-thumbnail alt="'+file.name+'" src="'+thumbnail+'"/></div><div class="dz-error-mark"><span>x</span></div></li>';
                        uploadList.innerHTML += textBlock;
                        
                        // формируем base64 от оригинального размера изображения
                        /*canvas = document.createElement("canvas");
                        ctx = canvas.getContext("2d");
                        srcX = 0;
                        srcY = 0;
                        srcWidth = canvas.width = img.width;
                        srcHeight = canvas.height = img.height;
                        trgX = 0;
                        trgY = 0;
                        ctx.drawImage(img, trgX, trgY);
                        thumbnail = canvas.toDataURL("image/png");
                        
                        thumbnail_for_base64 = thumbnail.replace(/^data:image\/(png|jpg);base64,/, "");
                        
                        if(isLocalStorageAvailable()) {
                        	localStorage.setItem("image-storage", thumbnail_for_base64);
                        }*/
						
                        return img;
                    };
                    return img.src = fileReader.result;
                };
                return fileReader.readAsDataURL(file);
            };
	    	
	    	function createThumbnailOnEdit(filename, filepath) {
                var _this = this,
                	thumbnailWidth = 100,
                	thumbnailHeight = 100,
                	img;

                    img = new Image;
                    img.onload = function () {
	                    var canvas, ctx, srcHeight, srcRatio, srcWidth, srcX, srcY, thumbnail, trgHeight, trgRatio, trgWidth, trgX, trgY;
	
	                    canvas = document.createElement("canvas");
	                    ctx = canvas.getContext("2d");
	                    srcX = 0;
	                    srcY = 0;
	                    srcWidth = img.width;
	                    srcHeight = img.height;
	                    canvas.width = thumbnailWidth;
	                    canvas.height = thumbnailHeight;
	                    trgX = 0;
	                    trgY = 0;
	                    trgWidth = canvas.width;
	                    trgHeight = canvas.height;
	                    srcRatio = img.width / img.height;
	                    trgRatio = canvas.width / canvas.height;
	                    if (img.height < canvas.height || img.width < canvas.width) {
	                        trgHeight = srcHeight;
	                        trgWidth = srcWidth;
	                    } else {
	                        if (srcRatio > trgRatio) {
	                            srcHeight = img.height;
	                            srcWidth = srcHeight * trgRatio;
	                        } else {
	                            srcWidth = img.width;
	                            srcHeight = srcWidth / trgRatio;
	                        }
	                    }
	                    srcX = (img.width - srcWidth) / 2;
	                    srcY = (img.height - srcHeight) / 2;
	                    trgY = (canvas.height - trgHeight) / 2;
	                    trgX = (canvas.width - trgWidth) / 2;
	                    ctx.drawImage(img, srcX, srcY, srcWidth, srcHeight, trgX, trgY, trgWidth, trgHeight);
	                    thumbnail = canvas.toDataURL("image/png");
	                    
	                    // создаем миниатюрку
						textBlock = '<li data-number="'+hiddenFilesOrderArray.length+'" class="ui-state-default dz-preview dz-image-preview dz-edit"><div class="dz-details"><div class="dz-filename"><span data-dz-name>'+filename+'</span></div><img data-dz-thumbnail alt="'+filename+'" src="'+thumbnail+'"/></div><div class="dz-error-mark"><span>x</span></div></li>';
	                    uploadList.innerHTML += textBlock;
						
	                    return img;
                    };
                    img.src = filepath;
            };
	    	
			/*Dropzone.options.drvDropzone = {
				init: function() {
					var myDropzone = this;
					
					// First change the button to actually tell Dropzone to process the queue.
				    document.querySelector("button.save-but[type=submit]").addEventListener("click", function(e) {
					    // Make sure that the form isn't actually being sent.
					    e.preventDefault();
					    e.stopPropagation();
					    myDropzone.processQueue();
				    });
					
					this.on("addedfile", function(file) {
						// Create the remove button
						var removeButton = Dropzone.createElement("<a class='dz-remove' href='javascript:void(0);' data-dz-remove=''>< lang_text('{user_upload_remove_button}')?></a>");
						
						// Listen to the click event
						removeButton.addEventListener("click", function(e) {
							// Make sure the button click doesn't submit the form:
							e.preventDefault();
							e.stopPropagation();
							
							// Remove the file preview.
							myDropzone.removeFile(file);
							// you can do the AJAX request here.
						});
						
						// Add the button to the file preview element.
						file.previewElement.appendChild(removeButton);
					});
					
					this.on("dragend", function(e) {
						console.log(e);
						console.log(myDropzone.files);
					});
				}
			}
			Dropzone.autoDiscover = false;
			
			$('#drv-dropzone').dropzone({
				url: "#",
				paramName: "product_edit_param[9]",
				autoProcessQueue: false,
				uploadMultiple: true,
				parallelUploads: 100,
				maxFiles: 10,
				maxFilesize: 1, // MB
			});*/
		}
    });
<?	} ?>
</script>