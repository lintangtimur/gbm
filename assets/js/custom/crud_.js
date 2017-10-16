/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * @author : Warman Suganda
 * @description : crud plugin
 * @lasedit : 11/03/2014
 */

/* Begin : Custom Table */
function load_table(id, page, callback) {
    var content = '&nbsp;';
    var link = $(id).attr('data-source');
    var data = {};
    var temp_id = $(id).attr('id');
    var filter = $(id).attr('data-filter');
    var pagination = $(id).attr('pagination');
    var st_paging = 'true';

    if (typeof filter !== 'undefined') {
//        $(filter).submit(function() {
//            return false;
//        });
        data = $(filter).serialize();
        tools_filter(filter, id, callback);
    }

    if (typeof pagination !== 'undefined') {
        st_paging = pagination;
    }

    $(id).html(content).addClass('loading-progress');
    $.post(link + '/' + page, data, function(res) {
        var xhr = xhr_result();
        content = generate_table(xhr);

        content += '<div id="pp-' + temp_id + '"></div>';
        $(id).removeClass('loading-progress').html(content);

        if (st_paging === 'true') {
            $('#pp-' + temp_id).pagination({
                pageNumber: parseInt(xhr.page),
                total: parseInt(xhr.total),
                pageSize: parseInt(xhr.limit),
                onSelectPage: function(pageNumber) {
                    load_table(id, pageNumber, callback);
                },
                showPageList: false
            });
        }
        if ($.isFunction(callback)) {
            callback();
        }

    }, 'script');
}

