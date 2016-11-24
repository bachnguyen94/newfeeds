var Core =
{
    init: function()
    {
        tinymce.init({
            selector: ".hw-mce-advance",
            theme: "modern",
            relative_urls : false,
            document_base_url: BASE_URL,
            height: 400,
            plugins: [
                 "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                 "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                 "save table contextmenu directionality emoticons template paste textcolor responsivefilemanager filemanager"
            ],
            skin : 'lightgray',
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | print preview media fullpage | forecolor backcolor emoticons | responsivefilemanager | link unlink | image",
            style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ],
            image_advtab: true ,
            external_filemanager_path: BASE_URL + "/filemanager/",
            filemanager_title: "HwCore Filemanager" ,
            external_plugins: { "filemanager" : BASE_URL + "filemanager/plugin.min.js"}
        });
        
        tinymce.init({
            selector: ".hw-mce-basic"
        });
        
        $(".hw-date").datepicker(
        {
            dateFormat: 'yy-mm-dd',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn'
            //,maxDate: '0d'
        }).keydown(false);
        
        $('.hw-tooltip').tooltip({position:{my: "center bottom-5",at: "center top"}}); // Setting jquery ui tooltip

        $('.hw-active').ajaxForm({
            dataType: 'JSON',
            type: 'POST',
            beforeSend: function(){
                Core.Loading.show();
            },
            success: function(response){
                if(response.status) {
                    Core.Loading.hide();
                }
            }
        });

        $('.hw-ajax').ajaxForm(
        {
            dataType: 'json',
            beforeSerialize : function(thisForm, options)
            {
                tinyMCE.triggerSave(true, true);
                
                Core.Loading.show();
                var hid = thisForm.find('[name="ajax_form"]');
                if(hid.length == 0)
                {
                    hid = $('<input type="hidden" name="ajax_form" />');
                    thisForm.append(hid);
                }
                
                if(thisForm.attr('model'))
                {
                    var hidModel = thisForm.find('[name="model"]');
                    if(hidModel.length == 0)
                    {
                        hidModel = $('<input type="hidden" name="model" value='+thisForm.attr('model')+' />');
                        thisForm.append(hidModel);
                    }
                }
            },
            success : function(response,status,hxr,thisForm)
            {
                Core.Loading.hide();
                
                if(response.redirect)
                {
                    window.location.href = response.redirect;
                }
                
                if(response.status == 'error')
                {
                    // Show global error
                    if(response.error)
                    {
                        var divError = thisForm.find('.flash_error');
                        if(divError.length == 0)
                        {
                            divError = $('<div class="flash_error">')
                        }
                        divError.html('<p>'+response.error+'</p>');
                        thisForm.prepend(divError);
                    }
                    
                    // Show detail error
                    if(response.errors)
                    {
                        if(response.plugin == 'Admin')
                        {
                            $('.error-message').remove();
                            $('.state-error').removeClass('state-error');
                            
                            $.each(response.errors, function(field,msg)
                            {
                                var input = $('[name="'+field+'"]');
                                var divError = $('<div>').insertAfter(input);
                                divError.addClass('error-message').text(msg);
                                input.parent().addClass('state-error');
                            });
                        }
                        else
                        {
                            
                            $('.error-message').remove();
                            $.each(response.errors, function(field,msg)
                            {
                                var input = $('[name="'+field+'"]');
                                var divError = $('<div>').insertAfter(input);
                                divError.addClass('error-message').text(msg);
                            });
                        }
                        
                    }
                }
                else if(response.status == 'success')
                {
                    location.reload();
                }
            }
        });

        // Init float overlay if not exist
        if($('#hw-floatbox-overlay').length == 0)
        {
            $('body').append('<div id="hw-floatbox-overlay">');
        }
        
        if($('#hw-loading').length == 0)
        {
            $('body').append('<div id="hw-loading"><img src ="'+BASE_URL+'img/core/hw-loading.gif" /></div>');
        }
        
        $('.onoffswitch-checkbox').click(function(){$(this).parents('form').submit();})
        
        
        /* ---------- Sort item { ---------- */
        $(".hw-sort").find('[data-id]').each(function(index, obj)
        {
            var dataID = $(obj).attr('data-id');
            $(obj).append('<input type = "hidden" name = "SortOrder[]" value = "'+dataID+'" />');
        });
        
        $(".hw-sort").sortable({
            items: ">*:not(.hw-sort-disabled)",
            helper: function (e, ui) 
            {
                ui.children().each(function () 
                {
                    $(this).width($(this).width());
                });
                return ui;
            },
            scroll: true,
            stop: function (event, ui) 
            {
                var form = $('#frmSort');
                if(form.length == 0)
                {
                    var container = $(this);
                    if($(this).is("tbody"))
                    {
                        container = container.parent();
                    }
                    
                    container.wrap('<form id="frmSort"></form>');
                    form = $('#frmSort');
                }

                $.ajax
                ({
                    type: "POST",
                    dataType: 'text',
                    url: '',
                    data: form.serialize(),
                    success: function(r) 
                    {
                        container.unwrap();
                    }
                });
            }
        }).disableSelection();
        /* ---------- Sort item } ---------- */
    },
    
    scrollTo:function(select)
    {
        $("body").animate({ scrollTop: $(select).offset().top }, "slow");
    },

    Form:
    {
        initFileDragDrop: function()
        {
            $('.hw-file-drag').each(function(index)
            {
                var dText = $(this).attr('text');
                if(!dText) dText = 'Drag & drop file here';
                var dHight = $(this).attr('height');
                if(!dHight) dHight = '50px';                      
                var container = $('<div>').addClass('hw-file-container').height(dHight);
                var text = $('<span>').html(dText);
                var overlay = $('<div>').addClass('hw-file-overlay').append(text);
                $(this).wrap(container);
                $('.hw-file-container').append(overlay);
            });
        },
        
        validateFile: function() 
        {
            if(IMAGE_FIELDS)
            {
                $.each(IMAGE_FIELDS, function(key, value) 
                {
                    var inputField = $('[name="'+key+'"]');
                    if (!inputField.length) {
                        return;
                    }
                    inputField.addClass('hw-file');
                    inputField.attr('type','file');

                    $.each(value, function(rule, param) {
                        switch (rule) {
                            case 'size':
                                inputField.attr('hw-size', param);
                                break;
                            case 'extensions':
                                inputField.attr('hw-type', param.join('|').toLowerCase());
                                break;
                            case 'required':
                                inputField.attr('hw-required', param?1:0);
                                break;
                            case 'multiple':
                                inputField.attr('hw-multiple', param?1:0);
                                inputField.attr('multiple', param);
                                break;
                        }
                    });
                });

                if (!$('.hw-file').length) 
                {
                    return;
                }

                $('[type="submit"]').click(function(event)
                {
                    var form = $(this).parents('form');
                    var errors = false;
                    form.find('[required="required"]').each(function ()
                    {
                        if ($(this).val().length < 1)
                        {
                            $(this).addClass('error');
                            errors = true;
                        }
                    });

                    if (errors == false)
                    {
                        form.attr('enctype','multipart/form-data');

                        var inputFiles = form.find('.hw-file');
                        inputFiles.each(function(i)
                        {
                            var inputFile = $(this);
                            var nameField = inputFile.attr('name');
                            var maxSize = parseInt(inputFile.attr('hw-size'));
                            var types = [];
                            if (typeof inputFile.attr('hw-type') != 'undefined') {
                                types = inputFile.attr('hw-type').toLowerCase().split('|');
                            }
                            var inputError = $('<input class="hw_file_errors" name="hw_file_errors['+nameField+']" type="hidden">');
                                inputError.insertBefore(inputFile);
                            var typeError = false;
                            var required = inputFile.attr('hw-required');

                            if (inputFile.val())
                            {
                                var files = this.files;
                                $.each(files, function(key, file) {
                                    if (file.size > maxSize)//validate size
                                    {
                                        typeError = FILE_ERROR_MAX_SIZE;
                                    }


                                    if (types.length) {//validate extension
                                        var fileName = file.name;
                                        var extension = fileName.substr( (fileName.lastIndexOf('.') +1) );
                                        if ($.inArray(extension.toLowerCase(), types) == -1)
                                        {
                                            typeError = FILE_ERROR_EXTENSION;
                                        }
                                    }
                                });
                            } else {
                                //validate required
                                if (parseInt(required) || inputFile.attr('required') == 'required') {
                                    typeError = FILE_ERROR_EMPTY;
                                }
                            }

                            if (typeError != false) {
                                inputError.val(typeError);
                                inputFile.attr('disabled', 'disabled');
                            }
                            if (inputFile.attr('hw-multiple') == 1) {
                                inputFile.attr('name', nameField+'_tmp[]');
                            } else {
                                inputFile.attr('name', nameField+'_tmp');
                            }
                        });
                    }
                });
            }
        },

        showImageWhenSelect: function() {
            var inputFiles = $('.hw-file');

            inputFiles.each(function() 
            {
                var input = $(this);
                
                var imgPrev = $(input.attr('preview'));
                if (imgPrev.length > 0) 
                {
                    //$('<div class="image-thumb-inputfile"></div>').insertBefore(input);
                    //var boxImage = input.prev();
                    
                    var boxImage = imgPrev;
                    input.unbind('change').change(function() {
                        boxImage.html(null);
                        if (this.files) {
                            $.each(this.files, function(key, currentFile) {
                                if (currentFile.type.indexOf('image') != -1) {

                                    var reader = new FileReader();
                                    reader.onload = function (e) {
                                        boxImage.append('<img style="'+imgPrev.attr('style')+'" src="'+ e.target.result+'" />');
                                    };
                                    reader.readAsDataURL(currentFile);
                                }
                            });
                        }
                    })
                }
            });
        },

        selectChosen: function() {
            $('select[hw-select="1"]').chosen();
        }
    },

    FloatBox:
    {
        /* id of floatbox */
        show:function(id,overlayClick)
        {
            if($('#'+id).find('#hw-floatbox-close').length == 0)
            {
                var btnClose = $('<a href="" onclick="Core.FloatBox.hide(\''+id+'\');return false;" id="hw-floatbox-close"><img src="'+BASE_URL+'img/core/hw-floatbox-close.png" /></a>');
                $('#'+id).append(btnClose);
            }
            
            if(overlayClick && overlayClick == true)
            {
                $("#hw-floatbox-overlay").unbind("click").click(function()
                {
                    Core.FloatBox.hide(id);
                });
            }
            else
            {
                $("#hw-floatbox-overlay").unbind("click");
            }

            $('#'+id).show();
            $('#hw-floatbox-overlay').show();
            $('#'+id).css({'top':($(window).scrollTop()+30)+'px'});
        },

        /* id of floatbox */
        hide:function(id)
        {
            $('.error-message').remove();
            $('#'+id + ' .flash_error').remove();
            $('#'+id).hide();
            $('#hw-floatbox-overlay').hide();
        },
        
        /* msg : Message to alert */
        alert:function(msg,callback)
        {
            
        },
        /* msg : Message to confirm */
        confirm:function(msg,callback)
        {
            
        }
    },

    ShowImage:
    {
        initFancybox: function() {
            var fancyboxLink = $('.fancybox');
            fancyboxLink.each(function() {
                $(this).fancybox();
            })
        },

        initDeleteImage: function() {
            var links = $('.hw-delete-link');
            links.each(function() {
                var urlDelete = $(this).attr('href');
                $(this).unbind('click').click(function(e) {
                    var nameField = $(this).attr('field');
                    var nameImage = $(this).attr('image');
                    var inputError = $('<input class="hw_file_errors" value="'+nameImage+'" name="hw_file_errors[delete]['+nameField+']" type="hidden">');
                    $(this).parents('form').prepend(inputError);
                    $(this).parents('.hw-image').fadeOut();
                    e.preventDefault();
                })
            })
        }
    },

    Loading:
    {
        show:function()
        {
            $('#hw-loading').show();
        },
        hide:function()
        {
            $('#hw-loading').hide();
        }
    },
    
    buildHasMany: function(data)
    {
        var itemIndex = 0;
        var container = $(data.option.container);
        var tmpItem = $(data.option.container+' :first-child').first();
        tmpItem.addClass('hw-hasmany-item');
        container.empty();
                
        $.each(data.entities,function(index,item)
        {
            itemIndex = index;
            var newItem = tmpItem.clone();
            var arrInput = newItem.find('[name]');
            
            // Generate hidden field
            var hidField = $('<input>').attr('type','hidden').attr('name',data.name+'['+index+'][id]').val(item['ent']['id']);
            newItem.append(hidField);
            
            $.each(arrInput,function(subIndex,input)
            {
                var fieldName = $(input).attr('name');
                $(input).attr('name',data.name+'['+index+']['+fieldName+']');
                
                if($(input).attr('type') == 'checkbox') // Specific for Cake 3
                {
                    $(input).val(1);
                    $(input).parent().parent().prev('[type="hidden"]').val(0);
                    if(item['ent'][fieldName]) $(input).attr('checked',true);
                }
                else
                {
                    $(input).val(item['ent'][fieldName]);
                }
                
                $.each(item['errors'], function(field,msg)
                {
                    if(fieldName == field)
                    {
                        if(data.plugin == 'Admin')
                        {
                            var divError = $('<div>').insertAfter(input);
                            divError.addClass('error-message').text(msg);
                            $(input).parent().addClass('state-error');
                        }
                        else
                        {
                            var divError = $('<div>').insertAfter($(input));
                            divError.addClass('error-message').text(msg);
                        }
                    }
                });
                
            });
            
            container.append(newItem);
        });
        
        $(data.option.add).click(function() 
        {
            itemIndex++;
            
            var newItem = tmpItem.clone();
            var arrInput = newItem.find('[name]');
            
            // Set new index for input
            $.each(arrInput,function(subIndex,input)
            {
                var fieldName = $(input).attr('name');
                $(input).attr('name',data.name+'['+itemIndex+']['+fieldName+']');
                
                if($(input).attr('type') == 'checkbox') // Specific for Cake 3
                {
                    $(input).val(1);
                    $(input).prev('[type="hidden"]').val(0);
                }
                else
                {
                    $(input).val('');
                }
            });
            
            // Set event for delete button
            newItem.find(data.option.delete).click(function() 
            {
                $(this).closest('.hw-hasmany-item').remove();
                return false;
            });
            
            container.append(newItem);
            return false;
        });
        
        $(data.option.delete).click(function() 
        {
            $(this).closest('.hw-hasmany-item').remove();
            return false;
        });
    },
    
    buildAjaxMore : function(option)
    {
        $(option.link).attr('hw-model',option.model);
        $(option.link).attr('hw-element',option.element);
        $(option.link).attr('hw-page',option.page);
        $(option.link).attr('hw-page-count',option.pageCount);
        
        if(option.page == option.pageCount)
        {
            $(option.link).css('display','none');
        }
        
        $(option.link).click(function() 
        {
            var page = $(this).attr('hw-page');page++;
            var pageCount = $(this).attr('hw-page-count');
            
            var model = $(this).attr('hw-model');
            var element = $(this).attr('hw-element');                        
            var requestUrl = window.location.href + '?page='+page + '&ajax_more&model='+model+'&element='+element;
            
            $(option.link).addClass('disabled');
            $(option.link).attr('disabled',true);
            
            $.ajax
            ({
                type: "GET",
                dataType: 'text',
                contentType: 'json',
                url: requestUrl,
                success: function(r) 
                {
                    $(option.link).removeClass('disabled');
                    $(option.link).attr('disabled',false);
                    if(page == pageCount)
                    {
                        $(option.link).css('display','none');
                    }
                    $(option.link).attr('hw-page',page);
                    $(option.container).append(r);
                }
            });
            return false;
        });
    },
    
    buildAjaxSelect : function(option)
    {
        $.each(option, function(index, item)
        {
            // Bind data
            $.each(item.data, function(key, value) 
            {
                var opt = $('<option>').attr("value",key).text(value);
                if(item.currentValue == key) opt.attr('selected','selected');
                $(item.select).append(opt);
            });
            
            // Ajax child
            if (typeof option[index+1] != 'undefined') 
            {
                var childSelect = option[index+1]['select'];
                var childModel = option[index+1]['model'];
                var childKeyField = option[index+1]['keyField'];
                var childValueField = option[index+1]['valueField'];
                var childParentField = option[index+1]['parentField'];
                
                $(item.select).change(function() 
                {
                    var parentValue = $(this).val();
                    
                    if(parentValue)
                    {
                        var curPlugin = (CUR_PLUGIN) ? CUR_PLUGIN+'/':'';
                        $.get(BASE_URL + curPlugin + CUR_CONTROLER + '/ajax_get_select_child_items/' + childModel + '/' + childParentField + '/' + parentValue + '/' + childKeyField + '/' + childValueField ,function(data)
                        {
                            // Bind data to child
                            var firstItem = $(childSelect).find('option').first();
                            $(childSelect).empty();
                            $(childSelect).append(firstItem);

                            data = $.parseJSON(data)
                            $.each(data, function(key, value) 
                            {
                                $(childSelect).append($("<option></option>").attr("value",key).text(value)); 
                            });
                        });
                    }
                    else
                    {
                        var updateChild = false;
                        $.each(option, function(index, item2)
                        {
                            // Update all child to null
                            if(updateChild)
                            {
                                var tmpItem = $(item2.select).find('option').first();
                                $(item2.select).empty();
                                $(item2.select).append(tmpItem);
                            }
                            
                            if(item.select == item2.select) updateChild = true;
                        });
                    }
                });
            }
        });
    },
    
    gmap : function(alias)
    {
        return {
            init : function(editMode)
            {
                function initMap()
                {
                    if(!window.gmap) window.gmap = {}; gmap[alias] = {};
                    if (!window.geocoder) geocoder = new google.maps.Geocoder();
                    
                    // Get hidden object
                    gmap[alias].hidden = {};
                    if($('[name='+alias+'_lat]').length >= 1) gmap[alias].hidden.lat = $('[name='+alias+'_lat]');
                    if($('[name='+alias+'_lng]').length >= 1) gmap[alias].hidden.lng = $('[name='+alias+'_lng]');
                    if($('[name='+alias+'_zoom]').length >= 1) gmap[alias].hidden.zoom = $('[name='+alias+'_zoom]');
                    if($('[name='+alias+'_icon_tmp]').length >= 1) gmap[alias].hidden.icon = $('[name='+alias+'_icon_tmp]');
                    
                    // Set default value
                    var lat = (gmap[alias].hidden.lat.val())?gmap[alias].hidden.lat.val():21.004344600768427;
                    var lng = (gmap[alias].hidden.lng.val())?gmap[alias].hidden.lng.val():105.79785133135226;
                    var zoom = (gmap[alias].hidden.zoom.val())? parseInt(gmap[alias].hidden.zoom.val()):16;
                    var myLatlng = new google.maps.LatLng(lat,lng);
                    
                    gmap[alias].map = new google.maps.Map(document.getElementById(alias),
                    {
                        zoom: zoom,
                        center: myLatlng,
                        mapTypeId: google.maps.MapTypeId.HYBRID
                    });
                    
                    Core.gmap(alias).showMarker(editMode);
                }
                                
                google.maps.event.addDomListener(window, 'load', initMap);
            },
            
            initMultiple : function(urlData)
            {
                function initMap()
                {
                    if(!window.gmap) window.gmap = {}; gmap[alias] = {};
                    if (!window.geocoder) geocoder = new google.maps.Geocoder();
                    
                    jQuery.ajax
                    ({
                        dataType: 'json',
                        url: urlData,
                        success: function(data) 
                        {
                            // Show map
                            gmap[alias].map = new google.maps.Map(document.getElementById(alias),
                            {
                                zoom: 10,
                                mapTypeId: google.maps.MapTypeId.HYBRID
                            });
                                                        
                            // Show markers
                            gmap[alias].marker = {};
                            
                            var count = 0;
                            var totalLat = 0;
                            var totalLng = 0;
                            
                            $.each(data, function(index,obj)
                            {
                                var position = new google.maps.LatLng(obj[alias+'_lat'],obj[alias + '_lng']);
                                gmap[alias].marker[obj.id] = new google.maps.Marker({
                                    position: position,
                                    map: gmap[alias].map,
                                    animation: google.maps.Animation.DROP,
                                    icon: obj[alias+'_icon']
                                });
                                
                                count++;
                                totalLat += parseFloat(obj[alias+'_lat']);
                                totalLng += parseFloat(obj[alias+'_lng']);
                            });
                            
                            var avgLat = totalLat / count;
                            var avgLng = totalLng / count;
                            gmap[alias].map.setCenter(new google.maps.LatLng(avgLat, avgLng));
                            
                            /* ---------- Set to current user location { ---------- */
                            // Try W3C Geolocation (Preferred)
                            if(navigator.geolocation) 
                            {
                                browserSupportFlag = true;
                                navigator.geolocation.getCurrentPosition(function(position) 
                                {
                                    initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
                                    gmap[alias].map.setCenter(initialLocation);
                                }, function() 
                                {
                                    handleNoGeolocation(browserSupportFlag);
                                });
                            }
                            // Browser doesn't support Geolocation
                            else 
                            {
                                browserSupportFlag = false;
                                handleNoGeolocation(browserSupportFlag);
                            }
                            /* ---------- Set to current user location } ---------- */
                        }
                    });
                }

                google.maps.event.addDomListener(window, 'load', initMap);
            },
            
            showMarker : function(drag)
            {
                drag = Boolean(drag);
                var position = gmap[alias].map.getCenter();
                var draggable = (drag) ? drag : false;
                var icon = (draggable != true)?gmap[alias].hidden.icon.val():null;
                
                if(gmap[alias].marker)
                {
                    gmap[alias].marker.setMap(gmap[alias].map);
                    gmap[alias].marker.setPosition(position);
                }
                else
                {
                    gmap[alias].marker = new google.maps.Marker({
                        position: position,
                        map: gmap[alias].map,
                        animation: google.maps.Animation.DROP,
                        draggable: draggable,
                        icon : icon
                    });

                    if(draggable)
                    {
                        google.maps.event.addListener(gmap[alias].marker, 'dragend', function() 
                        {
                            gmap[alias].hidden.lat.val(gmap[alias].marker.getPosition().lat());
                            gmap[alias].hidden.lng.val(gmap[alias].marker.getPosition().lng());
                            gmap[alias].hidden.zoom.val(gmap[alias].map.getZoom());
                        });
                        
                        gmap[alias].map.addListener('click', function(evt) 
                        {
                            gmap[alias].marker.setPosition(evt.latLng);
                            gmap[alias].hidden.lat.val(gmap[alias].marker.getPosition().lat());
                            gmap[alias].hidden.lng.val(gmap[alias].marker.getPosition().lng());
                            gmap[alias].hidden.zoom.val(gmap[alias].map.getZoom());
                        });
                    }
                }
            },
            
            gotoAddress: function (address,callback)
            {
                geocoder.geocode( {'address': address}, function(results, status) 
                {
                    if (status == google.maps.GeocoderStatus.OK) 
                    {
                        gmap[alias].map.setCenter(results[0].geometry.location);
                    }
                    
                    if(callback) callback(status);
                });
            }
        };
    }
    
};

$(document).ready(function()
{
    Core.init();
    Core.Form.validateFile();
    Core.Form.selectChosen();
    Core.Form.showImageWhenSelect();
    Core.Form.initFileDragDrop();
    Core.ShowImage.initFancybox();
    Core.ShowImage.initDeleteImage();
});