function generate_table(obj) {
    var table = '';
    var style = '';
    var jumlah_kolom = obj.jumlah_kolom;
    var t_id = '';
    var ordering_key = '';

    //kalo ordering nya true tambah dialog box ordering
    if (obj.ordering === true)
    {
        if (obj.ordering_key)
        {
            ordering_key = '_' + obj.ordering_key;
        }
        //dialog box ordering
        table += '<div class="alert alert-info" id="ordering_dialog_box' + ordering_key + '" style="display:none;"><center>';
        table += 'Apakah anda ingin menyimpan urutan?<br/>';
        table += '<button onClick="save_ordering()" class="save_ordering dark_green btn-small btn" type="button">Yes</button>';
        table += '<button onClick="cancel_ordering()" class="cancel_ordering yellow btn-small btn" type="button">No</button><br/>';
        table += '</center></div>';

        //loading ordering
        table += '<div id="loading_ordering' + ordering_key + '" class="loading-progress" style="display: none;"></div>';

        //js ordering
        table += '<script>';
        table += 'jQuery(function($) {';
        table += '$(".table_ordering' + ordering_key + '").tableDnD({';
        table += '  onDragStart: function(table, row) {';
        table += '       $("#ordering_dialog_box' + ordering_key + '").fadeIn("slow");';
        table += '   },';
        table += '   onDrop: function(table, row) {';
        table += '      var rows = table.tBodies[0].rows; ';
        table += '      var n = $("input.row_ordering' + '_' + obj.ordering_key + '").filter(function(index) {';
        table += '          return $(this).attr("name") == rows[0].id;';
        table += '       }).val() - 1;';
        table += '      var j = 1;';
        table += '      for (var i=0; i<rows.length; i++) {';
        table += '          var new_order = j; ';
        table += '          if(rows[i].className == "urutkan"){';
        table += '              $("input.row_ordering' + '_' + obj.ordering_key + '").filter(function(index) {';
        table += '                  return $(this).attr("name") == rows[i].id;';
        table += '              }).val(new_order);';
        table += '              $("td.row_numbering' + '_' + obj.ordering_key + '").filter(function(index) {';
        table += '                  return $(this).attr("id") == rows[i].id;';
        table += '             }).html(new_order);';
        table += '              j++;';
        table += '          }}}});';
        table += '});';

        var module = $('#content_table').attr('data-module');
        table += ' function save_ordering(){';
        table += '  $("#ordering_dialog_box' + ordering_key + '").fadeOut("slow");';
        table += '  $("#loading_ordering' + ordering_key + '").fadeIn("slow");';
        table += '  var fields = $(".row_ordering' + '_' + obj.ordering_key + '").serializeArray();';
        table += '   $.post( "' + module + '/urutkan", {';
        table += '      page: $(".active_page").attr("id"),';
        table += '     ordering: fields';
        table += ' }, function (data) {';
        table += '      bootbox.alert(data.message);';
        table += '     load_table("#content_table' + ordering_key + '", 1, "#ffilter' + ordering_key + '");';
        table += ' },"json");};';

        table += 'function cancel_ordering(){';
        table += '   $("#ordering_dialog_box' + ordering_key + '").fadeOut("slow");';
        table += '  $("#loading_ordering' + ordering_key + '").fadeIn("slow");';
        table += ' load_table("#content_table' + ordering_key + '", 1, "#ffilter' + ordering_key + '");};';

        table += '</script>';
    }

    if (typeof obj.id !== 'undefined') {
        t_id = 'id="' + obj.id + '"';
    }

    if (typeof obj.style !== 'undefined') {
        style = obj.style;
    }

    table += '<table ' + t_id + ' class="' + style;

    //kalo ordering nya true kasih class table_ordering
    if (obj.ordering === true)
    {
        table += ' table_ordering' + ordering_key;
    }

    table += '">';

    // create header
    table += '<thead>';

    $.each(obj.header, function(idx, h_row) {
        table += '  <tr';

        //kalo ordering nya true kasih class supaya si header row kaga bisa di geser2
        if (obj.ordering === true)
        {
            table += ' class="nodrop nodrag"';
        }

        table += '>';


        var idx_colspan = 1;
        var idx_rowspan = 2;
        for (var i = 0; i < h_row.length; i += 3) {
            var h_text = h_row[i];
            var h_colspan = '';
            var h_rowspan = '';

            if (h_row[idx_colspan] > 1)
                h_colspan = 'colspan="' + h_row[idx_colspan] + '"';
            if (h_row[idx_rowspan] > 1)
                h_rowspan = 'rowspan="' + h_row[idx_colspan] + '"';

            table += '  <th ' + h_colspan + ' ' + h_rowspan + ' >' + h_text + '</th>';
            idx_colspan += 3;
            idx_rowspan += 3;
        }

        table += '  </tr>';
    });
    table += '</thead>';

    // create content
    table += '<tbody>';

    if (obj.total > 0) {
        $.each(obj.content, function(idx_row, c_row) {
//            table += '  <tr id="content_row_'+idx_row+'" '; //old
            table += '  <tr id="' + idx_row + '" ';

            //kalo ordering nya true kasih class urutkan supaya bisa di geser2
            if (obj.ordering === true)
            {
                table += ' class="urutkan"';
            }
            table += '>';

            $.each(c_row, function(idx_col, c_text) {
                if (idx_col !== 'key') {
                    var c_align = '';
                    var c_valign = '';

                    if (typeof obj.align[idx_col] !== 'undefined')
                        c_align = 'align="' + obj.align[idx_col] + '"';
                    if (typeof obj.valign[idx_col] !== 'undefined')
                        c_valign = 'valign="' + obj.valign[idx_col] + '"';

                    if (c_text === null) {
                        c_text = '';
                    }

                    table += '<td ' + c_align + ' ' + c_valign + '>' + c_text + '</td>';
                }
            });
            table += '  </tr>';
            if (obj.drildown === true) {
                table += '<tr class="nodrop nodrag hide" id="drildown_row_' + obj.id + '_' + idx_row + '" status="close"><td style="background-color:#fff!important;" colspan="' + jumlah_kolom + '"></td></tr>';
            }
        });
    } else {
        table += '  <tr><td class="nodrop nodrag" align="center" colspan="' + jumlah_kolom + '"> ' + obj.message + ' </td></tr>';
    }

    table += '</tbody>';

    table += '</table>';
    return table;
}
/* End : Custom Table */


/* Begin : Custom Form */
window.status_modal = false;
window.form_content_modal = '#form-content';
window.form_content_main = '#index-content';
/*
 * Class yang digunakan class="modal fade modal-xlarge"
 */
function load_form_modal(button, content) {
    window.status_modal = true;

    var content_id = window.form_content_modal;
    if (typeof content !== 'undefined') {
        content_id = content;
    }

    var id = '#' + button;
    if (typeof $(id).attr('disabled') === 'undefined') {
        var source = $(id).attr('data-source');
        disabled_html([id], true);

        $(content_id).html('').addClass('loading-progress').modal({
            "backdrop": "static",
            "keyboard": true,
            "show": true
        }).load(source, function() {
            $(this).removeClass('loading-progress');
            disabled_html([id], false);
        });
    }
}

/*
 * Class yang digunakan class="well-content"
 */
function load_form(button, content) {
    window.status_modal = false;
    var id = '#' + button;
    if (typeof $(id).attr('disabled') === 'undefined') {
        var source = $(id).attr('data-source');
        disabled_html([id], true);

        var content_id = window.form_content_modal;
        if (typeof content !== 'undefined') {
            content_id = content;
        }

        $('#index-content').hide();
        $(content_id).show().html('').addClass('loading-progress').load(source, function() {
            $(this).removeClass('loading-progress');
            disabled_html([id], false);
        });
    }
}

function close_form(button, content, main) {
    if (typeof $('#' + button).attr('disabled') === 'undefined') {

        var id_content = window.form_content_modal;
        var id_main = window.form_content_main;

        if (typeof content !== 'undefined')
            id_content = content;
        if (typeof main !== 'undefined')
            id_main = main;

        $(id_main).show();
        $(id_content).hide().html('&nbsp;');
    }
}

function close_form_modal(button, content) {
    if (typeof $('#' + button).attr('disabled') === 'undefined') {
        var content_id = window.form_content_modal;
        if (typeof content !== 'undefined') {
            content_id = content;
        }
        $(content_id).modal('hide');
        window.status_modal = false;
    }
}

function simpan_data(button, form, disable, content) {
    if (typeof $('#' + button).attr('disabled') === 'undefined') {

        bootbox.setBtnClasses({
            CANCEL: '',
            CONFIRM: 'blue'
        });

        var conf = $(form).attr('data-confirm');
        var conf_message = conf;
        var conf_tinymce = $(form).attr('data-tinymce');

        if (typeof conf === 'undefined') {
            conf_message = 'Anda yakin akan menyimpan data?';
        }

        bootbox.confirm(conf_message, "Tidak", "Ya", function(e) {
            if (e) {

                var disabled_list = disable.split('|');
                disabled_list.push('#' + button);
                disabled_html(disabled_list, true);

                bootbox.modal('<div class="loading-progress"></div>');

                if (typeof conf_tinymce !== 'undefined' && conf_tinymce === 'true') {
                    tinyMCE.triggerSave();
                }

                $(form).ajaxSubmit({
                    beforeSubmit: function(a, f, o) {
                        o.dataType = 'json';
                    },
                    success: function(res) {
                        var message = '';
                        var icon = 'icon-remove-sign';
                        var color = '#ac193d;';
                        var content_id = res[3];

                        if (res[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }

                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + res[1] + '</div>';
                        message += res[2];

                        $(".bootbox").modal("hide");
                        disabled_html(disabled_list, false);
                        bootbox.alert(message, function() {

                            if (isValidURL(content_id)) {
                                window.location = content_id;
                            } else {
                                if (typeof content_id !== 'undefined' && content_id !== '') {
                                    var patt = /^#/;

                                    if (patt.test(content_id)) {

                                        if (window.status_modal) {
                                            var form_content_id = window.form_content_modal;

                                            if (typeof content !== 'undefined')
                                                form_content_id = content;

                                            close_form_modal('', form_content_id);
                                        } else {
                                            close_form();
                                        }

                                        load_table(content_id, 1);
                                    } else {

                                        if (window.status_modal) {
                                            var form_content_id = window.form_content_modal;

                                            if (typeof content !== 'undefined')
                                                form_content_id = content;

                                            close_form_modal('', form_content_id);
                                        } else {
                                            close_form();
                                        }

                                        eval('(' + content_id + ')');
                                    }
                                }
                            }
                        });
                    }
                });
            }
        });
    }
}

/*
 * Fungsi untuk mendisabled tag HTML
 * Parameter :
 *      1. id, diisi dengan id tag HTML
 *         Contoh : #idtaghtml
 *      2. status, (boolean)
 *         Contoh : true/false (Jika true maka tag HTML akan didisabeld)
 */

function disabled_html(id, status) {
    $(id).each(function(idx, val) {
        if (status) {
            $(val).attr('disabled', 'disabled');
        } else {
            $(val).removeAttr('disabled');
        }
    });
}

/*
 * Funngsi untuk menghapus data row
 * Parameter :
 *      1. id, diisi dengan id anchor/button
 *         Contoh : karena fungsi ini disimpan pada action onclick anchor/button, jadi untuk menggunakan
 *                  funsi ini yaitu delete_row(this.id)
 * Deskripsi :
 *      1. link, diambil dari attribut data-source anchor/button
 *         Contoh : <a href="javascript:void(0)" id="idtarget" data-source="http://localhost/namacontroler/fungsidelete"> .... </a>
 */
function delete_row(id, modal) {
    var temp_id = '#' + id;
    var link = $(temp_id).attr('data-source');
    bootbox.setBtnClasses({
        CANCEL: '',
        CONFIRM: 'red'
    });
    bootbox.confirm('Anda yakin akan menghapus data?', "Tidak", "Ya", function(e) {
        if (e) {
            disabled_html([temp_id], true);
            bootbox.modal('<div class="loading-progress"></div>');
            $.post(link, function(res) {
                var message = '';
                var icon = 'icon-remove-sign';
                var color = '#ac193d;';
                var content_id = res[3];

                if (res[0]) {
                    icon = 'icon-ok-sign';
                    color = '#0072c6;';
                }

                message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + res[1] + '</div>';
                message += res[2];

                $(".bootbox").modal("hide");
                disabled_html(temp_id, false);
                bootbox.alert(message, function() {
                    if (isValidURL(content_id)) {
                        window.location = content_id;
                    } else {
                        if (typeof content_id !== 'undefined' && content_id !== '') {
                            var patt = /^#/;

                            if (patt.test(content_id)) {
								if(modal != 'undefined' && modal == true){
									if (window.status_modal) {
	                                    var form_content_id = window.form_content_modal;

	                                    if (typeof content !== 'undefined')
	                                        form_content_id = content;

	                                    close_form_modal('', form_content_id);
	                                } else {
	                                    close_form();
	                                }	
								}
                                load_table(content_id, 1);
                            } else {

                                if(modal != 'undefined' && modal == true){
									if (window.status_modal) {
	                                    var form_content_id = window.form_content_modal;

	                                    if (typeof content !== 'undefined')
	                                        form_content_id = content;

	                                    close_form_modal('', form_content_id);
	                                } else {
	                                    close_form();
	                                }	
								}

                                eval('(' + content_id + ')');
                            }
                        }
                    }
                });
            }, 'json');
        }
    });
}

function confirm_dialog_ajax(id) {
    var temp_id = '#' + id;
    var link = $(temp_id).attr('data-source');
    var msg = $(temp_id).attr('data-message');
    bootbox.setBtnClasses({
        CANCEL: '',
        CONFIRM: 'red'
    });
    bootbox.confirm(msg, "Tidak", "Ya", function(e) {
        if (e) {
            disabled_html([temp_id], true);
            bootbox.modal('<div class="loading-progress"></div>');
            $.post(link, function(res) {
                var message = '';
                var icon = 'icon-remove-sign';
                var color = '#ac193d;';
                var content_id = res[3];

                if (res[0]) {
                    icon = 'icon-ok-sign';
                    color = '#0072c6;';
                }

                message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + res[1] + '</div>';
                message += res[2];

                $(".bootbox").modal("hide");
                disabled_html(temp_id, false);
                bootbox.alert(message, function() {
                    if (isValidURL(content_id)) {
                        window.location = content_id;
                    } else {
                        if (typeof content_id !== 'undefined' && content_id !== '') {
                            var patt = /^#/;

                            if (patt.test(content_id)) {

                                if (window.status_modal) {
                                    var form_content_id = window.form_content_modal;

                                    if (typeof content !== 'undefined')
                                        form_content_id = content;

                                    close_form_modal('', form_content_id);
                                } else {
                                    close_form();
                                }

                                load_table(content_id, 1);
                            } else {

                                if (window.status_modal) {
                                    var form_content_id = window.form_content_modal;

                                    if (typeof content !== 'undefined')
                                        form_content_id = content;

                                    close_form_modal('', form_content_id);
                                } else {
                                    close_form();
                                }

                                eval('(' + content_id + ')');
                            }
                        }
                    }
                });
            }, 'json');
        }
    });
}
/* End : Custom Form */


/* Begin : Custom Drildown */
window.drildown_key = 'drildown_key_';
function drildown(key, refresh, table) {
    if (key === '')
        alert('Primary key tidak terdefinisi');
    else {
        var id;
        var source;
        var $drildown;

        if (typeof refresh !== '' && refresh === true) {
            id = $('#' + window.drildown_key + table + '_' + key).attr('rel');
            source = $('#' + window.drildown_key + table + '_' + key).attr('data-source');

            $drildown = $('#drildown_row_' + table + '_' + id);

            $drildown.attr('status', 'open');
            $drildown.children('td').html('<div id="drildown_content_' + table + '_' + id + '"><div class="loading-progress"></div></div>');
            $('#drildown_content_' + table + '_' + id).load(source, {id: id});
        } else {
            id = $('#' + key).attr('rel');
            source = $('#' + key).attr('data-source');
            table = $('#' + key).attr('parent');
            $drildown = $('#drildown_row_' + table + '_' + id);
            var st_toggle = $drildown.attr('status');
            $drildown.toggle();
            if (st_toggle === 'close') {
                $drildown.attr('status', 'open');
                $drildown.children('td').html('<div id="drildown_content_' + table + '_' + id + '"><div class="loading-progress"></div></div>');
                $('#drildown_content_' + table + '_' + id).load(source, {id: id});
            } else {
                $drildown.attr('status', 'close');
            }
        }
    }
}
/* End : Custom Drildown */

/* Begin : Custom Other */
/*
 * Fungsi untuk mengambil data option dengan ajax 
 * Parameter :
 *      1. target, diisi dengan ID select 
 *         Contoh : #idtaget
 *      2. data, diisi dengan data filter yang berupa object
 *         Contoh : {kode : '1', selected : '12'}
 *      3. chosen, diisi dengan status bootsrap chosen (boolean)
 *         Contoh : true/false (Jika true berarti select mengganan bootsrap chosen)
 * Deskripsi :
 *      1. link, diambil dari attribut data-source target
 *         Contoh : <select id="idtarget" data-source="http://localhost/namacontroler/get_data_option"> .... </select>
 */
function get_options(target, data, chosen, type) {
    var st_chosen = false;

    if (typeof chosen !== 'undefined')
        st_chosen = chosen;

    var link = $(target).attr('data-source');
    $.post(link, data, function(res) {
        if (typeof type === 'undefined' || type === 'options') {
            var list_option = res;
            $(target).html(generate_option(list_option));
            if (st_chosen)
                $(target).trigger('liszt:updated');
        } else {
            $(target).val(res);
        }
    }, 'json');
}

function generate_option(list, selected) {
    var option = '';
    $.each(list, function(key, value) {
        var sel = '';
        if (typeof selected !== 'undefined' && selected === value) {
            sel = 'selected="selected"';
        }

        option += '<option value="' + key + '" ' + sel + '>' + value + '</option>';
    });
    return option;
}

function select_all(id) {
    var target = $('#' + id).attr('target-selected');
    if ($('#' + id).is(':checked')) {
        $('.' + target).prop('checked', true);
    } else {
        $('.' + target).prop('checked', false);
    }
}

function isValidURL(url) {
    var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

    if (RegExp.test(url)) {
        return true;
    } else {
        return false;
    }
}

function config_tabs_ajax(id, init) {
    var default_tab = $(id).children('li.active').children('a');
    var default_content = default_tab.attr('href');
    var default_url = default_tab.attr('data-source');

    $(default_content).html('<div class="loading-progress"></div>').load(default_url, function() {
        $(id).tab();
    });

    if (typeof init === 'undefined' || init === true) {
        $(id).bind('show', function(e) {
            var pattern = /#.+/gi
            var contentID = e.target.toString().match(pattern)[0];
            var url = $('a[href=' + contentID + ']').attr('data-source');

            $(contentID).html('<div class="loading-progress"></div>').load(url, function() {
                $(id).tab();
            });
        });
    }
}

/* Org Cart */
function Setup(selector) {
    var config = GetOrgDiagramConfig();
//    config.templates = [getCursorTemplate()];
    config.cursorItem = 0;
    config.templates = [getContactTemplate()];
    config.onItemRender = onTemplateRender;
    config.defaultTemplateName = "customControlTemplate";

    return selector.orgDiagram(config);
}

function Update(selector, updateMode) {
    selector.orgDiagram("option", GetOrgDiagramConfig());
    selector.orgDiagram("update", updateMode);
}

function GetOrgDiagramConfig() {

    return {
        normalLevelShift: 20,
        dotLevelShift: 10,
        lineLevelShift: 10,
        normalItemsInterval: 20,
        dotItemsInterval: 15,
        lineItemsInterval: 5,
        hasSelectorCheckbox: primitives.common.Enabled.False,
        leavesPlacementType: primitives.common.ChildrenPlacementType.Matrix,
        hasButtons: primitives.common.Enabled.False,
        itemTitleFirstFontColor: primitives.common.Colors.White,
        itemTitleSecondFontColor: primitives.common.Colors.White,
        labelSize: new primitives.common.Size(10, 20),
        labelPlacement: primitives.common.PlacementType.Top,
        labelOffset: 3
    };
}

function getCursorTemplate() {
    var result = new primitives.orgdiagram.TemplateConfig();
    result.name = "CursorTemplate";

    result.itemSize = new primitives.common.Size(120, 100);
    result.minimizedItemSize = new primitives.common.Size(3, 3);
    result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
    result.cursorPadding = new primitives.common.Thickness(3, 3, 50, 8);

    var cursorTemplate = jQuery("<div></div>")
            .css({
                position: "absolute",
                overflow: "hidden",
                width: (result.itemSize.width + result.cursorPadding.left + result.cursorPadding.right) + "px",
                height: (result.itemSize.height + result.cursorPadding.top + result.cursorPadding.bottom) + "px"
            });

    var cursorBorder = jQuery("<div></div>")
            .css({
                width: (result.itemSize.width + result.cursorPadding.left + 1) + "px",
                height: (result.itemSize.height + result.cursorPadding.top + 1) + "px"
            }).addClass("bp-item bp-corner-all bp-cursor-frame");
    cursorTemplate.append(cursorBorder);

    var bootStrapVerticalButtonsGroup = jQuery("<div></div>")
            .css({
                position: "absolute",
                overflow: "hidden",
                top: result.cursorPadding.top + "px",
                left: (result.itemSize.width + result.cursorPadding.left + 10) + "px",
                width: "35px",
                height: (result.itemSize.height + 1) + "px"
            }).addClass("btn-group btn-group-vertical");

    bootStrapVerticalButtonsGroup.append('<button class="btn btn-small" data-buttonname="info" type="button"><i class="icon-info-sign"></i></button>');
    bootStrapVerticalButtonsGroup.append('<button class="btn btn-small" data-buttonname="edit" type="button"><i class="icon-edit"></i></button>');
    bootStrapVerticalButtonsGroup.append('<button class="btn btn-small" data-buttonname="remove" type="button"><i class="icon-remove"></i></button>');
    bootStrapVerticalButtonsGroup.append('<button class="btn btn-small" data-buttonname="user" type="button"><i class="icon-user"></i></button>');

    cursorTemplate.append(bootStrapVerticalButtonsGroup);

    result.cursorTemplate = cursorTemplate.wrap('<div>').parent().html();

    return result;
}

function LoadItems(selector) {

    var items = [];
    var link = selector.attr('data-source');
    $.get(link, {}, function(out) {
        $.each(out, function(idx, val) {
            items.push(new primitives.orgdiagram.ItemConfig(val));
        });

        selector.orgDiagram("option", {
            items: items,
            cursorItem: 0
        });
        selector.orgDiagram("update");
    }, 'json');


}

function getContactTemplate() {
    var result = new primitives.orgdiagram.TemplateConfig();
    result.name = "customControlTemplate";

    result.itemSize = new primitives.common.Size(174, 83);
    result.minimizedItemSize = new primitives.common.Size(3, 3);
    result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);


    var itemTemplate = jQuery(
            '<div class="bp-item">'
            + '<div name="title" class="bp-item" style="top: 3px; left: 6px; width: 162px; height: 55px; text-align:center;  line-height:14px; font-weight:bold;border-bottom:1px dotted #000;"></div>'
            + '<div name="description" class="bp-item" style="top: 33px; left: 6px; width: 162px; height: 35px; font-size: 10px; line-height:12px; text-align:center;" ></div>'
            + '<div name="kuota" class="bp-item" style="top: 65px; left: 6px; width: 162px; height: 35px; font-size: 12px; line-height:12px; text-align:left;" ></div>'
            + '<div name="total" class="bp-item" style="top: 65px; left: 6px; width: 162px; height: 35px; font-size: 12px; line-height:12px; text-align:right;" ></div>'
            + '</div>'
            ).css({
        width: result.itemSize.width + "px",
        height: result.itemSize.height + "px"
    }).addClass("bp-item bp-corner-all bt-item-frame");
    result.itemTemplate = itemTemplate.wrap('<div>').parent().html();

    return result;
}

function onTemplateRender(event, data) {
    var itemConfig = data.context;

    var fields = ["title", "description", "kuota", "total"];
    for (var index = 0; index < fields.length; index++) {
        var field = fields[index];

        var element = data.element.find("[name=" + field + "]");
        if (element.text() !== itemConfig[field]) {
            element.html(itemConfig[field]);
        }
    }
}

function do_print(id, filter) {
    var form_filter = $(filter);
    var source = $('#' + id).attr('data-source');

    form_filter.attr('action', source);
    form_filter.attr('target', '_blank');

    // 
    form_filter.submit();

    form_filter.attr('action', '');
}

function _s2_image(e) {
    return e.id ? "<img style='padding-right:10px;' src='" + e.icon.toLowerCase() + "'/>" + e.text : e.text
}

function select2_image(id) {
    $("#" + id).select2({searchable: false, formatResult: _s2_image, formatSelection: _s2_image, escapeMarkup: function(e) {
            return e;
        }});
}

function _s2_icon(e) {
    return "<i class='" + e.text + "'></i> " + e.text
}

function select2_icon(id) {
    $("#" + id).select2({searchable: false, formatResult: _s2_icon, formatSelection: _s2_icon, escapeMarkup: function(e) {
            return e;
        }});
}

function tooltip() {
    var tooltips = function() {
        $('a.btn-tooltip').mouseenter(function() {
            $(this).tooltip('show');
        }).mouseleave(function() {
            $(this).tooltip('hide');
        });
    };
    return tooltips;
}
function setnumeric() {
    var numerics = function() {
        $('.numeric').numeric();
    };
    return numerics;
}



/* Start : Tools Filter */
function reset_filter(id) {
    var btn_id = '#' + id;
    var frm = $(btn_id).attr('data-filter');
    var table = $(btn_id).attr('data-table');
    var cb = $(btn_id).attr('data-callback');

    $('#' + frm)[0].reset();
    $("select").trigger("liszt:updated");

    var callback = function() {
    };
    if (cb !== '') {
        eval('(callback = window.' + cb + ')');
    }

    load_table(table, 1, callback);
}

function tools_filter(id, table, callback) {
    var frm_id = id.replace(/#/g, "");

    var cb = '';
    if (typeof callback !== 'undefined') {
        cb = 'callback_' + frm_id;
        eval('(window.' + cb + ' = callback)');
    }

    var t = '';
    t += '<div id="box-message-' + frm_id + '" class="box-message-filter" style="display: none;">';
    t += '  Untuk menampilkan filter data silahkan klik tombol <strong>Show Filter</strong> !';
    t += '</div>';
    t += '<div id="button-' + frm_id + '" class="box-filter-button" style="margin-top:2px;">';
    t += '  <a href="javascript:void(0);" id="button-reset-' + frm_id + '" class="freset" data-filter="' + frm_id + '" data-table="' + table + '" data-callback="' + cb + '" onclick="reset_filter(this.id)"><i class="icon-undo" ></i> Reset Filter &nbsp;</a>';
    t += '  <a href="javascript:void(0);" id="button-showhide-' + frm_id + '" class="fhide" data-filter="' + frm_id + '" onclick="fshowhide(this.id)"><i class="icon-circle-arrow-up"></i> Hide Filter</a>';
    t += '</div>';

    $('#box-message-' + frm_id).remove();
    $('#button-' + frm_id).remove();
    $('#' + frm_id).after(t);
}

function fshowhide(id) {
    var btn_id = '#' + id;
    var cls = $(btn_id).attr('class');
    var frm = $(btn_id).attr('data-filter');
    var box_message = 'box-message-' + frm;
    var btn_reset = 'button-reset-' + frm;
    if (cls === 'fhide') {
        $(btn_id).attr('class', 'fshow');
        $(btn_id).html('<i class="icon-circle-arrow-down"></i> Show Filter');
        $('#' + frm).hide();
        $('#' + btn_reset).hide();
        $('#' + box_message).show();
    } else {
        $(btn_id).attr('class', 'fhide');
        $(btn_id).html('<i class="icon-circle-arrow-up"></i> Hide Filter');
        $('#' + frm).show();
        $('#' + btn_reset).show();
        $('#' + box_message).hide();
    }
}
/* End : Tools Filter */

